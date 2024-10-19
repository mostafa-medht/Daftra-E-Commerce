# Daftra-E-Commerce

Daftra E-Commerce designed & developed to submit order with products has the following applied:-

1. Authentication system with laravel sanctum.
2. Bearer authentication token.
3. Error handling & failure handling with rollback
4. Add Event & listener to dispatch events.
5. Apply service classes for business login.
6. Applied SOLID principle to make project with clean architecture.
7. Feature test covering key functionality. 

## Run the project

1. Clone repository

    ```
        1.1- git clone https://github.com/mostafa-medht/Daftra-E-Commerce.git
        1.2- cd project-directory
        1.3- composer install
        1.4- cp .env.example .env
        1.5- php artisan key:generate
    ```

2. Database
   2.1 Create database in DBMS via this query

    ```sql - mysql
        create database `daftra`;
    ```

   2.3 Database Configuration in .env file in application root

    ```
        DB_DATABASE=daftra
        DB_USERNAME=
        DB_PASSWORD=
        Put your database user after DB_USERNAME, and your user password after DB_PASSWORD
    ```

   2.4 Migrate & seed

    ```
        php artisan migrate
        php artisan db:seed

        or

        php artisan migrate --seed
    ```

   2.5 Run the project

    ```
        php artisan serve
    ```

   2.6 Use Admin username&password

    ```
        username : admin@example.com,
        password : 12345678
    ```

---

## Contributing

-   [Mostafa Medhat](https://github.com/mostafa-medht)

## When contributing to this repository, please first discuss the change you wish to make via issue.

## Contributing Guidelines

1. **Create** a new issue discussing what changes you are going to make.
2. **Fork** the repository to your own Github account.
3. **Clone** the project to your own machine.
4. **Create** a branch locally with a succinct but descriptive name.
5. **Commit** Changes to the branch.
6. **Push** changes to your fork.
7. **Open** a Pull Request in

---

## Resources

1. **Laravel-11** (https://laravel.com/docs/11.x)

2. **Laravel-Sanctum** (https://laravel.com/docs/11.x/sanctum)

## License

Daftra E-Commerce project Copyright © 2024 Mostafa Medhat. It is an open software and.
