<?php namespace Agwood\Larassg;

use Illuminate\Support\ServiceProvider;
use Agwood\Larassg\Commands\SsgCommand;
use Agwood\Larassg\Helpers\ClassParse;
use Agwood\Larassg\Helpers\FileSystem;
use Agwood\Larassg\Helpers\String;
use Illuminate\Support\Facades\Config;

class LarassgServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{

    $this->package('agwood/larassg');

    $this->app->singleton('agwood::helpers.classparse',function(){

      $ClassParse = new ClassParse(new String(),new FileSystem());
      $ClassParse->ignoreClassWithName('BaseController');
      $ClassParse->addMethodSearchRegex(Config::get('larassg::method_name_search_pattern'));
      $ClassParse->parse(Config::get('larassg::controller_paths'));

      return $ClassParse;

    });

    include __DIR__.'/../../routes.php';

    $this->app->bind('agwood::command.larassg.serve',function($app){
      return new SsgCommand();
    });

    $this->commands(array(
      'agwood::command.larassg.serve'
    ));

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
