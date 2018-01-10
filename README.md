# GroupRoomMaffia
![alt text](https://i.imgur.com/x0eYR7A.png)
A webpage for advanced and automated booking of group rooms at Mälardalen University (MDH)

#### Why?
Mälardalen University provides limited places to studdy.
The School has bookable group rooms that has to be booked in advance. 
For students the rooms can be booked one week in adanve, and gennerally you have to.
I originally created a command line tool in Swift to book and schedulle bookings. But I feel that a webpage makes more sence.

#### How?
The webpage is build using Laravel 5.5 and Bootstrap v4. It's hosted using a VPS from DigitalOcean whit cert from LetsEncrypt.
It comunicates to MDH's booking server using HTTP requests to thir website.

###### Using
* https://github.com/indrimuska/jquery-editable-select
* https://github.com/uxsolutions/bootstrap-datepicker
* https://github.com/laracasts/flash

## Functionalty
It's still a work in progress and currently provides equal functionality to mdh's website as well as the following:
* Abillity to unbook started bookings.
* Multiple users where each user can have multiple MDH session
* Session are kept alive 
* Schedulle bookings that are more than a week away
* Add friends
* Hilight your and your frinds bookings.
  
![alt text](https://i.imgur.com/uh8wl9x.png)

# Instalation

### Requirements
* PHP >= 7.1
* Composer

## Steps
1. Clone the repo and install dependencies
```bash
cd /var/www/
git clone https://github.com/Enari/GroupRoomMaffia.git
cd GroupRoomMaffia/
composer install
```

3. Copy `env.example` to `.env` and generate an application key. 
```bash
cp .env.example .env
php artisan key:generate
```

4. Edit the `.env` file with your enviorment comfiguration.

5. Migrate the database
```bash
php artisan migrate
```

7. Enable automatic polling of "MDH users sessions" by calling `php artisan schedule:run` using chron.
```
 sudo crontab -e
*  *    * * *  php /var/www/DVA313/kanbanboard/artisan schedule:run >> /dev/null 2>&1
```

8. Point you webserver to `GroupRoomMaffia/public`, note that mod_rewrite needs to be enabled.
