# JsutGram.Backend

### Git First Push.
Use the package manager [composer](https://getcomposer.org/) to install foobar.


```bash
echo "# justgram.backend" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin https://github.com/psmever/justgram.backend.git
git push -u origin master
```

## Git Clone.

```bash
git clone https://github.com/psmever/justgram.backend.git Backend
```

## Composer.
```bash
composer install

```

## First Config.
```bash
cp .env.example .env
sh init.sh

```


## 기타 설정.
```bash
php artisan config:clear
php artisan config:cache
composer dump-autoload

php artisan route:cache

php artisan cache:clear

php artisan migrate:refresh --seed


php artisan optimize
composer dump-autoload

php artisan config:clear && php artisan optimize && composer dump-autoload

```

## Local Develop Server.
```bash
php artisan serve
```

## Browser.
```bash
http://127.0.0.1:8000 || http://localhost:8000/
```

### laravel Testing
```bash
php artisan config:cache --env=testing
php artisan migrate:refresh --env=testing --database=sqlite_testing
composer test
./vendor/bin/phpunit --testdox --process-isolation tests
./vendor/bin/phpunit-watcher watch --stop-on-failure
```

### Factory
```bash
php artisan make:factory UserMasterFactory --model=Model/JustGram/UsersMaster
php artisan make:factory CloudinaryImageMasterFactory --model=Model/JustGram/CloudinaryImageMaster
php artisan make:factory UserProfilesFactory --model=Model/JustGram/UserProfiles
```

## Heroku Dep

```bash
heroku config:set LARAVEL_COMMANDS='php artisan migrate:refresh --seed && php artisan passport:install'
heroku run php artisan migrate:refresh --seed
heroku run php artisan passport:install
```

## usen email auth
```bash
http://localhost:8000/front/v1/auth/email_auth?code=mMtsNk8aEOc6VHqwqJVgiCiAk0dVpkzQmIvAo8YasNBVub7if5XWBsy650DITHbL4onse2idPmI7JcwX
```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
