package app;

import ufront.web.Controller;
import ufront.web.result.ViewResult;
import ufront.web.result.RedirectResult;

import Config;

using StringTools;

/**
 * Handles URI routing. View folder is set to root of view directory to avoid
 * UFront searching for views in '/view/Routes/' (because it guesses the folder
 * name to be the same as the class name).
 */
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