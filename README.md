# Y2AA

Yii 2 Advanced App Template

[![Build Status](https://travis-ci.com/prsolucoes/y2aa.svg?branch=master)](https://travis-ci.com/prsolucoes/y2aa)  

#### Description

This is a simple web system made with Yii2 with advanced features. The project has:
 
- Frontend with Boostrap 4
- Backend with Bootstrap 4 and AdminLTE
- Secure permission control for backend
- Secure permission control for API (using JWT)
- Simple CMS with editable content with image upload
- Customer areas (login, signup, recovery password, signup validation, contact and more)
- Docker-compose configurations (nginx, mysql, php-fpm, memcached, mailcatcher)
- Localizations for the frontend and backend in english and portuguese
- Mobile, tablet and desktop friendly for the frontend and backend
- Upload for single file or multiple files configured
- Backend with specific report controller
- Configurations for development and production environment
- Ready implemented APIs : ping, login, signup, check token, request reset password, reset password, avatar, gallery, preference, log and much more  

This project im used in many other projects. It is ready to make a new website.

![](extras/screenshots/ss1.png)

Others screenshots are here:  

[SCREENSHOTS](SCREENSHOTS.md)

## Commands

If you type "make" in your terminal, you get all options:

```
- help
- clear
- nginx-reload
- requirements

- docker-compose-start
- docker-compose-stop
- docker-compose-start-console
- docker-compose-rebuild

- config-env-development
- config-env-production

- create-db
- create-db-test

- php-composer-install
- php-composer-update
- php-composer-outdated
- php-composer-show
- php-composer-clear-cache
- php-composer-remove

- migrate-db
- migrate-db-test

- php-gd

- test

- prod-update
- cloudflare-clear-cache
- cache-invalidate

- console-test
- console-permissions-generate
- console-data-all

- console-create-cache-table
- console-create-cache-table-test
```

If you want execute the commands with Docker support, add the parameter "docker=1" at the end of command. Ex:  
```
make migrate-db docker=1
```

All commands inside make use the docker names, like "y2aa_php_fpm". So you can execute "php" or "composer" like this:

```
docker exec -it y2aa_php_fpm php yii
``` 

or 

```
docker exec -it y2aa_php_fpm php composer.phar install
``` 

With the docker, you don't need to install on your machine MAMP, XAMP or something like this. Docker is everything.

All project configurations is using "y2aa.local" as hosts (nginx and absolute URL in yii2 config files), so add in your "/etc/hosts" file:

```
127.0.0.1 y2aa.local
```

Obs:

The make script automatically check what environment they need use checking environment variable **Y2AA_ENVIRONMENT_DEV**. Add variable **Y2AA_ENVIRONMENT_DEV** to your environment with value equal to 1 to force always use development environment, otherwise it will use production data.   

## Get started

Use the following commands with the docker to get start fast:

```
make docker-compose-start
make config-env-development docker=1
make create-db docker=1
make php-composer-install docker=1
make migrate-db docker=1
make console-test docker=1
make console-data-all docker=1
make console-create-cache-table docker=1
```

## Initial data

Migrations create all tables and indexes that this system need to work

You can add demo data using the command:

```
make console-data-all docker=1
```

Obs:

It already checks database data before insert to don't duplicate, so you can execute too many times if need. 

## Administrator panels permissions

The main user has root attribute equal to yes, so he can manage everything and generate permissions by the web panel.

If you want generate it from command line use the command:

```
make console-permissions-generate docker=1
```

Obs:

It recreates all permissions automatically, so you can execute too many times if need. 

## Production

After you clone your project into your production server only execute the following command to update everything automatically:

```
make prod-update docker=1
```

## Cache

By default, this system come configured to use database cache and can be changed to any other in configuration files.

If you still use it executes the following command to create cache table:

```
make console-create-cache-table docker=1
```

Obs:

It creates cache table only if it was not created, otherwise it will ignore.

## DateTime

All datetime fields use integer type and represent the UNIX TIMESTAMP number in seconds.

## Web response

All webservices and ajax calls return a JSON string from the object `common\models\web\Response.php`.

You can check documentation here:
https://github.com/prsolucoes/web-response

Example of message structure:
```json
{
    "success": false,
    "message": "register-failed",
    "data": {
        "errors": {
            "email": [
                "Email required",
                "Email invalid"
            ]
        },
        "tag": "task-3414"
    }
}
```

The "message" field is an S2S message, that is, known only between systems. Because sometimes the fact of having succeeded or failed is not enough, being necessary to have a specific message to indicate a condition beyond.

## Web services

#### Access token

The protected web services need use access token in header information. Example:

```
Authorization Bearer PART1.PART2.PART3
```

Where "Authorization" is the key and "Bearer XYZ" is the value.

#### How to obtain the authentication key for backend services

This is the first call to get access token and call other services.

METHOD: POST  
TYPE: JSON  
URL: `/api/backend/user/login`

REQUEST:
```json
{
  "email": "paulo@prsolucoes.com",
  "password": "user@password"
}
```

RESPONSE:
```json
{
    "success": true,
    "message": "login-ok",
    "data": {
        "token": "PART1.PART2.PART3"
    }
}
```

#### Validate the authentication key for backend services

It only serves to get some key data safely.

METHOD: POST  
TYPE: JSON  
URL: `/api/backend/user/check`

REQUEST:
```json
{
    "success": true,
    "message": "check-ok",
    "data": {
        "user": {
            "id": 1,
            "name": "Administrator",
            "email": "paulo@prsolucoes.com",
            "gender": "male",
            "avatar": "http://y2aa.local/admin/images/profile-default.png",
            "language_id": 1,
            "timezone": "America/Sao_Paulo",
            "created_at": 1579938761
        }
    }
}
```

RESPONSE:
```json
{
    "success": true,
    "message": null,
    "data": null
}
```

#### How to obtain the authentication key for frontend services

This is the first call to get access token and call other services.

METHOD: POST  
TYPE: JSON  
URL: `/api/customer/login`

REQUEST:
```json
{
  "email": "paulo@prsolucoes.com",
  "password": "customer@password"
}
```

RESPONSE:
```json
{
    "success": true,
    "message": "login-ok",
    "data": {
        "token": "PART1.PART2.PART3"
    }
}
```

#### Validate the authentication key for frontend services

It only serves to get some key data safely.

METHOD: POST  
TYPE: JSON  
URL: `/api/customer/check`

REQUEST:
```json
{
    "success": true,
    "message": "check-ok",
    "data": {
        "customer": {
            "id": 1,
            "name": "Administrator",
            "cpf": "11223344556",
            "email": "paulo@prsolucoes.com",
            "mobile_phone": "21999887766",
            "home_phone": "2133434343",
            "gender": "male",
            "avatar": "http://y2aa.local/images/profile-default.png",
            "language_id": 1,
            "timezone": "America/Sao_Paulo",
            "obs": "",
            "created_at": 1579938761
        }
    }
}
```

RESPONSE:
```json
{
    "success": true,
    "message": null,
    "data": null
}
```

## Apache2

If you use Apache2, you need add a virtual host, example:

```
<VirtualHost *:80>
    ServerName y2aa.local

    #ErrorLog /var/log/apache2/advanced.local.error.log
    #CustomLog /var/log/apache2/advanced.local.access.log combined
    AddDefaultCharset UTF-8

    Options FollowSymLinks
    DirectoryIndex index.php index.html
    RewriteEngine on

    RewriteRule /\. - [L,F]

    DocumentRoot /var/www/y2aa/frontend/web
    <Directory /var/www/y2aa/frontend/web>
        AllowOverride none
        <IfVersion < 2.4>
          Order Allow,Deny
          Allow from all
        </IfVersion>
        <IfVersion >= 2.4>
          Require all granted
        </IfVersion>

        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule ^ index.php [L]
    </Directory>

    # redirect to the URL without a trailing slash (uncomment if necessary)
    #RewriteRule ^/admin/$ /admin [L,R=301]

    Alias /admin /var/www/y2aa/backend/web
    # prevent the directory redirect to the URL with a trailing slash
    RewriteRule ^/admin$ /admin/ [L,PT]
    <Directory /var/www/y2aa/backend/web>
        AllowOverride none
        <IfVersion < 2.4>
            Order Allow,Deny
            Allow from all
        </IfVersion>
        <IfVersion >= 2.4>
            Require all granted
        </IfVersion>

        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule ^ index.php [L]
    </Directory>

    # redirect to the URL without a trailing slash (uncomment if necessary)
    #RewriteRule ^/api/$ /api [L,R=301]

    Alias /api /var/www/y2aa/ws/web
    # prevent the directory redirect to the URL with a trailing slash
    RewriteRule ^/api /api/ [L,PT]
    <Directory /var/www/y2aa/ws/web>
        AllowOverride none
        <IfVersion < 2.4>
            Order Allow,Deny
            Allow from all
        </IfVersion>
        <IfVersion >= 2.4>
            Require all granted
        </IfVersion>

        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule ^ index.php [L]
    </Directory>
</VirtualHost>
```

## Administrator panel

#### Using filter form

This project generates the grid and filter form with Gii.

By default, the grid filter is used and filter form is disabled.

To enable it, use the following code on your controller:

```
protected function beforeRenderOnIndex()
{
    $this->addRenderParam('showFilterForm', true);
    $this->addRenderParam('showGridViewFilter', false);
    $this->addRenderParam('showCreateButton', false);
}
```

## Cron

To add cron jobs that execute secure single task add these lines to `/etc/crontab`:

```
* * * * * root cd /root/folder && ./extras/cron/cmd-console-test.sh > /var/log/cron/cmd-console-test.sh.log 2>&1
```

This shell script auto test if it is executing or not to let execute a single process for that command at time.

## Contact

You can send email to me, to talk about anything related to the project:  
[paulo@prsolucoes.com](mailto:paulo@prsolucoes.com)

## Supported By Jetbrains IntelliJ IDEA

![Supported By Jetbrains IntelliJ IDEA](extras/images/jetbrains-logo.png "Supported By Jetbrains IntelliJ IDEA")

## Author WebSite

> http://www.pcoutinho.com

## License

[MIT](http://opensource.org/licenses/MIT)

Copyright (c) 2020-present, Paulo Coutinho