# TinyMVC

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eliseekn/tinymvc.svg?style=flat-square)](https://packagist.org/packages/eliseekn/tinymvc)
[![Total Downloads](https://img.shields.io/packagist/dt/eliseekn/tinymvc.svg?style=flat-square)](https://packagist.org/packages/eliseekn/tinymvc)

TinyMVC is a PHP framework based on MVC architecture that helps you build easily and quickly powerful web applications and REST API.

## Requirements
```
PHP 8.1.x
MySQL/SQLite
Composer
Node
```

## Installation

1. Create new composer project

In your terminal :
```
composer create-project eliseekn/tinymvc project-name
```

2. Install packages dependencies

In your terminal :
```
cd ./project-name
yarn && yarn build
```

## Your first application

1. Setup application

In your terminal :
```
cp .env.example .env
php console app:setup
```

2. Setup database

In your terminal :
```
php console migrations:run --seed
```

3. Start a local server development

In your terminal :
```
php console serve
```
For more console commands :
```
php console list
```

## License
[MIT](https://opensource.org/licenses/MIT)

## Copyright
2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
