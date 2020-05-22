## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# test2x3Global

# To run

1. Clone repository
2. cd into your project
3. Install composer dependencies with the command line "composer install"
4. Copy the .env.example file and create .env file in the same directory
5. Generate an app encryption key with the command line "php artisan key:generate"
6. Create an empty database and user for our application, use the dbCreation.txt file to do this.
7. Migrate the database with the command line "php artisan migrate"
8. Seed the database for clients with the command line "php artisan db:seed"
9. Run server with the command line "php artisan serve"

# Endpoint

GET /api/clients -> Get all clients
GET /api/payments?client={id} -> Get all payments by client
POST /api/payments -> Create a payment
POST /api/pay -> Update status and payment date a payment

# Examples data to sent in POST methods

POST /api/payments
Example:
{
"expires_at": "2020-02-26",
"status": "pending",
"user_id": 4
}

POST /api/pay
Example:
{
"uuid": "d163ee77-7c4a-4f45-be5f-84dd232127d7"
}
