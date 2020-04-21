# pantaucorona.xyz

pantaucorona.xyz adalah sebuah aplikasi untuk tracking virus korona yang ada di indonesia. aplikasi ini menggunakan Laravel 7.x. notifikasi update kasus via channel telegram [@pantaucorona](https://t.me/pantaucorona)

![alt text](https://i.imgur.com/Odi2s9G.png)
  
## Installation

gunakan [git](https://git-scm.com/) untuk mengunduh source dari repository ini 

```bash
git clone git@github.com:rizqon/pantaucorona.git
```

update package [composer](https://getcomposer.org/) yang ada dalam aplikasi ini
```bash
cd pantaucorona

composer install
```

jangan lupa buat migrasi databasenya ya.
```bash
php artisan migrate
```

tambahkan cronjob
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
````

## Test
```bash
phpunit
```

## Source
- [worldometer.info](https://www.worldometers.info/coronavirus/)

## Contributing
Just make pull request and you are in.

## License
[MIT](https://choosealicense.com/licenses/mit/)