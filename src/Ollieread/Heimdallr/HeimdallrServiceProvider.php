<?php namespace Ollieread\Heimdallr;

use Illuminate\Support\ServiceProvider;
use Ollieread\Heimdallr\Commands\CreateAccessPermission;
use Ollieread\Heimdallr\Commands\CreateAccessResource;
use Ollieread\Heimdallr\Commands\CreateAccessRights;
use Ollieread\Heimdallr\Commands\CreateAccessRole;

class HeimdallrServiceProvider extends ServiceProvider
{

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
        $this->registerHeimdallr();
        $this->registerCommands();
	}

    protected function registerHeimdallr()
    {
        $this->app->bind('heimdallr', function($app)
        {
            return new Heimdallr();
        });
    }

    protected function registerCommands()
    {
        $this->app->bind('heimdallr::command.access.role', function($app)
        {
            return new CreateAccessRole();
        });

        $this->app->bind('heimdallr::command.access.resource', function($app)
        {
            return new CreateAccessResource();
        });

        $this->app->bind('heimdallr::command.access.permission', function($app)
        {
            return new CreateAccessPermission();
        });

        $this->app->bind('heimdallr::command.access.rights', function($app)
        {
            return new CreateAccessRights();
        });

        $this->commands([
            'heimdallr::command.access.role',
            'heimdallr::command.access.resource',
            'heimdallr::command.access.permission',
            'heimdallr::command.access.rights'
        ]);
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
