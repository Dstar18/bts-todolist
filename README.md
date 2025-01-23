<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Technical Test Backend Engineer
Technical Test Backend Engineer Laravel (RestAPI), Use PHP Laravel to make the ToDoList and use MySQL to make the database.

Feature:
- Basic Auth Login API and encrypt like base64
```sh
"username": {email_user}
"password": {password_user}
```
- Login and logout User
- Checklist (Create, Update, Delete, Reads, Detail with items)
- Item (Create, Detail, Update(item/status), Delete)

## Instalation
```sh
git clone https://github.com/Dstar18/bts-todolist.git
```
```sh
cd bts-todolist
```
```sh
composer install
```
```sh
php artisan key:generate
```
```sh
cp .env-example .env
```
```sh
php artisan migrate
```

## Endpoint (Example)
**#Register User**
- Method: POST
- URL: {base_url}/api/register

Authentication:
- Type: Basic Auth
- Login: Not Required

Body:
```sh
{
    "firstname": "dedi",
    "lastname": "123",
    "email": "dedi@gmail.com",
    "password": "dedi12345"
}
```

**#Login User**
- Method: POST
- URL: {base_url}/api/login

Authentication:
- Type: Basic Auth
- Login: Not Required

Body:
```sh
{
    "email" : {email},
    "password" : {password}
}
```

**#Checklist Detail with items**
- Method: GET
- URL: {base_url}/api/checklist/{id}/item

Authentication:
- Type: Basic Auth
- Login: Required

Body:
```sh
No body required for this request
```

Response:
```sh
{
    "code": 200,
    "message": "Successfully",
    "data": {
        "id": 3,
        "title": "Pogramming",
        "is_completed": 0,
        "items": [
            {
                "name": "PHP",
                "status": 0
            }
        ]
    }
}
```
