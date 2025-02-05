<?php

namespace Itpathsolutions\Databaseinfo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;

class PHPServerController extends Controller
{
    public function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $power = min($power, count($units) - 1); // Ensure power doesn't exceed the units array
        $value = $bytes / pow(1024, $power);
    
        return round($value, $precision) . ' ' . $units[$power];
    }

    public function isErrorReportingEnabled() {
        $errorReporting = error_reporting();
        $displayErrors = ini_get('display_errors');
    
        // If error_reporting is not 0 and display_errors is "1" or "On"
        return $errorReporting !== 0 && (strtolower($displayErrors) === '1' || strtolower($displayErrors) === 'on');
    }
    
    public function dbinfo() {
        $protocol_version = DB::select("SHOW VARIABLES LIKE 'protocol_version'");
        $databaseName = DB::getDatabaseName(); // Get the current database name
        $tables = DB::table('information_schema.tables')
            ->selectRaw('table_name AS `table_name`, ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS `size`')
            ->where('table_schema', $databaseName)
            ->groupBy('table_name')
            ->orderByRaw('`size` DESC')
            ->get();
        $collation = DB::select("SELECT @@collation_database AS collation")[0]->collation;
        $dbinfo = [
        // Database Information
            'database_connection' => config('database.default'),
            'database_name' => $databaseName,
            'database_version' => DB::selectOne('SELECT VERSION() as version')->version ?? 'N/A',
            'database_characterset' => DB::selectOne('SELECT @@character_set_database as charset'),
            'protocol_version' => (isset($protocol_version) && is_array($protocol_version)) ? $protocol_version[0]->Value : '',
            'database_host' => DB::connection()->getConfig('host'),
            'tables' => $tables,
            'collation' => $collation,
        ];
        return view('phpinfo::database', compact('dbinfo'));
 
    }

}
