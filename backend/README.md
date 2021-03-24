### Access
- Access involves 3 files:
  - login.json
    - Every source (domain and/or host) must exist in login.local.json as doamin key
    - Every source contains users with:
      - id 
      - user
      - password  
    - To create an encrypted password you can use [this tool](http://eduardoaf.com/servicios/probar-openssl-encrypt)
      - option = 0
      - iv = 99326425
      - You can get the rest in encdecrypt.json  

  - encdecrypt.json
    - Config file with params that will be used for password validation
    - Every source (domain and/or host) has an isolated encrypt configuration
      - domain
      - sslenc_method
      - sslenc_key
      - sslsalt

### login
- /apify/security/get-password
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
