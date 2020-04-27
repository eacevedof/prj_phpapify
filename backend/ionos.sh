# https://www.ionos.com/community/hosting/php/using-php-composer-in-11-ionos-webhosting-packages/

php -v
# PHP 4.4.9 (cgi-fcgi) (built: Nov  7 2018 13:27:00)
# Copyright (c) 1997-2008 The PHP Group
# Zend Engine v1.3.0, Copyright (c) 1998-2004 Zend Technologies

/usr/bin/php7.3-cli -v
# PHP 7.3.25 (cli) (built: Dec 10 2018 10:11:36) ( NTS )
# Copyright (c) 1997-2018 The PHP Group
# Zend Engine v3.1.0, Copyright (c) 1998-2018 Zend Technologies

curl -sS https://getcomposer.org/installer | /usr/bin/php7.3-cli
# All settings correct for using Composer
# Downloading...
# Composer (version 1.8.0) successfully installed to: /homepages/xx/xxxxxxxxxx/htdocs/composer.phar
# Use it: php composer.phar

wget -O drush.phar https://github.com/drush-ops/drush-launcher/releases/download/0.6.0/drush.phar
chmod +x drush.phar
/usr/bin/php7.3-cli drush.phar self-update
/usr/bin/php7.3-cli composer.phar global require drush/drush:"<9"

echo "alias php='/usr/bin/php7.3-cli'" >> ~/.bash_profile
echo "alias composer='php ~/composer.phar'" >> ~/.bash_profile
echo "alias drush='php ~/drush.phar'" >> ~/.bash_profile
echo "export DRUSH_LAUNCHER_FALLBACK='/usr/bin/php7.3-cli ~/.composer/vendor/bin/drush'" >> ~/.bash_profile
. ~/.bash_profile

php -v
# PHP 7.3.25 (cli) (built: Dec 10 2018 10:11:36) ( NTS )
# Copyright (c) 1997-2018 The PHP Group
# Zend Engine v3.1.0, Copyright (c) 1998-2018 Zend Technologies

drush --version
# Drush Launcher Version: 0.6.0
# Drush Version: 8.1.18

composer --version
# Composer version 1.8.0 2018-12-03 10:31:16