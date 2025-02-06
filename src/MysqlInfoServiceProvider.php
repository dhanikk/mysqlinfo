<?php
   
    namespace Itpathsolutions\Mysqlinfo;
    use Illuminate\Support\ServiceProvider;
    class MysqlInfoServiceProvider extends ServiceProvider {
        public function register()
        {
            //
        }
        public function boot()
        {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadViewsFrom(__DIR__.'/resources/views', 'mysqlinfo');
            $this->mergeConfigFrom(
                __DIR__.'/Config/Mysqlinfo.php', 'mysqlinfo'
            );
    
            // Publish configuration file to the application's config directory
            $this->publishes([
                __DIR__.'/Config/Mysqlinfo.php' => config_path('Mysqlinfo.php'),
            ]);
        }
   }
?>