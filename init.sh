# /bin/zsh

php artisan migrate:refresh --seed 
php artisan passport:install --force
php artisan optimize 
/usr/local/bin/composer.phar dump-autoload
