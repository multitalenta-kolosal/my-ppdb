
# A system for school admision online
**PPDB Warga** ppdb-warga is a laravel web apps that used in Yayasan Pendidikan Warga Surakarta since 2020. Proven to increase school admissions rate regarding the 2020 pandemic. Unfortunately, this web apps is not well documented. I'm really commited to completing the documentation of this system so every people could use this system.

big thanks to nasirkhn for the laravel boilerplate!

Please let me know your feedback and comments.

# Custom Commands

We have created a number of custom commands for the project. The commands are listed below with a brief about the use of it.

## Clear All Cache

`composer clear-all`

this is a shortcut command clear all cache including config, route and more

## Code Style Fix

`composer fix-cs`

apply the code style fix by this command.


# Features

* New student (Registrant) Registration
* Sending Whatsapp through rapiwha.com service
* Registration progress checker for admin
* Message delivery checker (callback from rapiwha.com system)
* Support multischool (we use unit for the term)
* Support period changing (202a/202b admission to 202c/202d)
* Support multi registration path (reguler, special, dll)
* Support multi School tier (admission for 1st,2nd,3rd,4th grade etc)
* Referal system
* etc...


## Core Features

* User Authentication
* Role-Permissions for Users
* Dynamic Menu System
* Language Switcher
* Localization enable across the porject
* Backend Theme
  * Bootstrap 4, CoreUI
  * Fontawesome 5
* Frontend Theme
  * Bootstrap 4, Impact Design Kit
  * Fontawesome 5
* Article Module
  * Posts
  * Categories
  * Tags
  * Comments
  * wysiwyg editor
  * File browser
* Application Settings
* External Libraries
  * Bootstrap 4
  * Fontawesome 5
  * CoreUI
  * Impact Design Kit
  * Datatables
  * Select2
  * Date Time Picker
* Backup (Source, Files, Database as Zip)
* Log Viewer
* Notification
  * Dashboard and details view
* RSS Feed


# User Guide

## Installation

Follow the steps mentioned below to install and run the project.

1. Clone or download the repository
2. Go to the project directory and run `composer install`
3. Create `.env` file by copying the `.env.example`. You may use the command to do that `cp .env.example .env`
4. Update the database name and credentials in `.env` file
5. Run the command `php artisan migrate --seed`
6. Link storage directory: `php artisan storage:link`
7. You may create a virtualhost entry to access the application or run `php artisan serve` from the project root and visit `http://127.0.0.1:8000`

*After creating the new permissions use the following commands to update cashed permissions.*

`php artisan cache:forget spatie.permission.cache`


## Icons
FontAwesome & CoreUI Icons, two different font icon library is installed for the Backend theme and only FontAwesome for the Frontend. For both of the cases we used the free version. You may install the pro version separately for your own project.

* **FontAwesome** - https://fontawesome.com/icons?d=gallery&m=free
* **CoreUI Icons** - https://icons.coreui.io/icons/


# Screenshots

__New Student Registration__

![Screenshot from 2023-09-15 10-11-18](https://github.com/multitalenta-kolosal/ppdb-warga/assets/60207273/6e7347df-cd95-4b06-b339-2d0e50d26bbb)


__Admin Page Dashboard__

![Screenshot from 2023-09-15 10-15-42](https://github.com/multitalenta-kolosal/ppdb-warga/assets/60207273/9fe8c6fc-e5ac-4f42-b52e-6058582aa7a3)

__Registrant Management__

![Screenshot from 2023-09-15 10-12-45](https://github.com/multitalenta-kolosal/ppdb-warga/assets/60207273/fcec43c1-1e36-4003-b6f2-fd08c11fbeb2)


__Schools Management__

![Screenshot from 2023-09-15 10-14-46](https://github.com/multitalenta-kolosal/ppdb-warga/assets/60207273/a37a79fb-177d-44cd-9eb6-a03a3546f7e5)

__Logs Management__

![Screenshot from 2023-09-15 10-16-40](https://github.com/multitalenta-kolosal/ppdb-warga/assets/60207273/aab3659a-478b-4d01-93b9-d595108c3798)

