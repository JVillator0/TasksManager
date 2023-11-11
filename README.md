# Task Manager

This is a project developed with Laravel Sail and Vue.js.

## Prerequisites

Make sure you have the following requirements installed on your machine:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [PHP](https://www.php.net/) >= 8.2

## Environment Setup

1. Copy the `.env.example` file and rename it to `.env`.
2. Update the environment variables in the `.env` file as needed.


## Installation

Run the following commands to install dependencies and set up the environment:

```bash
# Install laravel dependencies to run the application
composer install
```

## Running the Application
To run the application, use Laravel Sail. Run the following command:

```bash
# up the application
./vendor/bin/sail up

# Install npm dependencies and build the application
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

# Generate the application key
./vendor/bin/sail php artisan key:generate

# Run migrations and seed the database
./vendor/bin/sail php artisan migrate --seed
```
This will start and configure the necessary Docker containers to run the application.

Once the containers are up and running, you can access the application at http://localhost:8081

## Stopping the Application
To stop the application and Docker containers, you can press Ctrl + C in the terminal where sail up is running.

If you want to remove the containers after stopping the application, you can run:

```bash
./vendor/bin/sail down
``````
