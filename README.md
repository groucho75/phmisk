phmisk
======

[Phmisk](https://github.com/groucho75/phmisk) (*/piː eɪtʃ miːsk/* or */f miːsk/* or */wɑtˈevər/* or */wɒt ðə fʌk/*) is a **Php/Html5 MIcro Starter Kit**.
It comes with an **html5 UI**: Html5boilerplate and Twitter Bootstrap, from [Initializr](http://www.initializr.com).
Phmisk is ready to work with:
* a router: [bramus/router](https://github.com/bramus/router) (1)
* a database layer: [Sparrow](https://github.com/mikecao/sparrow) (1)
* a simple session manager
* a simple template engine

(1) *Phmisk comes out without these libraries, so you have to use Composer to install them.
Of course, using Composer you can include and use also other libraries.*

You can see the [Wiki](https://github.com/groucho75/phmisk/wiki) to find some tutorials and guides.

***

Getting started
---------------

### Prerequisites
You need [Composer](https://getcomposer.org/doc/00-intro.md#installation-nix) installed on your machine.

### Installation method #1:
1. download and unzip this repository
2. enter the `phmisk-master` folder and launch Composer install to resolve and download required packages:  

   ```  
   $ composer install  
   ```  


### Installation method #2 (via shell):
1. open the terminal and go to your web server directory 
2. launch the following command:

   ```  
   $ wget https://github.com/groucho75/phmisk/archive/master.tar.gz && tar -zxf master.tar.gz && rm master.tar.gz && cd phmisk-master && composer install
   ```  
3. you will find a new ready-to-use `phmisk-master` folder in your web server: it contains all files *including* the libraries downloaded by Composer (you don't have to launch Composer install again)

### Start editing:
* edit `app/config.php` (database connection settings, php configurations...)
* add your routes in the main `routes.php`


***

$ph4
----

**You can write your application editing the `routes.php`.**

You can use a Phmisk object called `$ph4` that contains the instances of main libraries.
In this page you can read about how to use these libraries.

You are right, $ph4 means 'ph' plus 4 characters ('misk').

***

Routes
------

### Routing

Add the simplest route in main `routes.php`:
```php
$ph4->router->get('/hello', function() {
	
	echo 'Hello world!';
	
});
```
And you can visit `your-site.com/hello` to see it.

### Custom controller files

You can map custom controller/method as a route: put your controllers inside `app/controllers` and they will be autoloded. Then, you have to add a route statement in `routes.php`: here is a route provided by custom controller called `Demo`:
```php
$demo = new App\Controllers\Demo();

$ph4->router->get('/test', function() use ( $demo ) {
	
	$demo->test();
});
```

The `Demo` controller file is located in `app\controllers\Demo.php` and contains something like:
```php
namespace App\Controllers;

class Demo extends Base
{	
	function test() 
	{
		echo 'This page has been created by Test method of Demo custom controller';			
	}

}
```
The `Base` controller is a parent class you can extend to have shared methods.

### Reference

For usage and more examples (Dynamic Route Patterns, Mounting Routes...) please see the [router homepage: bramus/router](https://github.com/bramus/router).

***
Template (views)
----------------
Phmisk has a simple template engine to show view files. To use the template engine in a route you have to add `use ($ph4)` to the function and you can use it as `$ph4->view`.

A route in `routes.php` could be:
```php
$ph4->router->get('/hello/(\w+)', function($name) use ( $ph4 ) {
	
	$ph4->view->assign( 'name', $name );
	$ph4->view->render( 'hello' );
	
});
```
The template file, `ui/hello.php`, could be:
```php
<?php include __DIR__.'/header.php' ?>

	<div class="container">
		<div class="page-header">
		
			<h1>Hi <?=$name?></h1>
			
		</div>
		<p class="lead">You are welcome!</p>
	</div>

<?php include __DIR__.'/footer.php' ?>
```
You can visit `your-site.com/hello/johnny` to see it.

Note that template files are php files, so you can freely use php statements.


### Reference

In routes you have to use 2 functions:

```php
// Assign a variable
$ph4->view->assign( 'name', $name );

// Assign a group of variables
$vars = array( 'name' => 'Foo', 'surname' => 'Bar' );
$ph4->view->assign( $vars );

// Assign a variable, and clean XSS
$ph4->view->assign( 'name', $name, true );

// Echo the ui/home.php view file
$ph4->view->render( 'home' );

// Return the ui/home.php view file as a string
$output = $ph4->view->render( 'home', true );
```

The template engine uses php files as views.

In view files you can simply print the variables as in php:
```php
// Quick php echo
<strong><?=$name?></strong>

// Clean XSS and print
<strong><?php safe_echo($name)?></strong>
```

In view files you can include other view files using standard php, e.g.:
```php
<?php include __DIR__.'/header.php' ?>
```

For more info please browse the [View class](https://github.com/groucho75/phmisk/blob/master/app/core/View.php).


***
Database layer
--------------

Phmisk uses a simple database toolkit.

First of all, set the database connection settings in `app/config.php`.

In this `blog` route you get some posts and prepare them to be sent to layout: 
```php
$ph4->router->get('/blog', function() use ( $ph4 ) {

	$posts = $ph4->db->from('posts')
			->select('title')
			->limit(5)
			->many();

	$data = array(
		'pagetitle' => 'My posts',
		'posts'		=> $posts,
	);
	
	$ph4->view->assign( $data, true );	
	$ph4->view->render( 'blog' );    
});
```
Note that you have to add `use ($ph4)` to the function and then you can use it as `$ph4->db`.
The database connection parameters are set in `app/config.php` and the connection starts in `app/bootstrap.php`.

Just for your thirst for knowledge, here is the blog template file, `ui/blog.php`:
```php
<?php include __DIR__.'/header.php' ?>

	<div class="container">
	
		<div class="page-header">
			<h1><?=$pagetitle?></h1>
		</div>
		
		<ul class="lead">
			<?php
			if ( is_array($posts) )
			{
				foreach( $posts as $post )
				{
					echo '<li>'. $post['title'] .'</li>';
				}
			}
			else
			{
					echo '<li>No post yet</li>';
			} ?>
		</ul>
	</div>

<?php include __DIR__.'/footer.php' ?>
```

### Reference

For usage and more examples please see the [databaase layer home: Sparrow](https://github.com/mikecao/sparrow).


***

Sessions
--------

Phmisk comes with a simple wrapper for php session management. It helps to start and destroy session, set and delete session vars. 
It helps to use "flash" vars: session data that live only in next round (e.g. feedbacks and messages to user).

### Reference

```php
// Init the session
$ph4->sess->start();

// Set a session var
$ph4->sess->set('my_var', 1);

// Set a flash var (it will exist till next round)
$ph4->sess->setFlash('my_flash_var', 1);

// Get a session var (the 2nd argument is a default if var not found)
$ph4->sess->get('my_var', 0);
```

For more info please browse the [Session class](https://github.com/groucho75/phmisk/blob/master/app/core/Session.php).


***
The file structure
------------------

```
phmisk root/
  |
  |__ app/
  |      |__ controllers/
  |      |__ core/    
  |      |__ libraries/  
  |      |__ (vendor/)    
  |      |  
  |      |__ bootstrap.php
  |      |__ config.php
  |      |__ helpers.php  
  |
  |__ ui/
  |      |__ css/
  |      |__ fonts/  
  |      |__ img/  
  |      |__ js/    
  |      |
  |      |__ (php view files)  
  |
  |__ composer.json
  |__ index.php
  |__ routes.php
  |__ .htaccess  
```

The `app/controllers` folder contains all your custom controllers and a `Base` controller.
The `app/core` folder contains some important bundled libraries (e.g. the core Phmisk class). 
The `app/libraries` folder contains optional libraries: of course you can add here your custom classes, made by you or simply not available on remote repositories, and they will be autoloaded.
It could be a good idea move the app folder outside/above the site foot.

The `ui` contains all the Html5boilerplate and Twitter Bootstrap folder and files, generated using [Initializr](http://www.initializr.com/) and edited to work in Phmisk. Then, there are some php view files: header, home, footer...

Phmisk comes out **without libraries** (router, template, ORM). You have to use Composer to install them. After that a new `app/vendor` folder will appear. 

The `app` folder contains some important files: 
* `config.php`: here you can set database parameters and other settings;
* `bootstrap.php`: the main Phmisk class is initialised here;
* `helpers.php`: this file contains some useful functions you can use everywhere.


***

Advanced setup
--------------

### Set constants

In `index.php` you can edit some important constants:
* `ENV` (default: `dev`): the application environment: development, testing, live (production). You can use it to have application behavior depending on environment: e.g. database settings, show/hide errors. 
* `APP_PATH` (default: `app`): the path to the 'app' folder, without slashes. This folder contains all libraries and classes. For security reason you should move it outside public web root (see next paragraph).
* `UI_PATH` (default: `ui`): the path to 'ui' folder, without slashes. This folder contains all html/css/js assets and php views. It must be public and accessible.


### Secure the app folder

For security reasons it could be a good idea move the app folder (`app`) outside/above the web root.

In this sample setup the app folder has been moved *one level above* the web root:

* you have to set it in `index.php`:

```php
define('APP_PATH', '../app');
```

* you have to set it in config and autoload sections in `composer.json`:

```
	"config": {
        "vendor-dir": "../app/vendor"
    },
    ...
    "autoload": {	
        "classmap": ["../app/core/", "../app/controllers/", "../app/libraries/"],
        "files": ["../app/helpers.php"]
    }	
```

* then, do not forget to launch the composer install:

```  
$ composer install
```  

### Deploy to production

When you are ready to deploy your phmisk site to production server, follow these steps:

1. of course, copy all the files on production server;
2. in `index.php` set `ENV` to `live`;
3. run the following command on production server (*--optimize-autoloader* flag = faster Composer autoload; *--no-dev* flag = development packages will be not installed):

```  
$ composer install --no-dev --optimize-autoloader
```  

**Note**: be sure to upload also the `composer.lock` file and only run Composer *install* on the production server: in this way the development packages will be skipped and you will be sure that the version of the packages installed on the production server match those you developped on. For this reason, **never** run Composer *update* on your production server.

**If you cannot access the production server via shell**, you can run the command (step 3) on local server, then upload all the files on production server.


***
Include more packages
---------------------

To include more php packages you can simply add them in `require` section inside `composer.json` and then launch Composer update:
```
	"require": {
		...
		"monolog/monolog": "1.0.*"
	},
```

Then, in main `routes.php` you can start using it writing:
```php
$log = new Monolog\Logger('name');
```
 
If you like to use other packages instead of standard (e.g. another template engine), you have to set them in `require` section inside `composer.json`, then change the initialisation in `app/bootstrap.php`.

If you need javascript libraries, of course you can get them via Composer, or you can download them and put in `ui` folder, or simply link their CDN from template files.

### Tutorials & Samples

Please see the [Wiki](https://github.com/groucho75/phmisk/wiki) to find some tutorials about adding new packages.


***
Donations are welcome
---------------------

If you like my hard work, of course you can [donate some money to me](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9E6BPXEZVQYHA).

And don't forget to donate something also to the authors of other libraries used by Phmisk (see above for repo and links). 
 
