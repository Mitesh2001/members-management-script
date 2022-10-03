# Gym Management

Vigor - Your Online Gym Management System (Laravel 9, Bootstrap 4)

Please follow the installation instructions after you have uploaded the files to the server.

#### Steps For Installation
- Clone `.env.example` file with the name `.env` manually or use the command: `cp '.env.example' '.env'`
- Set variables in the `.env` file (Mainly: `APP_NAME`, `APP_URL`, and all the ones starting with `DB_` and `MAIL_` prefix)
- Install The Dependencies: `composer install`
- Generate Key: `php artisan key:generate --ansi`
- Migrate: `php artisan migrate`
- Link public assets directory: `php artisan storage:link`

An admin user will automatically be created with the migration command.
```
Username: admin
Password: 123456
```

#### Notes
- All the text on the web app is translatable with @lang blade directive or __() helper. That means that you can edit the files inside the `resources/lang` to display text in a different language.

#### Dummy data
Run the following command to insert dummy data into the database:
`php artisan db:seed`
