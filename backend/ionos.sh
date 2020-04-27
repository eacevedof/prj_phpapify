# https://www.ionos.com/community/hosting/php/using-php-composer-in-11-ionos-webhosting-packages/
php -v

/usr/bin/php7.1-cli -v

curl -sS https://getcomposer.org/installer | /usr/bin/php7.1-cli

echo "alias php='/usr/bin/php7.1-cli'" >> ~/.bash_profile
echo "alias composer='php ~/composer.phar'" >> ~/.bash_profile

php -v
composer --version
