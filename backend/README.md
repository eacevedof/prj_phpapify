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
  - Origin
  - word

### login
- /apify/security/login
  - POST 
    - user
    - password
    - REMOTE_HOST | Origin 
### login as middleware
- /apify/security/login-middle
  - POST 
    - user
    - password
    - remotehost *se mapea con origin*
