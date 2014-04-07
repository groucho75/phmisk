phmisk
======

Phmisk is a Php/Html MIcro Starter Kit.
It comes with:
* an html5 UI, with css and jquery: html5boilerplate + bootstrap, from [Initializr](http://www.initializr.com)
* a router: [bramus/router](https://github.com/bramus/router)
* a template engine: [rain.TPL](http://www.raintpl.com/)
* an ORM database layer: [Idiorm](https://github.com/j4mie/idiorm)

Then, Phmisk uses Composer so you can include and use all the libraries you need.

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

***

Routes
------
Add the simplest route in `index.php`:
```php
$router->get('/hello', function() {
	
	echo 'Hello world!';
	
});
```
You can visit `your-site.com/hello` to see it.

For usage and more examples please see the [router homepage](https://github.com/bramus/router).

***
Templates
---------
To use the template engine in a route add `use ($tpl)` to the function. A route in `index.php` engine could be:
```php
$router->get('/hello/(\w+)', function($name) use ( $tpl ) {
	
	$tpl->assign( 'name', $name );
	$tpl->draw( 'hello' );
	
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

For usage and more examples please see the [template engine homepage](http://www.raintpl.com).

***
ORM database layer
------------------

TODO


***
The app file structure
----------------------

TODO


***
Edit config & bootstrap
-----------------------

TODO


***
Include more packages
---------------------

TODO


***
Custom controllers in routes
----------------------------

TODO (oppure no? e usarli nel form PFBC)


***
Quick tutorial: create a form with PFBC
---------------------------------------

TODO
