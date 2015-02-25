### Install 
```
http://laravel.com/docs/5.0
```
```
git clone https://github.com/GrabOne/MusimMarryWeb
```
```
composer install
```
```
/app/config/database.php

	'mysql' => array(
		'driver'    => 'mysql',
		'host'      => 'host',
		'database'  => 'databasename',
		'username'  => 'username',
		'password'  => 'password',
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	),
```

### API
**REGISTER**

```
#!php

POST /api/v1/register HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

{"username": "thanchet","email": "thanchet@grabone.de","password": "user_password"}

VALIDATE
'username' => ['required','min:3','max:30','regex:/^[a-zA-Z0-9-_]+$/'],
'email'    => ['required','email','max:40']
'password' => ['required','min:8']
```


**LOGIN**

```
#!php

POST /api/v1/login HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

{"email": "user@grabone.de","password": "user_password"}

VALIDATE

'email'    => ['required','email','max:40'],
'password' => ['required','min:8']
```


**DEALS**

```
#!php

GET /api/v1/deals?page={number_of_page} HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache
```
**DEALS AVAILABLE**

```
#!php

GET /api/v1/deals-available?page=1 HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache
```

**RATE A DEAL**

```
#!php

POST /api/v1/rate-deal HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

{"user_id": "9","remember_token": "1d4c1124554af651ba3e23dde0831a97","deal_id": "1","number_star": "5"}

VALIDATE

'user_id'        => ['required','regex:/^[0-9]+$/'],
'remember_token' => ['required','regex:/^[a-zA-Z0-9]+$/'],
'deal_id'     => ['required','regex:/^[0-9]+$/'],
'number_star' => ['required','regex:/^[0-9]+$/'],
```
**CHECK RATED**

```
#!php

GET /api/v1/check-rated/{user_id}/{deal_id} HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

```
**SEARCH NEAR ME**

```
#!php

POST /api/v1/search HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

{"type":"2","distance":"10000","lat": "21.032273","lng": "105.7950881","skip":"2","take":"20"}

VALIDATE

'distance' => ['required','regex:/^[0-9\.]+$/'],
'lat'      => ['required','regex:/^[0-9\.]+$/'],
'lng'      => ['required','regex:/^[0-9\.]+$/'],
'skip'     => ['required','regex:/^[0-9]+$/'],
'take'     => ['required','regex:/^[0-9]+$/']
```
**SEARCH WITH POSTCODE**

```
#!php

POST /api/v1/search HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

{"type":"1","postcode":"10000","skip":"1","take":"2"}
```
**SEARCH WITH LOCATION ID**

```
#!php
POST /api/v1/search HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

{"type":"3","location_id":"1","skip":"0","take":"20"}

```
**SEARCH WITH STATE ID**

```
#!php

POST /api/v1/search HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

{"type":"4","state_id":"1","skip":"0","take":"2"}
```
**LIST LOCATION**

```
#!php

GET /api/v1/location HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

```
**LIST LOCATION AND STATE**

```
#!php

GET /api/v1/location-state HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache

```
**LIST CATEGORY**

```
#!php

GET /api/v1/categories HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache
```


**DEAL IN CATEGORY**

```
#!php

GET /api/v1/categories/{category_id}?page={page_number} HTTP/1.1
Host: grabone.dev
Content-Type: application/json
Cache-Control: no-cache
```
