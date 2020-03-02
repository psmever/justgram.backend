# /bin/zsh
php artisan config:clear
php artisan config:cache
php artisan migrate:refresh --seed
php artisan passport:install --force
php artisan optimize
composer dump-autoload
