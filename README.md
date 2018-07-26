# Slim 3 Authentication boilerplate

This is a simple Slim 3 skeleton to quickly get started building your Slim 3 applications.

The project was designed to easily run on shared webhosts so by default there is no `public` directory. But, If you do have access to a commandline I would encourage you to change this over.

**This setup includes:**

- Dependency Injection
- Twig templates
- Eloquent ORM
- Easy form validation
- Phinx migrations
- Basic authentication
- CSRF protection middleware
- Config helper
- Symfony var dumper

### Installation

Clone the repo
```
git clone https://github.com/fritsvt/slim3-auth-boilerplate.git
```

cd into your project dir
```
cd slim3-auth-boierplate
```

Install all the required dependencies
```
composer install
```

Edit your config after running this command
```
cd bootstrap && cp config.example.php config.php
```

Run your DB migrations
```
php phinx migrate
```

Serve the web app
```
php -S localhost:8000
```

### Dependencies

This boilerplate setup uses the following composer dependencies:

- slim/slim
- slim/twig-view
- slim/flash
- slim/csrf
- php-di/slim-bridge
- symfony/var-dumper
- robmorgan/phinx
- illuminate/database
- respect/validation
- google/recaptcha