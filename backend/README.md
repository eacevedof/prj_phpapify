### Access
- Access involves 2 files:
  - login.json
    - Every source (domain and/or host) have to exist in this file as domain key
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
  - POST
    - Origin *Needed to obtain the salt key by source*
    - word  *Any text that will be converted in a hash token. This token must be placed in login.json*
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
    - user *user in login.sjon*
    - password *password in login.json*
    - REMOTE_HOST | Origin *domain in login.json*
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
    - remotehost *similar to origin in common login endpoint*
