# Getting Started

## Requirements

The project requires the [UFront](https://github.com/ufront/ufront) library (version 1.0.0-rc.6) and its dependencies.

## Preparation

### Get ufront

Install UFront and its dependencies through haxelib and set it up.

```
haxelib install ufront
haxelib run ufront --setup
```

### Host webserver

This being a web app, a webserver is required to host it. Personally, I use [USBWebserver](http://www.usbwebserver.net/en/) because it requires virtually no setup. However, [XAMPP](https://www.apachefriends.org/download.html) is a more popular alternative.

The project targets PHP, so make sure your webserver is properly configured. If you choose to target Neko, you can either configure your webserver for Neko by installing mod_neko, or run the nekotools server locally with `haxelib run ufront server`.

### Get repo source

Clone the repository to a folder of your choice. If that folder is accessible by your webserver - assuming it is properly configured - you will easily be able to access the build output.

If you've cloned the repository to a folder *inaccessible* by the webserver, then you will have to make sure that the build output *is*. Either change the output directory in build.hxml, or copy the output to your webserver.

Accessing the output on a local webserver should then be as easy as:

```
http://localhost:8080/ufront-example-HelloWorld/www/
```

Or even simpler, depending where you cloned the project to.

## Building

To build, run:

```
haxe build.hxml
```

The output is located in the `www` folder. The build script also creates a `project.xml` types description, used to generate documentation with the dox tool.