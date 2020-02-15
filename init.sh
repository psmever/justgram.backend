# /bin/zsh

php artisan migrate:refresh --seed
php artisan passport:install --force
php artisan optimize
composer dump-autoload


# test.
