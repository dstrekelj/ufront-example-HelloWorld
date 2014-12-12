import ufront.app.UfrontApplication;
import ufront.view.TemplatingEngines;

import Config;

/**
 * Application entry point.
 */
class Server
{
	/**
	 * Store UfrontApplication object for availability.
	 */
	public static var ufrontApp : UfrontApplication;

	/**
	 * Construct new UfrontApplication object. Configuration:
	 * - set index controller to app.Routes
	 * - set templating engine to Haxe
	 * - set default layout to 'layout.html'
	 * - set base path of app to app location on webserver
	 * Refer to cnf/app.json configuration file for details.
	 *
	 * Execute app once constructed.
	 */
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