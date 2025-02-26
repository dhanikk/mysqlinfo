<?php

namespace Itpathsolutions\Mysqlinfo;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class QueryLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Config::get('app.debug')) { // Enable query logging only in debug mode
            DB::listen(function ($query){
                static $slowQueryThreshold = 100;
                static $modelTables = null;

                if ($modelTables === null) {
                    $modelTables = collect(File::allFiles(App::path('Models')))
                        ->map(function ($file){
                            $namespace = 'App\\Models\\';
                            $class = $namespace . pathinfo($file->getFilename(), PATHINFO_FILENAME);

                            if (class_exists($class) && is_subclass_of($class, \Illuminate\Database\Eloquent\Model::class)) {
                                return [
                                    'model' => $class,
                                    'table' => (new $class)->getTable(),
                                ];
                            }

                            return null;
                        })
                        ->filter()
                        ->values()
                        ->toArray();
                }

                // Extract the table name from the query
                $table = '';
                if (is_object($query) && property_exists($query, 'sql') && is_string($query->sql)) {
                    if (preg_match('/from `(\w+)`/i', $query->sql, $matches)) {
                        $table = $matches[1];
                    } elseif (preg_match('/join `(\w+)`/i', $query->sql, $matches)) {
                        $table = $matches[1];
                    }
                }

                // Skip queries not related to model tables
                $tableNames = is_array($modelTables) ? array_column($modelTables, 'table') : [];
                if (!in_array($table, $tableNames)) {
                    return;
                }

                // Format the SQL query with bindings
                $sqlWithBindings = '';
                if (is_object($query) && isset($query->sql, $query->bindings) && is_string($query->sql) &&  is_array($query->bindings) ) {
                    $sqlWithBindings = vsprintf(str_replace('?', '%s', (string) $query->sql), array_map(function ($binding) { // Cast to string for safety
                            return is_scalar($binding) ? (is_numeric($binding) ? $binding : "'$binding'") : 'NULL'; // Convert only scalar values, otherwise return 'NULL' for objects/arrays
                        }, $query->bindings)
                    );
                }
                
                $queryLogs = [];
                $logFilePath = Storage::path('logs/query_logs.json');
                if (file_exists($logFilePath)) {
                    $existingLogs = file_get_contents($logFilePath);
                    $decodedLogs = json_decode(is_string($existingLogs) ? $existingLogs : '', true);                    
                    $queryLogs = is_array($decodedLogs) ? $decodedLogs : [];
                }

                // Ensure $query is an object and has the necessary properties
                if (is_object($query) && isset($query->bindings, $query->time)) {
                    $modelName = is_array($modelTables) && !empty($modelTables) && isset($modelTables[0]) && is_array($modelTables[0]) ? $modelName = $modelTables[0]['model'] ?? null : null;
                    $queryLogs[] = [
                        'sql' => $sqlWithBindings,
                        'bindings' => is_array($query->bindings) ? $query->bindings : [],
                        'time' => is_numeric($query->time) ? $query->time : 0,
                        'timestamp' => Carbon::now(),
                        'model' => $modelName,
                        'threshold' => ($query->time > $slowQueryThreshold) ? 'slow' : null,
                    ];
                }

                // Limit logs to the last 100 queries
                if (count($queryLogs) > 100) {
                    array_shift($queryLogs);
                }

                // Store updated logs back in the cache
                // \Cache::put('query_logs', $queryLogs, 3600); // Cache for 1 hour
                file_put_contents($logFilePath, json_encode($queryLogs, JSON_PRETTY_PRINT));
            });
            
        }
    }
}
