1- create file .evn in path project
### File .env

```php
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:FF13kD/HFRhvRP+R9iKRa4boxqdoBWv2zahhVAC5Ndw=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movies
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

JWT_SECRET=wXMkigXnijzdilDFjIH8ORfauoj2lcEN
```
2- create database 'moives'

3- run command in termianl
```shell
php artisan migrate // create database
php artisan db:seed // dumy data
```

4- run test in command in path project 
```shell
phpunit
```

Links Apis Document
<a href="https://documenter.getpostman.com/view/1330523/RzfniRot" >Here </a>