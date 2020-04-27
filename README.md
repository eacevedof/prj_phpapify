# prj_phpapify
## Actualizado: 27/04/2020
Generador de scripts de importación

```js
cd /c/proyecto/prj_phpapify/backend

php /c/programas/composer/composer.phar update

php -S localhost:3000 -t backend/public
```

```js
php run.php --class=a.b.c --method=some --params=a--a
php run.php --class=App.Controllers.NotFoundController
php run.php --class=App.Services.RamdomizerService
php run.php --class=App.Services.RamdomizerService --method=get_date_ymd --cSep="//"
php run.php --class=App.Services.Dbs.AgregacionService --method=run
php run.php --class=App.Services.Dbs.SchemaService --method=get_tables
```

```js
php run.php --class=App.Services.Dbs.SchemaService --method=get_tables_info --sTables=insertion_orders,bigdata_banners,bigdata_placements,super_black_list,line_items,insertion_orders_placement_type,insertion_orders_placement_tactic,pmp_deals,pmp_deals_placements
```

# COMPOSER EN IONOS
- hay que ejecutar el ionos.sh
- despues lanzar la siguiente linea:
    - esto da error: `php composer.phar`
    ```
    parse error</b>: syntax error, unexpected T_STRING in composer.phar</b> on line <b>102</b><br />
    ```
    - con esta funciona:
    - `/usr/bin/php7.1-cli -d 'memory_limit=-1' ~/composer.phar update -o --ignore-platform-reqs`
    - sacado de [aqui](https://www.ionos.com/community/hosting/php/using-php-composer-in-11-ionos-webhosting-packages/)
        