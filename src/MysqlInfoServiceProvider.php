<?php
   
    namespace Itpathsolutions\Mysqlinfo;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Config;

    class MysqlInfoServiceProvider extends ServiceProvider {
        public function register()
        {
            //
        }
        public function boot(): void
        {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadViewsFrom(__DIR__.'/resources/views', 'mysqlinfo');
            $this->mergeConfigFrom(
                __DIR__.'/Config/Mysqlinfo.php', 'mysqlinfo'
            );
    
            // Publish configuration file to the application's config directory
            $this->publishes([
                __DIR__ . '/Config/Mysqlinfo.php' => Config::get('mysqlinfo.path', __DIR__ . '/../config/Mysqlinfo.php'),
            ]);
        }
   }
?>