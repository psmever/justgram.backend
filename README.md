# JsutGram.Backend

## Installation

Use the package manager [pip](https://pip.pypa.io/en/stable/) to install foobar.

```bash
echo "# justgram.backend" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin https://github.com/psmever/justgram.backend.git
git push -u origin master
```

### Git Clone

```bash
git clone https://github.com/psmever/justgram.backend.git Backend
```

## Composer
```bash
composer install

```

## First Config
```bash
cp .env.example .env
sh init.sh

```


## Config
```bash
php artisan config:clear
php artisan config:cache
composer dump-autoload

php artisan route:cache

php artisan cache:clear

php artisan migrate:refresh --seed


php artisan optimize
composer dump-autoload

php artisan optimize && composer dump-autoload

```

## Usage

```bash
php artisan serve
```

## Browser
```bash
http://127.0.0.1:8000 || http://localhost:8000/
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
