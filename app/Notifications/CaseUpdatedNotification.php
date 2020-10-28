<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CaseUpdatedNotification extends Notification
{
    use Queueable;

    protected $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $file = file_get_contents(base_path('keyword.txt'));
        $keywords = explode("\n", $file);
        $keyword = collect($keywords)->random();

        $url = 'api.giphy.com/v1/gifs/search';

        $response = Http::get($url, [
            'api_key' => config('services.giphy.key'),
            'q' => $keyword
        ]);

        $decode = json_decode($response->body());

        $collect = collect($decode->data);

        $data = $collect->random();

        return TelegramFile::create()
            ->to(config('services.telegram-bot-api.channel'))
            ->content("New Case Updated!\n".$this->message)
            ->animation($data->images->original->url)
            ->button('More Info', 'https://pantaucorona.xyz');
    }
}