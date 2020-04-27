# Apify

## Endpoints
```js
/apify/contexts
/apify/contexts/{id}
/apify/dbs/{id_context}
/apify/tables/{id_context}/{dbname}
// /apify/tables/{id_context} -- todas las tablas de un contexto?? de momento no
/apify/fields/{id_context}/{dbname}/{tablename}/{fieldname}
/apify/fields/{id_context}/{dbname}/{tablename}

//custom query
/apify/read/raw
/apify/read
/apify/write/raw
/apify/write
```

## Ejemplos
- /apify/contexts
    - [http://localhost:3000/apify/contexts](http://localhost:3000/apify/contexts)
- /apify/contexts/{id}
    - [http://localhost:3000/apify/contexts/devlocal](http://localhost:3000/apify/contexts/devlocal)
- /apify/dbs/{id_context}    
    - [http://localhost:3000/apify/dbs/devlocal](http://localhost:3000/apify/dbs/devlocal)
- /apify/tables/{id_context}/{dbname}
    - [http://localhost:3000/apify/tables/devlocal/db_killme](http://localhost:3000/apify/tables/devlocal/db_killme)
- /apify/tables/{id_context}
    - falta: todas las tablas de un contexto
- /apify/fields/{id_context}/{dbname}/{tablename}
    - [http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation](http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation)
- /apify/fields/{id_context}/{dbname}/{tablename}/{fieldname}    
    - [http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation/op_d1](http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation/op_d1)

## Contextos
```json

```