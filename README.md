# Ufront Example series: "Hello, world!"

"Hello, world!" example web application, based on the excellent [ufront MVC](https://github.com/ufront/ufront).

**Refer to the repo Wiki for a complete guide / tutorial.**

This project demonstrates the following:
* creating and configuring the UFront Application object
* managing routes
* handling form input (POST, GET requests)
* using views

Contents:
* `dox` - generated documentation
* `src` - source files
* `wiki` - repo wiki entries as Markdown files
* `www` - build output

## CHANGELOG

__2015/07/02__
* Bumped up ufront version number
* Dropped PHP compilation target in favour of Neko
* Added server.bat as a shortcut to run the nekotools server and host the site
* Added dox.bat as a shortcut to running the documentation tool for generating the docs
* Updated generated documentation
* Updated README

**If you have `nekotools` installed, running the server.bat file (or the commands within it) will begin hosting the project!**

## TODO

Wiki
* Reread. Rewrite. Repeat ad infinitum.

## Requirements

The project requires the [ufront](https://github.com/ufront/ufront) library (version 1.0.0-rc.6) and its dependencies. It may or may not work with other versions of the library.

## Preparation

### Get ufront

Install ufront through haxelib and set it up.

```
haxelib install ufront
haxelib run ufront --setup
```

### Host webserver

This being a web app, a webserver is required to host it. Personally, I use [USBWebserver](http://www.usbwebserver.net/en/) because it requires virtually no setup. However, [XAMPP](https://www.apachefriends.org/download.html) is a more popular alternative.

The project targets PHP, so make sure your webserver is properly configured. If you choose to target Neko, you can either configure your webserver for Neko by installing mod_neko, or run the nekotools server locally.

### Get repo source

Clone the repository to a folder of your choice. If that folder is accessible by your webserver - assuming it is properly configured - you will easily be able to access the build output.

If you've cloned the repository to a folder *inaccessible* by the webserver, then you will have to make sure that the build output *is*. Either change the output directory in build.hxml, or copy the output to your webserver.

Accessing the output on a local webserver should then be as easy as:

```
http://localhost:8080/ufront-example-HelloWorld/www/
```

## Building

```
haxe build.hxml
```