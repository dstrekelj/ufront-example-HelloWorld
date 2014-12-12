# Layouts and Views

In the second part of this example project we will stylize our web app output by introducing layouts and views.

## Adjusting the folder structure

```
/ (project root)
L src
  L app
L www
  L css
  L view
```

## Adjusting the Server class

```haxe
import ufront.app.UfrontApplication;
import ufront.view.TemplatingEngines;

/**
 * Application entry point.
 */
class Server
{
	/**
	 * Store UfrontApplicatiob object for availability.
	 */
	public static var ufrontApp : UfrontApplication;

	/**
	 * Initialize and execute application.
	 */
	static function main()
	{
		init();
		ufrontApp.executeRequest();
	}

	/**
	 * Construct new UfrontApplication object (if it doesn't exist).
	 * Set index controller to app.Routes.
	 */
	static function init()
	{
		if(ufrontApp == null)
		{
			ufrontApp = new UfrontApplication({
				indexController: app.Routes,
				defaultLayout: 'layout.html',
			});

			ufrontApp.addTemplatingEngine(TemplatingEngines.haxe);
		}
	}
}
```

## Adjusting the Routes class

```haxe
package app;

import ufront.web.Controller;
import ufront.web.result.ViewResult;

/**
 * Handles URI routing.
 */
@viewFolder('/')
class Routes extends Controller
{
	/**
	 * Set application index as route.
	 */
	@:route('/*')
	public function index()
	{
		return new ViewResult({
			title: 'Index controller',
			content: 'Hello, world!',
		});
	}
}
```


## Creating a new layout

Layouts are HTML wrappers for views returned through `ufront.web.result.ViewResult`. By default, the UFront application looks for a layout in the root of the `view` folder.

Layouts are written with a templating engine in mind. In our case, we are using Haxe's built in templating engine. It is important to include the `viewContent` variable in a layout, at a place where the view result is desired. Variables in the Haxe templating engine are bookended by two colons, "::".

```html
<!DOCTYPE html>
<html>
<head>
	<title>My Ufront Application</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div>
	<h1>my first ufront application.</h1>
</div>
	::viewContent::
</body>
</html>
```

## Creating a new view

Views are objects of the `ufront.web.result.ViewResult` class. Like layouts, they make use of templating engine syntax in order to display content identified by given variables.

Views are expected to be located in the `view` folder.

```html
<div>
<h2>::title::</h2>
<p>::content::</p>
</div>
```

By default, UFront looks for view templates in the `view` folder. However, unless explicitly stated, it will consider views used by a particular controller class to be located in a subfolder with the controller class' name.

For example, a `ViewResult` returned by a PageController class will have it's view location guessed at the `/view/page/` path, with the view file name assumed to be the same as the name of the action function.

For more information, check out the `ufront.web.result.ViewResult` source.