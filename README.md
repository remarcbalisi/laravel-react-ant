Requirements

`PHP 7.4.12`

Installation

`composer install`

`rename .env.example to .env`

`change database name`

`php artisan migrate --seed`

`php artisan passport:install`

`copy personal client id; paste to PASSPORT_PERSONAL_ACCESS_CLIENT_ID`

`copy personal cient secret; paste to PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET`

Unit Testing

`php artisan test`

If you encounter error running unit test in windows, comment this line from phpunit.xml

``
<server name="DB_CONNECTION" value="sqlite"/>
``

``
 <server name="DB_DATABASE" value=":memory:"/>
``
