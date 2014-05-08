phmisk
======

[Phmisk](https://github.com/groucho75/phmisk) is a Php/Html5 MIcro Starter Kit.
It comes with an **html5 UI**: Html5boilerplate and Twitter Bootstrap, from [Initializr](http://www.initializr.com).
Phmisk is ready to work with:
* a router: [bramus/router](https://github.com/bramus/router)
* a template engine: [rain.TPL](http://www.raintpl.com/)
* a database layer: [Sparrow](https://github.com/mikecao/sparrow)

Phmisk comes out *without these libraries*, so you have to use Composer to install them.
Of course, using Composer you can include and use also other libraries.

You can see the [Wiki](https://github.com/groucho75/phmisk/wiki) to find some tutorials and guides.

***

Installation
------------

1. download and install [Composer](https://getcomposer.org/doc/00-intro.md#installation-nix) on your machine
2. clone/download this repository
3. go to phmisk directory and launch Composer install to resolve and download required packages:  

   if Composer local installation:  
   ```  
   $ php composer.phar install  
   ```  
   if Composer global installation:  

   ```  
   $ composer install  
   ```  
4. set the permission of `app/cache` folder to 777
5. edit `app/config.php` (database connection settings, php configurations)
6. add your routes in the main `index.php`

***

$ph4
----

You can write your application editing the main `index.php`.

It loads and initialises Phmisk, then it creates the `$ph4` object that contains the instances of main libraries.
In this page you can read about how to use these libraries.

You are right, $ph4 means 'ph' plus 4 characters ('misk').

***

Routes
------

### Routing

Add the simplest route in main `index.php`:
```php
$ph4->router->get('/hello', function() {
	
	echo 'Hello world!';
	
});
```
And you can visit `your-site.com/hello` to see it.

### Custom controller files

You can map custom controller/method as a route: put your controllers inside `app/controllers` and they will be autoloded. Then, you have to add a route statement in main `index.php`: here is a route provided by custom controller called `Demo`:
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
Templates
---------
To use the template engine in a route you have to add `use ($ph4)` to the function and you can use it as `$ph4->tpl`. A route in `index.php` could be:
```php
$ph4->router->get('/hello/(\w+)', function($name) use ( $ph4 ) {
	
	$ph4->tpl->assign( 'name', $name );
	$ph4->tpl->draw( 'hello' );
	
});
```
The template file, `ui/hello.php`, could be:
```html
{include="header"}

	<div class="container">
		<div class="page-header">
		
			<h1>Hi {$name}</h1>
			
		</div>
		<p class="lead">You are welcome!</p>
	</div>

{include="footer"}
```
You can visit `your-site.com/hello/johnny` to see it.

Note that template files are php files, so you can freely use php statements.

It could be a good idea move the cache folder (`app/cache`) outside/above the site foot. Set the new path in `app/bootstrap.php`:
```php
$tpl::configure( array(
	...
	"cache_dir"     => "../../cache/"
));
```

### Reference

For usage and more examples please see the [template engine homepage: rain.TPL](http://www.raintpl.com).

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
		'msg' 		=> 'My posts',
		'posts'		=> $posts,
	);
	
	$ph4->tpl->assign( $data );	
	$ph4->tpl->draw( 'blog' );    
});
```
Note that you have to add `use ($ph4)` to the function and then you can use it as `$ph4->db`.
The database connection parameters are set in `app/config.php` and the connection starts in `app/bootstrap.php`.

Just for your thirst for knowledge, here is the blog template file, `ui/blog.php`:
```html
{include="header"}

	<div class="container">
	
		<div class="page-header">
			<h1>{$msg}</h1>
		</div>
		
		<ul class="lead">
			{loop="$posts"}
				<li>{$value.title}</li>
			{else}
				<li>No post yet.</li>
			{/loop}
		</ul>
	</div>

{include="footer"}
```

### Reference

For usage and more examples please see the [databaase layer home: Sparrow](https://github.com/mikecao/sparrow).


***
The file structure
------------------

```
phmisk root/
  |
  |__ app/
  |      |__ cache/
  |      |__ controllers/  
  |      |__ libraries/  
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
  |__ .htaccess  
```

The `app/cache` folder contains the files generated by the template engine (note: *cache folder must have permissions to 777*). It could be a good idea move the cache folder outside/above the site foot.
The `app/controllers` folder contains all your custom controllers and a `Base` controller.
The `app/libraries` folder contains some important bundled libraries (e.g. the core Phmisk class). Then, you add here your custom classes, made by you or simply not available on remote repositories: they will be autoloaded.

The `ui` contains all the Html5boilerplate and Twitter Bootstrap folder and files, generated using [Initializr](http://www.initializr.com/) and edited to work in Phmisk. Then, there are some php view files: header, home, footer...

Phmisk comes out **without libraries** (router, template, ORM). You have to use Composer to install them. After that a new `vendor` folder will appear. 

The `app` folder contains some important files: 
* `config.php`: here you can set database parameters and other settings;
* `bootstrap.php`: the main Phmisk class is initialised here;
* `helpers.php`: this file contains some useful functions you can use everywhere.


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

Then, in main `index.php` you can start using it writing:
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
 
