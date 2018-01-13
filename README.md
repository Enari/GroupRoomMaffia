[![Build Status](https://travis-ci.org/Enari/GroupRoomMaffia.svg?branch=master)](https://travis-ci.org/Enari/GroupRoomMaffia) [![StyleCI](https://styleci.io/repos/115630379/shield?style=flat)](https://styleci.io/repos/115630379/)

# GroupRoomMaffia
A webpage for advanced and automated booking of group rooms at Mälardalen University (MDH)
![alt text](https://i.imgur.com/QJPAaJj.png)

#### Why?
Mälardalen University provides limited places to studdy.
The School has bookable group rooms that has to be booked in advance. 
For students the rooms can be booked one week in advance, and generally you have to.
I originally created a command line tool in Swift to book and schedule bookings. But I feel that a webpage makes more sense.

#### How?
The webpage is build using Laravel 5.5 and Bootstrap v4. It's hosted using a VPS from DigitalOcean with a cert from LetsEncrypt.
It communicates with MDH's booking server using HTTP requests to thier website.

###### Using
* https://github.com/indrimuska/jquery-editable-select
* https://github.com/uxsolutions/bootstrap-datepicker
* https://github.com/laracasts/flash

## Functionality
It's still a work in progress and currently provides equal functionality to MDH's website as well as the following:
* Abillity to unbook started bookings.
* Multiple users where each user can have multiple MDH session
* Session are kept alive 
* Schedule bookings that are more than a week away
* Add friends
* Highlight your and your frinds bookings.
  
![alt text](https://i.imgur.com/uh8wl9x.png)

# Installation

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

enter `sudo crontab -e` and add th following line.

```
*  *    * * *  php /var/www/DVA313/kanbanboard/artisan schedule:run >> /dev/null 2>&1
```

8. Point you webserver to `GroupRoomMaffia/public`, note that mod_rewrite needs to be enabled.
