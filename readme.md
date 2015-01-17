
## Link POST MAN
```

```
## API
### Login with social account: facebook_id || google_id || twitter_id 
```
POST /api/v1/login-social HTTP/1.1
Host: muslimmarry.dev
Content-Type: application/json
Cache-Control: no-cache

{"username":"Phạm Văn Hiệu","email":"pvh8692@gmail.com","age":"23","gender":"male","birthday":"1992-06-08","location":{"country":"vietname","city":"hanoi","coordinates":{"lat":"17.000","lng":"104.0000"}},"facebook_id":1111}
```
#### Return
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
        "facebook_id": 1111,
        "is_social": true,
        "accupation": "",
        "height": "",
        "language": [],
        "_id": "54bad1e5bffebc7d0b8b4568"
    }
}
```