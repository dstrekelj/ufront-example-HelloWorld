# Introduction

In this chapter we will go through the basics.

## What is MVC?

**Model-view-controller**, or MVC, is a software architecture dividing an application into three separate, yet interconnected components:
* The **model** represents the data and data-management of the application. It listens to the controller's requests, and sends the results as upates to the view.
* The **view** represents the user interface of the application. It renders the data received by the model in a desired fashion.
* The **controller** is, well, the *controller* - receiving user input and controlling the model accordingly.

Or, in a visual sense:

```
               MODEL
   updates /v        ^\ requests
         VIEW      CONTROLLER
     shows \v        ^/ uses
               USER
```

The idea is that, by giving each component a degree of independence, the developer has more freedom to adjust and modify a given component without fear of breaking the others. In a sense, the only thing connecting the components together is the data shared between them, so changing anything other than the data shouldn't trigger an avalanche of regret and bad decisions.

## What is UFront?

To quote the blurb from the [UFront](https://github.com/ufront/ufront) GitHub repository:

> Ufront is a powerful MVC web framework for Haxe. It gives you quick development, shared code on the client and server, powerful extensibility, easy testing, and targets PHP or Neko on the server, and mostly JS (though anything is possible) on the client.

In simpler terms, it offers a way of applying the MVC architecture and its concepts to your own web project. Let's take a look at UFront-flavoured MVC architecture.

### UFront models

This example will not require the use of a database, meaning that it also won't use models.

### UFront views

Views are essentially HTML wrappers for data received from the model. The way a view is written depends on the templating engine syntax. Templating engines currently supported by UFront are:
* `haxe`, which is present in the Haxe Standard Library
* `hxdtl`, the Django Templating Library for Haxe, which requires the `hxdtl` library
* `hxtemplo`, a Haxe port of the templo templating language, requiring `hxtemplo`
* `mustache`, which requires the `mustache` library
* `erazor`, based on mvc-razor, which requires the `erazor` library

By default, a UFront application will search for view templates in the `view` folder relative to the application's `index.php`. For example, if the build output of a project is in the `/www/` directory, the expected view location would be `/www/view/`.

UFront allows for the use of layouts. Layouts wrap around views in similar manner that views wrap around model data. With that in mind, layouts are meant to be reusable, while views are mostly unique to a particular controller. Consider the following layout, written with Haxe templating language syntax:

```html
<html>
<head>
	<title>My Website</title>
</head>
<body>
<h1>Welcome to my website!</h1>
::viewContent::
</body>
</html>
```

The result of a view that uses the above layout will be injected in place of the `::viewContent::` variable, which is necessary in order for the layout to work. If our view wraps `::title::` and `::text::` variables, like this:

```html
<h2> ::title:: </h2>
<p> ::text:: </p>
```

The resulting response will be:

```html
<html>
<head>
	<title>My Website</title>
</head>
<body>
<h1>Welcome to my website!</h1>
<h2> ::title:: </h2>
<p> ::text:: </p>
</body>
</html>
```

Views will be explained in more detail in the following section on UFront controllers.

### UFront controllers

Controllers are derived from the `ufront.web.Controller` base controller class. The controller class describes routes and actions taken when the web app navigates to a given route.

Routes are set up with `@:route` metadata, and are placed before the desired action method of the controller. For example:

```haxe
// Reaching localhost:8000/my-web-app/ triggers doIndex()
@:route('/') function doIndex() {}
```

 Routes that end with wildcards trigger the attached action method for all routes that match as 'sub-routes'. For example:

```haxe
/**
 * Reaching:	localhost:8000/my-web-app/home/1
 *              localhost:8000/my-web-app/home/2/3
 *          ... triggers doHome()
 */
@:route('/home/*') function doHome() {}
```

It is also possible to pass parameters to action methods through routes. For example:

```haxe
@:route('/user/$name/') function showUser(name : String) {}
@:route('/user/$name/message', POST) function message(name : String, args : {msgSubject : String, msgBody : String}) {}
```

Action methods **must** return a value. Usually, that value is a `ufront.web.result.ActionResult` type, such as:
* `ufront.web.result.ContentResult`, which represents a user-defined content type that is the result of the action method
* `ufront.web.result.EmptyResult`, which represents a result that takes no further acton and writes nothing to the response
* `ufront.web.result.RedirectResult`, which controls the processing of application actions by redirecting to a specified URI
* `ufront.web.result.ViewResult`, which loads a view from a templating engine, optionally wrapping it in a layout, and writes the result to the HttpResponse with a `text/html` content type

The most commonly used `ActionResult` is the `ViewResult`, as it prepares the content for rendering to the user. To return a `ViewResult` with an action method, do the following:

```haxe
@:route('/home/')
function doHome()
{
	return new ViewResult({
		title: "Welcome home!",
		text: "You are now at home.",
	});
}
```

This will also set the `::title::` and `::text::` variables of a `home.html` view (UFront guesses it based on the name of the action method), and wrap it in the default layout. It is also possible to specify the view and layout like this:

```haxe
@:route('/home/')
function doHome()
{
	return new ViewResult({
		title: "Welcome home!",
		text: "You are now at home.",
	}, "other-home-view.html")
	.withLayout("different-layout.html");
}
```