#Monal

Monal is an extensible web application written using the [Laravel 4 framework](https://github.com/laravel/laravel). It is designed to provide a core web system that can be easily extended via an extensible API in order to quickly and easily build custom web applications.

It’s purpose is to allow web developers to quickly build powerful and bespoke web applications for their clients.


## So how does it work?

After being installed Monal provides a simple back end application that consists of a blank admin dashboard, secured by a login page.

Login screen:
![Login screen](https://raw.githubusercontent.com/ArranJacques/Monal-Documentation/master/images/login.jpg)

Dashboard:
![Login screen](https://raw.githubusercontent.com/ArranJacques/Monal-Documentation/master/images/dashboard.jpg)

The application exposes a clean API that can be used to easily build on the system or to extend it and add new functionality.

Want to add a menu option to the dashboard? Easy.

```php
Monal\API\Dashboard::addMenuOption(string $category, string $title, string $route [, string $permissions]);
```

```php
Monal\API\Dashboard::addMenuOption('Shop', 'Products', '/products');
```

The above would result in:

Menu:
![Menu](https://raw.githubusercontent.com/ArranJacques/Monal-Documentation/master/images/api/dashboard--addMenuOption.jpg)

Menu Open:
![Menu Open](https://raw.githubusercontent.com/ArranJacques/Monal-Documentation/master/images/api/dashboard--addMenuOption_2.jpg)

The system uses a Bootstrap style css framework to make creating elegant new dashboards quick and easy.

The Monal system is designed to be as flexible as possible in order to make building bespoke applications as easy as possible. For example, the default admin dashboard is located at www.yousite.com/admin. Don't wan't to use /admin? Then change it to anything you want by changing one easily adjusted configuration setting.

Our first rule is "Make no assumptions", and that is what we have tried to do with this application.


## Please note

Monal is currently very much in Alpha and as of yet I have not written any documentation. There is still a lot of work to do, and while this version is relatively stable, this repository is currently more of a holding zone than a working application for use. Although please feel free to try it out!

There are currently several packages at various stages of development that plug into the system and provide additional functionality. Packages currently in development are:

- Blog: create and manage a blog.
- Data: create and manage custom key-pair data sets and powerful data streams, which are repositories for objects made up of collections of data sets.
- Pages: create and manage front end pages for your applications with highly customisable content areas.
- Users: manage users, user groups and user permissions.

## Installing

#### Requirements

- PHP >= 5.3.7
- MCrypt PHP Extension


#### Download Monal

Download or clone the repository.

```
git clone https://github.com/ArranJacques/Monal.git
```

#### Install Packages

Monal uses [composer](https://getcomposer.org/) to manage it's package dependencies. If you haven't already, [download](https://getcomposer.org/) and install composer.

Once composer is installed run the `php composer.phar install` command from the root directory of your project to download the packages.

#### Install Monal

Navigate to your Monal install in your browser where you should be directed to Monal's installation screen.

Install Monal by following the on-screen instructions. Once installed you should be directed to the dashboard login screen where you can login to the application using the user profile created during the installation process.


## License

Monal is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)