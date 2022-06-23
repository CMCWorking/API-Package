# How to run

1. Clone this project to your PC
2. Use your CLI of choice, then move inside this project directory
3. Running below command to start using
```shell
docker-compose up -d
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```
4. Use your browser, and type `localhost` to the address bar

# API testing

Please use Postman and follow [this URL](https://documenter.getpostman.com/view/21583062/UzBpK64J) to test.

# TESTING account
- Email: `admin@email.com`
- Password: `123123123`

