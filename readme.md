# Instalation

## 1. Clone the repository to directory where the project will be hosted
```
git clone
```
## 2. Install all the dependencies using composer
```
composer install
```
## 3. Copy the example env file and make the required configuration changes in the .env file
```
cp .env.example .env
```
## 4. Generate a new application key
```
php artisan key:generate
```
## 5. Set .env locals such as DB_DATABASE, APP_ENV, etc. Set to .env test credentials for Payson
```
PAYSON_AGENT_ID=3533
PAYSON_API_KEY=4e5eaa1d-a2a0-4b11-a034-8ef46d20fa0c
```
## 6. Run the database migrations
```
php artisan migrate
```
## 7. Populate the database with seed
```
php artisan db:seed
```
## 9. Done
