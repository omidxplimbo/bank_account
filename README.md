# Laravel Bank Account Project

This project has been created for test
## Installation

First clone this repository, install the dependencies, and setup your .env file.

```
git clone https://github.com/omidxplimbo/bank_account.git
composer install
cp .env.example .env
```

And run the initial migrations and seeders.

```
php artisan migrate --seed 
```

## Route Lists

- Post /api/accounts ---> create account
- Get /api/accounts/{id} ---> get account
- Get /api/accounts/{id}/transfers ---> get transfer history for account
- Post /api/transfers ---> create transfer
