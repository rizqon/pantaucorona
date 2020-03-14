<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Kasus extends Model
{
    use Notifiable;
    
    protected $table = 'kasus';

    protected $fillable = [
        'total_case',
        'new_case',
        'total_death',
        'new_death',
        'total_recovered',
        'active_case',
        'critical_case'
    ];
}
