<?php namespace Jux\Jform;

use Illuminate\Support\ServiceProvider;

class JformServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

        $this->app['jform'] = $this->app->share(function( $app ){
            return new Jform( $app['form'] );
        });

        $this->app->booting(function()
        {

            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Jform', 'Jux\Jform\Facades\Jform');
        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array( 'jform');
	}

}
