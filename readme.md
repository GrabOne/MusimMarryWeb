
## Link POST MAN
#### 2/2/2015
```
https://www.getpostman.com/collections/c9d557215f312f0545a9
```
## API
### 1. Login with social account: facebook_id || google_id || twitter_id 
```
POST /api/v1/login-social HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "nickname":"Phạm Văn Hiệu",
    "email":"pvh8692@gmail.com",
    "avatar":"http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
    "age":"23",
    "gender":"men",
    "birthday":"1992-06-08",
    "facebook_id":"fb_id",
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
'nickname'    => 'max:40|',
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
        "nickname": "Phạm Văn Hiệu",
        "email": "pvh8692@gmail.com",
        "age": "23",
        "birthday": "1992-06-08",
        "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
        "remember_token": "$2y$10$Yod64s7q3Z0nSl6CDB1oB.Wt1.aV2LvnxNsif.jy7wtfvVAe1jAFG",
        "location": {
            "country": "vietname",
            "city": "hanoi",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "gender": "men",
        "facebook_id": "124213421342142134124",
        "is_social": true,
        "occupation": "",
        "height": "",
        "language": [],
        "promocode": "OwwnvN",
        "_id": "54d3eaa7bffebc3a127b23c6"
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
    "gender":"men",
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
        "username": "thanchet",
        "nickname": "",
        "email": "phamvanhieu@gmail.com",
        "age": "23",
        "gender": "men",
        "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
        "location": {
            "country": "vietname",
            "city": "hanoi",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "remember_token": "$2y$10$BLmSl4hONPB.iIhG3oYTgeIt76lSEDW8ncxMAY7FECx8x8heHsjSS",
        "occupation": "",
        "height": "",
        "language": [],
        "promocode": "wFu2cQ",
        "_id": "54d3f540bffebc1e0e7b23c6"
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
        "_id": "54d3eb03bffebcde0e7b23c6",
        "username": "thanchet",
        "nickname": "",
        "email": "phamvanhieu@gmail.com",
        "age": "23",
        "gender": "men",
        "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
        "location": {
            "country": "vietname",
            "city": "hanoi",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "remember_token": "$2y$10$eWXaYB8JbiPREH6rytDRvO0uvcPA8rU9awGvtuiepYUpnZ9W3NWjO",
        "occupation": "",
        "height": "",
        "language": [],
        "promocode": "g8XdFR"
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
  "user_id":"54d3eaa7bffebc3a127b23c6",
  "remember_token":"$2y$10$Yod64s7q3Z0nSl6CDB1oB.Wt1.aV2LvnxNsif.jy7wtfvVAe1jAFG",
  "nickname":"Hiệu PV",
  "birthday":"1992-08-08",
  "occupation":"Coder",
  "height":"1.75",
  "city":"HN",
  "language":["Vietnamese"]
}
```
##### Regex
```
'nickname'   => 'max:40|min:2',
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
        "_id": "54d3eaa7bffebc3a127b23c6",
        "nickname": "Hiệu PV",
        "email": "pvh8692@gmail.com",
        "age": "23",
        "birthday": "1992-08-08",
        "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
        "remember_token": "$2y$10$Yod64s7q3Z0nSl6CDB1oB.Wt1.aV2LvnxNsif.jy7wtfvVAe1jAFG",
        "location": {
            "country": "vietname",
            "city": "HN",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "gender": "men",
        "facebook_id": "124213421342142134124",
        "is_social": true,
        "occupation": "coder",
        "height": "1.75",
        "language": [
            "vietnamese"
        ],
        "promocode": "OwwnvN"
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
    "user_id":"54d3ebb0bffebc3b127b23c6",
    "remember_token":"$2y$10$4YvQrusDw2jLwfviPcDzquBxe6j.6hh0hIgigF/yxwSWmQwSavQti",
    "username":"pvhieu",
    "nickname": "Devil",
    "birthday":"1992-08-06",
    "occupation":"coder :D",
    "height":"1.75",
    "city":"HN :D",
    "language":["vietnamese"],
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
        "username": "pvhieu",
        "nickname": "Devil",
        "email": "phamvanhieu@gmail.com",
        "age": "23",
        "gender": "men",
        "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
        "location": {
            "country": "vietname",
            "city": "HN :D",
            "coordinates": {
                "lat": "17.000",
                "lng": "104.0000"
            }
        },
        "remember_token": "$2y$10$4YvQrusDw2jLwfviPcDzquBxe6j.6hh0hIgigF/yxwSWmQwSavQti",
        "occupation": "coder :d",
        "height": "1.75",
        "language": [
            "vietnamese"
        ],
        "promocode": "YCjWp4",
        "_id": "54d3ebb0bffebc3b127b23c6",
        "birthday": "1992-08-06"
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
{
  "user_id":"54d3ebb0bffebc3b127b23c6",
  "remember_token":"$2y$10$4YvQrusDw2jLwfviPcDzquBxe6j.6hh0hIgigF/yxwSWmQwSavQti",
  "gender":"men",
  "age":{
            "from":"18",
            "to":"21"
        },
  "distance":{
            "from":"1",
            "to":"10"
        },
  "language":["english","vietnamese"],
  "occupations":["coder","designer"],
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
            "_id": "54d3eaa7bffebc3a127b23c6",
            "age": "23",
            "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
            "birthday": "1992-08-08",
            "email": "pvh8692@gmail.com",
            "gender": "men",
            "height": "1.75",
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
            "occupation": "coder",
            "promocode": "OwwnvN",
            "distance": 6.9569
        },
        {
            "_id": "54d3ebb0bffebc3b127b23c6",
            "age": "23",
            "avatar": "http://muslimmarry.dev/upload/avatar/1421531678-774-155x100.jpg",
            "birthday": "1992-08-06",
            "email": "phamvanhieu@gmail.com",
            "gender": "men",
            "height": "1.75",
            "language": [
                "vietnamese"
            ],
            "location": {
                "country": "vietname",
                "city": "HN :D",
                "coordinates": {
                    "lat": "17.000",
                    "lng": "104.0000"
                }
            },
            "occupation": "coder :d",
            "promocode": "YCjWp4",
            "username": "pvhieu",
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
### 13. GET Occupation
```
GET /api/v1/occupation HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache
```
##### Result
```
{
    "status": "success",
    "data": [
        {
            "_id": "54d3f38dbffebc6a148b4567",
            "name": "teacher"
        },
        {
            "_id": "54d3f38dbffebc6a148b4568",
            "name": "doctor"
        },
        {
            "_id": "54d3f38dbffebc6a148b4569",
            "name": "student"
        }
    ]
}
```
### 14. Get Language 
```
GET /api/v1/language HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache
```
##### Result
```
{
    "status": "success",
    "data": [
        {
            "_id": "54d4015dbffebc45168b456d",
            "name": "english"
        },
        {
            "_id": "54d4015dbffebc45168b456e",
            "name": "german"
        }
    ]
}
```
### 15. Block User
```
POST /api/v1/block-user HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{ 
    "user_id":"54d49e3893d9b7245c7b23c7", 
    "remember_token":"$2y$10$T7rqDlBEYPvq9ucBaC6wEemO/agLLX5Zs0zJjUaEavX5ewQrsSaES", 
    "user_block_id":"54d3338593d9b79f7b7b23c6", 
    "type": 2 // type = 1 block 30 day, type = 2 block permanently
}
```
##### Result
```
{
    "status": "success"
}
```
### 16. Report User
```
POST /api/v1/report-user HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{
    "user_id":"54d49e3893d9b7245c7b23c7",
    "remember_token":"$2y$10$T7rqDlBEYPvq9ucBaC6wEemO/agLLX5Zs0zJjUaEavX5ewQrsSaES",
    "user_report_id":"54d3338593d9b79f7b7b23c6",
    "reason_id":"54d65fe1bffebca00e8b4572" // có thể bỏ trường này, 
}
```
##### Result
```
{
    "status": "success"
}
```
### 17.get report reason // dùng khi sau này app có thể thêm lí do report
```
GET /api/v1/ HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache
```
##### Result
```
{
    "status": "success",
    "data": [
        {
            "_id": "54d65fe1bffebca00e8b4572",
            "reason": "He/She is spammer"
        },
        {
            "_id": "54d65fe1bffebca00e8b4573",
            "reason": "I don't like him/her"
        }
    ]
}
```