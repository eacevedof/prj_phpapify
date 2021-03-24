### Access
- Access involves 3 files:
  - login.json
    - Every source (domain and/or host) must exist in login.local.json as doamin key
    - Every source contains users with:
      - id 
      - user
      - password

  - encdecrypt.json
    - Config file with params that will be used for password validation
    - Every source (domain and/or host) has an isolated encrypt configuration
      - domain
      - sslenc_method
      - sslenc_key
      - sslsalt

### get a password 
- /apify/security/get-password
  - Origin *necesario para obtener la sal por origen*
  - word  *cualquier palabra que se devolverá cifrada. Esta habrá que colocarla en login.json*
```json
{
    "status": 1,
    "message": "",
    "links": [],
    "errors": [],
    "data": {
        "result": "$2y$10$EHXc47BuhSBD5QCOiUPgTurEbcfDbnsqNkYEQ8jA2.Tr4oDTc6RvK"
    },
    "included": []
}
```

### login
- /apify/security/login
  - POST 
    - user
    - password
    - REMOTE_HOST | Origin 
```json
{
    "status": 1,
    "message": "",
    "links": [],
    "errors": [],
    "data": {
        "token": "ZVVqeTQ0cUZldTBjNnFJTHkrdWJJWVRwR1FOTGdjdHVzcGJpUmI0SVlBRUxkZmxES2txY05rNHNxQU9wN1RmMSs3Tk9MTCtHeU1XT0hZdzUzVS9rT2toOEIyaDRMV3BLa3JVdEk4N3V2LzZTZ3hMZzh6Ulp3Zi9GQkpaWmlLRnZmank5QVJRY05FenU5WFFScStRVnZlQ2RzU0ZlTmZVWUVVbCt6SlF0YUtBPQ=="
    },
    "included": []
}
```
### login as middleware
- /apify/security/login-middle
  - POST 
    - user
    - password
    - remotehost *se mapea con origin*
