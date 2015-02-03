
## Link POST MAN
```

```
## API
### 1. Login with social account: facebook_id || google_id || twitter_id 
```
POST /api/v1/login-social HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "username":"Phạm Văn Hiệu",
    "email":"pvh8692@gmail.com",
    "avatar":"http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
    "age":"23",
    "gender":"male",
    "birthday":"1992-06-08",
    "facebook_id":"fb_id",
    "location":{
                "country":"vietname",
                "city":"hanoi",
                "coordinates":{
                                "lat":"17.000",
                                "lng":"104.0000"
                                }
                },
}
```
##### Regex
```
'username'    => 'required|max:40',
'email'       => 'required|max:40|email',
'age'         => 'regex:/^[0-9]+$/|max:2',
'birthday'    => 'YYYY-MM-DD',
'gender'      => 'regex:/(wo)?men/',
'facebook_id' => 'regex:/^[0-9]+$/|max:20|min:6'
```
##### Return
```
{
    "status": "success",
    "data": {
        "username": "Phạm Văn Hiệu",
        "email": "pvh8692@gmail.com",
        "age": "23",
        "birthday": "1992-06-08",
        "avatar": "",
        "remember_token": "$2y$10$CE0nHIQ.jrS/8NhaO00IOu82Tha134TMfap.XLxG5k.FDBuOGrmBy",
        "location": {
            "country": "vietname",
            "city": "hanoi",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "facebook_id": fb_id,
        "is_social": true,
        "accupation": "",
        "height": "",
        "language": [],
        "promocode": "code6",
        "_id": "54bad1e5bffebc7d0b8b4568"
    }
}
```
### 2. Signup With Normal Account
```
POST /api/v1/signup HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "username":"thanchet",
    "email":"phamvanhieu@gmail.com",
    "avatar":"http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
    "age":"23",
    "gender":"male",
    "password":"password",
    "location":{
                "country":"vietname",
                "city":"hanoi",
                "coordinates":{
                                "lat":"17.000",
                                "lng":"104.0000"
                                }
                }
}
```
##### Regex
```
'username'    => 'required|max:40|regex:/^[a-zA-Z0-9-_]+$/',
'email'       => 'required|max:40|email',
'age'         => 'regex:/^[0-9]+$/|max:2',
'birthday'    => 'YYYY-MM-DD',
'gender'      => 'regex:/(wo)?men/',
'password'    => 'required|min:6|max:40',
```
##### Return
```
{
    "status": "success",
    "data": {
        "username": "Thanchet",
        "email": "pvh@gmail.com",
        "age": "23",
        "gender": "male",
        "avatar": "",
        "location": {
            "contry": "vietname",
            "city": "hanoi",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "remember_token": "$2y$10$ZQnov14w6J5FNv2TFMirlOJZ/xl0CE/sEvCft2pFRInnbFFnAuJG.",
        "promocode": "code6",
        "_id": "54ba01d693d9b73c587b23c6"
    }
}
```
### 3. Login With Normal Account
```
POST /api/v1/login HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "username":"thanchet",
    "password":"password"
}
```
##### Regex
```
'username' => 'required|max:40|regex:/^[a-zA-Z0-9-_]+$/',
'password' => 'required|min:6|max:40',
```
##### Return
```
{
    "status": "success",
    "data": {
        "_id": "54bab860bffebc4e0b8b4567",
        "username": "thanchet",
        "email": "phamvanhieu@gmail.com",
        "age": "23",
        "gender": "male",
        "avatar": "",
        "location": [],
        "remember_token": "$2y$10$1mvPGAyV93dRRG1aJsnUPekNUCnssNpRP7wfxIS2psTAiWp2cQnp.",
        "accupation": "",
        "height": "",
        "language": [],
        "promocode": "code6",
    }
}
```
### 4. Edit Social Account
```
PUT /api/v1/edit-social-account HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "user_id":"54bab860bffebc4e0b8b4567",
    "remember_token":"$2y$10$1mvPGAyV93dRRG1aJsnUPekNUCnssNpRP7wfxIS2psTAiWp2cQnp.",
    "username":"Hiệu PV",
    "birthday":"1992-08-08",
    "occupation":"Coder",
    "height":"1.75",
    "city":"HN",
    "language":"Vietnamese"
}
```
##### Regex
```
'username'   => 'max:40|min:4',
'occupation' => 'max:100',
'height'     => 'regex:/^[0-9,\.]+$/|max:6',
'city'       => 'max:100',
'birthday'    => 'YYYY-MM-DD',
```
##### return
```
{
    "status": "success",
    "data": {
        "_id": "54bab860bffebc4e0b8b4567",
        "username": "Hiệu PV",
        "email": "phamvanhieu@gmail.com",
        "age": "23",
        "gender": "male",
        "avatar": "",
        "location": {
            "city": "HN"
        },
        "remember_token": "$2y$10$1mvPGAyV93dRRG1aJsnUPekNUCnssNpRP7wfxIS2psTAiWp2cQnp.",
        "accupation": "",
        "height": "1.75",
        "language": "Vietnamese",
        "birthday": "1992-08-08",
        "occupation": "Coder",
        "promocode": "code6",
    }
}
```
### 5. Upload Avatar
```
POST /api/v1/upload-avatar HTTP/1.1
Host: muslimmarry.dev
Cache-Control: no-cache
input name: 'image'
input type: 'file'
```
##### Return
```
{
    "status": "success",
    "url": "http://muslimmarry.dev/upload/avatar/1421531185-874-devices-selector-pixel.jpg"
}
```
### 6. Change User Avatar
```
PUT /api/v1/change-avatar HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "user_id":"54bab860bffebc4e0b8b4567",
    "remember_token":"$2y$10$1mvPGAyV93dRRG1aJsnUPekNUCnssNpRP7wfxIS2psTAiWp2cQnp.",
    "avatar":"http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg"
}
```
##### Return
```
{
    "status": "success"
}
```
### 7. Update normal account
```
PUT /api/v1/edit-normal-account HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "user_id":"54badaecbffebc7d0b8b4569",
    "remember_token":"$2y$10$rvuEpn6MxqmUupLrxijTcenpQSYsRyCVZd9CMQ7Pif3VEm1omMPP6",
    "username":"pvhieu",
    "birthday":"1992-08-06",
    "occupation":"coder :D",
    "height":"1.75","city":"HN :D",
    "language":"vnese",
    "password":"password"
}
```
##### Regex
```
'username'   => 'max:40|min:4|regex:/^[a-zA-Z0-9-_]/',
'birthday'   => 'date',
'occupation' => 'max:100',
'height'     => 'regex:/^[0-9,\.]+$/|max:6',
'city'       => 'max:100',
```
##### Return
```
{
    "status": "success",
    "data": {
        "_id": "54badaecbffebc7d0b8b4569",
        "username": "pvhieu",
        "email": "phamvanhieu@gmail.com",
        "age": "23",
        "gender": "male",
        "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
        "location": {
            "country": "vietname",
            "city": "HN :D",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "remember_token": "$2y$10$rvuEpn6MxqmUupLrxijTcenpQSYsRyCVZd9CMQ7Pif3VEm1omMPP6",
        "accupation": "",
        "height": "1.75",
        "language": "vnese",
        "birthday": "1992-08-06",
        "occupation": "coder :D",
        "promocode": "code6",
    }
}
```
### 8. Search
```
POST /api/v1/search HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{  
    "user_id":"54bed8fabffebc43128b4567",
    "remember_token":"$2y$10$I.oqq/3onRku8mUMKhU8r.sXekIUfjJzJrre6MzaYwBZQ.JmsZYPO",
    "gender":"women",
    "age":{"from":"18","to":"21"},
    "distance":{"from":"1","to":"10"},
    "language":[
                "english",
                "vietnamese"
                ],
    "occupations":[
                "coder",
                "designer"
                ],
    "height":{
                "from":"0",
                "to":"1.75"
            },
    "coordinates":{
                "lat":"17.100",
                "lng":"104.000"
            }
}
```
##### Regex
```
'gender' => 'regex:/(wo)?men/',
```
##### Return
```
{
    "status": "success",
    "data": [
        {
            "_id": "54beeedbbffebc4c128b4568",
            "occupation": "",
            "age": "23",
            "avatar": "User_avatar_url",
            "birthday": "1992-12-13",
            "email": "user_email@example.com",
            "height": "1.65",
            "language": [
                "vietnamese"
            ],
            "location": {
                "country": "vietname",
                "city": "HN",
                "coordinates": {
                    "lat": "17.100",
                    "lng": "104.0000"
                }
            },
            "promocode": "Xl3AiQ",
            "username": "Username",
            "distance": 2.2249
        },
        {
            "_id": "54beasfdbbff345c4c124f7fh8",
            "occupation": "",
            "age": "23",
            "avatar": "User_avatar_url",
            "birthday": "1992-12-13",
            "email": "user_email@example.com",
            "height": "1.65",
            "language": [
                "vietnamese"
            ],
            "location": {
                "country": "vietname",
                "city": "HN",
                "coordinates": {
                    "lat": "17.200",
                    "lng": "104.0000"
                }
            },
            "promocode": "CODE6_",
            "username": "Username",
            "distance": 6.9569
        }
    ]
}
```
### 9. Get User Profile 
```
GET /api/v1/profile/54beeedbbffebc4c128b4568 HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache
````
##### Result
```
{
    "status": "success",
    "data": {
        "_id": "54beeedbbffebc4c128b4568",
        "accupation": "",
        "age": "23",
        "avatar": "user_avatar_url",
        "birthday": "1992-12-13",
        "email": "email@example.com",
        "height": "1.65",
        "is_social": true,
        "language": [
            "vietnamese"
        ],
        "location": {
            "country": "vietname",
            "city": "HN",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "promocode": "Xl3AiQ",
        "username": "username"
    }
}
```
### 10. Check Username Exist
```
POST /api/v1/check-username-exist HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{"username":"thanchet"}
```
##### Result
```
{
    "status": "success",
    "data": {
        "exist": true // true if exist 
    }
}
```
### 11. Check Email Exist
```
POST /api/v1/check-email-exist HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{"email":"pvh8692@gmail.com"}
```
##### Result
```
{
    "status": "success",
    "data": {
        "exist": true // true if exist 
    }
}
```
### 12. Check Username & Email Exist
```
POST /api/v1/check-email-exist HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{"email":"pvh8692@gmail.com","username":"Thanchet"}
```
##### Result
```
{
    "status": "success",
    "data": {
        "username": {
            "exist": true
        },
        "email": {
            "exist": true
        }
    }
}
```