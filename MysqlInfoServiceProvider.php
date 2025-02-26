<?php
   
    namespace Itpathsolutions\Mysqlinfo;
    use Illuminate\Support\ServiceProvider;
    class MysqlInfoServiceProvider extends ServiceProvider {
        public function boot(): void
        {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadViewsFrom(__DIR__.'/resources/views', 'mysqlinfo');
            $this->mergeConfigFrom(
                __DIR__.'/config/mysqlinfo.php', 'mysqlinfo'
            );
            
            $this->publishes([
                __DIR__.'/config/mysqlinfo.php' => config_path('mysqlinfo.php'),
            ]);            
        }
        public function register()
        {
            //
        }
   }
?>