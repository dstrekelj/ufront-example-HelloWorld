# "Hello, World!"

In this chapter we will create our first UFront web application. The application will allow the user to submit a string via a form. The application will then greet the user, using the string as an identifier.

This chapter discusses:
* creating and configuring the UFront Application object
* managing routes
* handling form input
* using views

## Project folder structure

Before proceeding further, let's take a look at the base project folder structure:

```
src/
    app/
        Routes.hx
    cnf/
        app.json
    Config.hx
    Server.hx
www/
    css/
        style.css
    view/
        index.html
        layout.html
```

The `src` folder contains the source files of the application, as well as configuration data. The configuration data is located inside the `cnf` folder, and is stored as `app.json`. It contains data necessary to properly configure the UFront Application object, but more on that later.

The static main function, or the app's entry point, is located in the `Server.hx` file - the `Server` class - at the root of the `src` folder. A class handling the configuration data - `Config` - has its source located at the root of the directory as well.

The `app` folder is meant for classes that deal with application logic. `Routes` is the only class for this project that fits the bill, handling the routing and actions associated with each defined route.

The `www` folder is the build output folder. Inside it is the `view` folder, and the `css` folder. The `view` folder is where the views are located: `layout.html` for the default layout, and `index.html` for the index controller action result. By default, a UFront Application will always look for views in the `view` folder at the root of the application folder. The stylesheet is located in the `css` folder.

## Server class - Creating the application

The main function of a UFront based web application is the one to execute the `ufront.app.UfrontApplication` object. In this case, we create an object of the `UfrontApplication` class, configure it and execute it in order to start the application.

```haxe
import ufront.app.UfrontApplication;
import ufront.view.TemplatingEngines;

import Config;

class Server
{
	public static var ufrontApp : UfrontApplication;

	static function main()
	{
		if(ufrontApp == null)
		{
			ufrontApp = new UfrontApplication({
				indexController: app.Routes,
				templatingEngines: [TemplatingEngines.haxe],
				defaultLayout: Config.app.defaultLayout,
				basePath: Config.app.basePath,				
			});
		}

		ufrontApp.executeRequest();
	}
}
```

We place the constructor call inside a conditional to avoid creating more than one `UfrontApplication` object. We store the object in a public static variable to make it accessible, however this project makes no use of it outside of the `Server` class.

The `ufront.app.UfrontApplication` constructor takes an optional argument of the `ufront.web.UfrontConfiguration` type, which is a structure describing various configuration options for a UFront application. If a `UfrontConfiguration` isn't passed to the constructor, the application's configuration options resorts to certain default values.

Our `UfrontApplication` object, stored in the `ufrontApp` variable, has its `indexController` field set to the `Routes` class of the `app` package. This is the initial controller the user will use when using your web application (well, navigating to the index.php file). We set the templating engine to Haxe's built-in templating engine, which we'll use when working on our views. The `templatingEngines` fields takes an array for an argument because it is possible to use several different templating engines among your views. This is really helpful, because it makes it possible to use certain templating engines for parts of the application they're better suited for.

## Config class - Configuring the application

The `defaultLayout` and `basePath` fields are configured through the `app.json` config file. The `defaultLayout` field sets the default wrapper for a result view, while the `basePath` field specifies the location of the web application on the web server.

### app.json and the Config class

We use a simple JSON file to store configuration data:

```json
{
	"basePath" : "/haxe/ufront-example-HelloWorld/www/",
	"defaultLayout" : "layout.html"
}
```

Here, we specify the location of the web app on the web server (this will most likely be different on your end), and we set the default layout to the layout.html file.

The contents of the above JSON file are parsed and stored in a public static variable declared in the `Config` class:

```haxe
class Config
{
	public static var app = CompileTime.parseJsonFile('cnf/app.json');
}
```

This makes it possible to configure the application before building it without changing its source code. For example, if the app is ever deployed onto another web server with a different path, it would only be necessary to change the `basePath` field in the JSON before compiling.

The same setup is also often used to store database information.

## Routes class - Handling the routing and the logic

The `Routes` class is a `ufront.web.Controller`. It handles the routing and associated actions that create the logic of the web application. Details on how routing and views work are covered in the "Introduction" chapter.

```haxe
package app;

import ufront.web.Controller;
import ufront.web.result.ViewResult;
import ufront.web.result.RedirectResult;

import Config;

using StringTools;

@viewFolder('/')
class Routes extends Controller
{
	@:route("/$name", GET)
	public function index(?name : String = "world")
	{
		var result = name.urlDecode();
		return new ViewResult({
			greeting: 'Hello, $result!',
		});
	}

	@:route("/action/submit/", POST)
	public function submit(args : {name : String})
	{
		return new RedirectResult(Config.app.basePath + args.name);
	}
}
```

By default, UFront applications look for view templates in a folder relative to the `view/` folder that has the same name as the class. To override this behaviour, we use the `@viewFolder` macro. This way, the view templates will be looked for at the root of the `view/` folder instead.

Also, when an action method returns a view, it'll search for a template with the same name as the action method. In our case, the `index` method will return the `index.html` template. Just the way we want it.

Since our web app will have a form, we set up our routes with the GET and POST parameters. The index route will expect a `$name` variable, which is the name of the field the form will submit. We will also define an `/action/submit/` route to be used in our form's action attribute. This route's action method will pass the form's submitted fields to the index route as an argument.

The index route returns a new `ufront.web.result.ViewResult`, passing the data submitted by the form to the view template as the `greeting` variable. Variables received through GET are percent-encoded, which is why we use the `StringTools.urlDecode` method on the `name` variable. This way, even UTF-8 characters will be displayed normally, instead of as garbled %20BE%20EC strings.

## Views

First, we need a default layout template to wrap our `ViewResult` in. Layouts require the use of a `viewContent` variable in the place where the result is supposed to be, in order for the layout to successfully wrap around the view. With that in mind, let's create our layout:

```html
<!DOCTYPE html>
<html>
<head>
	<title>Greetings!</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset='utf-8' />
</head>
<body class="container">
	<div class="content">	
		::viewContent::
	</div>
</body>
</html>
```

With that sorted, let's take a crack at the index view:

```html
<h1>::greeting::</h1>
<form action="./action/submit/" method="POST" accept-charset="UTF-8">
	<input class="transparent" type="text" id="name" name="name" placeholder="Your Name" />
	<button class="transparent" type="submit">... is my name.</button>
</form>
```

Note the following:
* `::greeting::` variable is returned by the `index` action method in the `Routes` class
* form `action` attribute is the route associated with the `submit` action method in the `Routes` class
* `name` is the name of the variable in the `args` structure, which is the paramater of the `submit` action method

## Build file

The build file includes the UFront library, and specifies its most recent version (at the time of writing). The 'server' compiler directive is passed as well - without it, the UFront library won't compile. Along with compiling the project to PHP, an XML types description is generated as well to make documentation generation easier.

```
-lib ufront:1.0.0-rc.6

-D server

-cp src
-main Server
-php www

-xml project.xml
```

To build, simply run `haxe build.hxml`. Once the build is complete, run a local webserver at the appropriate location