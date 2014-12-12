# "Hello, world!"

In the first part of this example project we will build a simple web application with a single "Hello, world! controller. This will serve as an introduction to ufront's take on the MVC framework.

The end result of the application is a web page displaying the message: "Hello, world!"

## Project folder structure

The folder structure of the project is arbitrary, but it is always wise to keep it logical or standardized (if possible). For that reason, the folder structure is fashioned after the few ufront projects found on GitHub:

```
/ (project root)
L src
  L app
L www
```

`src` contains project source files. Application specific sources are located in the `app` subfolder.

`www` contains the compiled output.

We will expand on this folder structure, depending on our needs, as we progress through the guide.

## Build file

We explicitly state the ufront library version to 1.0.0-rc.5 in order to ensure compilation on computers where a different version is the default one. The `-D server` compiler directive is necessary to successfully compile the project as it is used by the library and its dependencies. The Server class is set as the main entry point of the application. Finally, an XML types description is generated for documentation purposes.

```
-lib ufront:1.0.0-rc.5
-D server
-cp src
-main Server
-php www
-xml project.xml
```

## Server class

The Server class is the main entry point of our ufront application.

Ufront applications are objects of the `ufront.app.UfrontApplication` class. We store the object in a public static variable, `ufrontApp`, in order to ensure its availability across the code base.

When constructing a new object of the `UfrontApplication` class, it is optional to pass a `ufront.web.UfrontConfiguration` structure to configure the application. The structure contains various useful configuration options to adjust the app's behaviour, but all of them fall back to certain default values if no configuration options are set. For now, we will only make use of the `indexController` field, which lets the application know which controller class to use as the app's index controller. Our index controller will be the currently undefined Routes class from the `app` subfolder that we'll create in the next section.

```haxe
import ufront.app.UfrontApplication;

class Server
{
    public static var ufrontApp : UfrontApplication;
    
    static function main()
    {
        ufrontApp = new UfrontApplication({
            indexController: app.Routes,
        });
    }
}
```

Now that the groundwork is done, let's make a few adjustments. We'll move the app construction code to an initialization function in order to reduce the clutter. Following that, we'll wrap the constructor call in a conditional to make sure we only construct a new `ufront.app.UfrontApplication` object if one doesn't already exist.

Finally, we execute the application via the `executeRequest()` method. Our Server class now looks like this:

```haxe
import ufront.app.UfrontApplication;

class Server
{
	public static var ufrontApp : UfrontApplication;
	
    static function main()
    {
		init();
		ufrontApp.executeRequest();
	}

	static function init()
	{
		if(ufrontApp == null)
		{
			ufrontApp = new UfrontApplication({
				indexController: app.Routes,
			});
		}
	}
}
```

## Routes class

The Routes class manages URI routing. It extends the `ufront.web.Controller` class in order to do so.

Routes are set up using `@:route` metadata by specifying a path and the corresponding action function. Since we only want to display a simple message, we set the route path to the root of the compiled web app, and we attach it to an action represented by the `index()` function. The function is triggered when the route is accessed, returning the "Hello, world!" string.

Our fairly simple Routes class looks like this:

```haxe
package app;

import ufront.web.Controller;

class Routes extends Controller
{
	@:route('/*')
	public function index()
	{
		return "Hello, world!";
	}
}
```

## Build result

Accessing the web app hosted on our webserver through our browser results in the words "Hello, world!" printed on a blank page.