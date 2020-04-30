# Inphonex API
API responsible for applying the intelligence and business rules of the Inphonex project.

## Installation

### Clone

Execute the following command to get the latest version of the project:

```terminal
$ git clone --recursive git@github.com:phelipemomesso/Back-End-Recruiting-Test.git inphonex
```

### Set permissions

Execute the following commands to set the write permission on the cache folder:

```terminal
$ cd inphonex
$ sudo chmod -R 777 storage bootstrap/cache
```

## Docker

### Docker environment variables

Copy and change docker variables according to your environment:

```terminal
$ cd laradock
$ cp env-example .env
```

### Create and start containers

```terminal
$ docker-compose up -d nginx php-fpm postgres
```

### Go to the workspace

Enter the Workspace container, to execute commands like (Artisan, Composer, PHPUnit, …):

```terminal
$ docker-compose exec --user=laradock workspace bash
```

Alternatively, for Windows PowerShell users: execute the following command to enter any running container:

```terminal
$ docker exec -it --user=laradock {workspace-container-id} bash
```

### Install and configure the project

```terminal
/var/www$ composer install
/var/www$ cp .env.example .env
/var/www$ php artisan key:generate
/var/www$ php artisan migrate
/var/www$ php artisan passport:install
```

### Create a new user

```terminal
/var/www$ php artisan tinker
>>> $user = new Modules\User\Entities\User;
>>> $user->name = 'Name';
>>> $user->email = 'mail@domain.com';
>>> $user->is_admin = false;
>>> $user->password = 'yourpass';
>>> $user->save();
>>> exit
```

Exit the workspace

```terminal
/var/www$ exit
```

Full documentation for Laradock can be found on the [Laradock website](http://laradock.io/).

## Hosts

Update the file of hosts, in systems based in Linux or MacOS usually in:

```terminal
/etc/hosts
```

Add the follow line:

```terminal
127.0.0.1       inphonex.test
```

The base address of RESTful API is [http://inphonex.test](http://inphonex.test)

