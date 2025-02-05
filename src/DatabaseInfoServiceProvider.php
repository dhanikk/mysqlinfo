<?php
   
    namespace Itpathsolutions\Databaseinfo;
    use Illuminate\Support\ServiceProvider;
    class DatabaseInfoServiceProvider extends ServiceProvider {
        public function boot()
        {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadViewsFrom(__DIR__.'/resources/views', 'phpinfo');
            $this->mergeConfigFrom(
                __DIR__.'/Config/Databseinfo.php', 'databaseinfo'
            );
    
            // Publish configuration file to the application's config directory
            $this->publishes([
                __DIR__.'/Config/Databseinfo.php' => config_path('Databseinfo.php'),
            ]);
        }
        public function register()
        {
            //
        }
   }
?>