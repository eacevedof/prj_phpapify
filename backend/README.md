### Access
- Access involves 3 files:
  - login.json
    - Every source (domain and/or host) must exist in login.local.json as doamin key
    - Every source contains users 
  - encdecrypt.json

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
