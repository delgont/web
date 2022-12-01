<?php

namespace Web;

use Illuminate\Support\ServiceProvider;

use Web\Concerns\RegistersCommands;
use Web\Services\MenuService;


class DelgontWebServiceProvider extends ServiceProvider
{
    use RegistersCommands;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'web');
        
        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
        }
    }

    private function registerPublishables() : void
    {
        $this->registerCommands();

        $this->publishes([
            __DIR__.'/../config/web.php' => config_path('web.php')
        ], 'delgont-web-config');

        $this->publishes([
            __DIR__.'/../config/data.php' => config_path('data.php')
        ], 'delgont-web-data-config');

        $this->publishes([
            __DIR__.'/../img' => public_path(),
          ], 'delgont-web-images');
    }


    /**
     * Register helper functions
     */
    private function registerHelpers()
    {
        $helpers = glob( __DIR__.'/Helpers'.'/*.php');
        foreach($helpers as $key => $helper){
            require_once($helper);
        }
    }

    private function mainNavbarMenuViewComposer()
    {
        view()->composer(config('web.navbar', 'web.includes.navbar'), function($view){
            $view->with('mainMenuItems', (new MenuService())->get('main_menu'));
        });

        view()->composer('web.includes.footer', function($view){
            $view->with('footerMenuItems', (new MenuService())->getSimpleMenu('footer_menu'));
        });
    }

  
}
