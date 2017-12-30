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


## Functionalty
It's still a work in progress and currently provides equal functionality to mdh's website as well as the following:
* Abillity to unbook started bookings.
* Multiple MDH users
* Schedulle bookings that are more than a week away
  
![alt text](https://i.imgur.com/uh8wl9x.png)
