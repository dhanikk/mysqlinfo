<?php

namespace Itpathsolutions\Mysqlinfo\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class PHPServerController extends Controller
{
    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $power = min((int) $power, count($units) - 1);
        $value = $bytes / pow(1024, $power);
        return round($value, $precision) . ' ' . $units[$power];
    }

    public function isErrorReportingEnabled(): bool
    {
        $errorReporting = error_reporting();
        $displayErrors = ini_get('display_errors');
        $displayErrors = is_string($displayErrors) ? strtolower($displayErrors) : '0';
        // If error_reporting is not 0 and display_errors is "1" or "On"
        return $errorReporting !== 0 && ($displayErrors === '1' || $displayErrors === 'on');
    }
    
    public function mysqlinfo(): View
    {
        try {
            $collations = DB::table('information_schema.collations')->select('*')->orderBy('CHARACTER_SET_NAME')->get();
            $metrics = DB::select("
                SHOW GLOBAL STATUS 
                WHERE Variable_name IN (
                    'Bytes_received',
                    'Bytes_sent',
                    'Connections',
                    'Aborted_connects',
                    'Max_used_connections',
                    'Connection_errors_internal',
                    'Connection_errors_max_connections',
                    'Connection_errors_peer_address',
                    'Connection_errors_select',
                    'Connection_errors_tcpwrap'
                )
            ");

            // Parse the results
            $metricsData = collect($metrics)->mapWithKeys(function ($item): array {
                $item = (array) $item;
                return [$item['Variable_name'] => $item['Value']];
            });

            // Calculate total traffic
            $bytesReceived = isset($metricsData['Bytes_received']) && is_numeric($metricsData['Bytes_received']) ? (int) $metricsData['Bytes_received'] : 0;
            $bytesSent = isset($metricsData['Bytes_sent']) && is_numeric($metricsData['Bytes_sent']) ? (int) $metricsData['Bytes_sent'] : 0;
            $totalTraffic = $bytesReceived + $bytesSent;

            $uptime = DB::selectOne("SHOW GLOBAL STATUS WHERE Variable_name = 'Uptime'");

            $uptimeSeconds = is_object($uptime) && property_exists($uptime, 'Value') && is_numeric($uptime->Value) ? (int) $uptime->Value : 1;
            $startTime = Carbon::now()->subSeconds($uptimeSeconds);

            $trafficStats = [
                'received' => $this->formatBytes(is_numeric($metricsData['Bytes_received'] ?? null) ? (int) $metricsData['Bytes_received'] : 0),
                'sent' => $this->formatBytes(is_numeric($metricsData['Bytes_sent'] ?? null) ? (int) $metricsData['Bytes_sent'] : 0),
                'received_per_hour' => $this->formatBytes((int) ($bytesReceived / max(1, $uptimeSeconds / 3600))),
                'sent_per_hour' => $this->formatBytes((int) ($bytesSent / max(1, $uptimeSeconds / 3600))),
                'total_traffic' => $this->formatBytes((is_numeric($metricsData['Bytes_received'] ?? null) ? (int) $metricsData['Bytes_received'] : 0) + (is_numeric($metricsData['Bytes_sent'] ?? null) ? (int) $metricsData['Bytes_sent'] : 0)),
                'total_per_hour' => $this->formatBytes((int) (((isset($metricsData['Bytes_received']) && is_numeric($metricsData['Bytes_received']) ? (int) $metricsData['Bytes_received'] : 0) + (isset($metricsData['Bytes_sent']) && is_numeric($metricsData['Bytes_sent']) ? (int) $metricsData['Bytes_sent'] : 0)) / max(1, $uptimeSeconds / 3600))),
                'connections' => $metricsData['Connections'] ?? 0,
                'connections_per_hour' => round((isset($metricsData['Connections']) && is_numeric($metricsData['Connections']) ? (int) $metricsData['Connections'] : 0) / max(1, $uptimeSeconds / 3600), 2),
                'failed_attempts' => $metricsData['Aborted_connects'] ?? 0,
                'failed_per_hour' => round((isset($metricsData['Aborted_connects']) && is_numeric($metricsData['Aborted_connects'])? (int) $metricsData['Aborted_connects'] : 0) / max(1, $uptimeSeconds / 3600), 2),
                'max_concurrent_connections' => $metricsData['Max_used_connections'] ?? 0,
                'uptime' => $uptimeSeconds,
                'server_started_at' => $startTime->toDateTimeString(),
            ];

            DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            $protocol_version = DB::select("SHOW VARIABLES LIKE 'protocol_version'");
            $databaseName = DB::getDatabaseName(); // Get the current database name
            $tables = DB::table(DB::raw('information_schema.tables as t'))
            ->selectRaw('
                t.table_name AS `table_name`,
                ROUND(t.data_length / 1024 / 1024, 2) AS `data_size_mb`,
                ROUND(t.index_length / 1024 / 1024, 2) AS `index_size_mb`,
                ROUND((t.data_length + t.index_length) / 1024 / 1024, 2) AS `total_size_mb`,
                t.table_rows AS `total_rows`,
                t.TABLE_TYPE AS `table_type`,
                t.TABLE_COLLATION AS `collation`,
                COUNT(DISTINCT tr.TRIGGER_NAME) AS `trigger_count`,
                COUNT(DISTINCT s.INDEX_NAME) AS `index_count`,
                COUNT(DISTINCT r.ROUTINE_NAME) AS `procedure_count`
            ')
            ->leftJoin(DB::raw('information_schema.triggers as tr'), function (JoinClause $join) use ($databaseName) {
                $join->on('t.table_name', '=', 'tr.EVENT_OBJECT_TABLE')
                     ->where('tr.TRIGGER_SCHEMA', '=', $databaseName);
            })
            
            ->leftJoin(DB::raw('information_schema.statistics as s'), function (JoinClause $join) use ($databaseName) {
                $join->on('t.table_name', '=', 's.TABLE_NAME')
                    ->where('s.TABLE_SCHEMA', '=', $databaseName);
            })
            ->leftJoin(DB::raw('information_schema.routines as r'), function (JoinClause $join) use ($databaseName) {
                $join->where('r.ROUTINE_TYPE', '=', 'PROCEDURE')
                    ->where('r.ROUTINE_SCHEMA', '=', $databaseName);
            })
            ->where('t.table_schema', $databaseName)
            ->groupBy('t.table_name', 't.TABLE_TYPE', 't.TABLE_COLLATION', 't.table_rows')
            ->orderByRaw('`total_size_mb` DESC')
            ->get();
            $indexes = DB::table('information_schema.statistics as s')
                    ->selectRaw('
                        s.TABLE_NAME as table_name,
                        s.INDEX_NAME as index_name,
                        s.NON_UNIQUE,
                        s.SEQ_IN_INDEX,
                        s.COLUMN_NAME,
                        ROUND(SUM(t.index_length) / COUNT(DISTINCT s.INDEX_NAME) / 1024 / 1024, 2) as index_size_mb
                    ')
                    ->join('information_schema.tables as t', function (JoinClause $join) use ($databaseName) {
                        $join->on('s.TABLE_SCHEMA', '=', 't.TABLE_SCHEMA')
                        ->on('s.TABLE_NAME', '=', 't.TABLE_NAME')
                        ->where('t.TABLE_SCHEMA', '=', $databaseName);
                    })
                    ->where('s.TABLE_SCHEMA', $databaseName)
                    ->groupBy('s.TABLE_NAME', 's.INDEX_NAME')
                    ->get();
            $result = DB::select("SELECT @@collation_database AS collation");
            $collation = isset($result[0]) && is_object($result[0]) && property_exists($result[0], 'collation') ? $result[0]->collation : null;
            $totalSize = DB::select('SELECT SUM(data_length + index_length) AS total_size FROM information_schema.tables WHERE table_schema = ?', [$databaseName]);
            $engine = DB::select('SELECT engine FROM information_schema.tables WHERE table_schema = ? LIMIT 1', [$databaseName]);

            $stats = DB::select('SELECT 
                (SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = ?) AS table_count,
                (SELECT SUM(table_rows) FROM information_schema.tables WHERE table_schema = ?) AS row_count,
                (SELECT SUM(data_length) / (1024 * 1024) FROM information_schema.tables WHERE table_schema = ?) AS data_size,
                (SELECT SUM(index_length) / (1024 * 1024) FROM information_schema.tables WHERE table_schema = ?) AS index_size,
                (SELECT SUM(data_free) FROM information_schema.tables WHERE table_schema = ?) AS overhead
            ', [$databaseName, $databaseName, $databaseName, $databaseName, $databaseName]);

            // To get the size in bytes
            $totalSizeInBytes = isset($totalSize[0]) && is_object($totalSize[0]) && property_exists($totalSize[0], 'total_size') && is_numeric($totalSize[0]->total_size) ? (float) $totalSize[0]->total_size : 0;

            // To convert the size to a more readable format
            $sizeInMB = number_format($totalSizeInBytes / 1024 / 1024, 2);
            $sizeInGB = number_format($totalSizeInBytes / 1024 / 1024 / 1024, 2);
            $database_version = DB::selectOne('SELECT VERSION() as version');

            $dbinfo = [
            // Database Information
                'database_connection' => Config::get('database.default'),
                'database_name' => $databaseName,
                'database_version' =>  is_object($database_version) && property_exists($database_version, 'version') ? $database_version->version : 'N/A',
                'database_characterset' => DB::selectOne('SELECT @@character_set_database as charset'),
                'protocol_version' => isset($protocol_version[0]) && is_object($protocol_version[0]) && property_exists($protocol_version[0], 'Value') ? $protocol_version[0]->Value: '',
                'database_host' => DB::connection()->getConfig('host'),
                'tables' => $tables,
                'collation' => $collation,
                'size' => ['MB' => $sizeInMB, 'GB' => $sizeInGB],
                'engine' => isset($engine[0]) && is_object($engine[0]) && property_exists($engine[0], 'ENGINE') ? $engine[0]->ENGINE : '',
                'stats' => $stats[0],
                'indexes' => $indexes,
                'trafficStats' => $trafficStats,
                'collations' => $collations
            ];
            return view('mysqlinfo::database', compact('dbinfo'));

        } catch (\Throwable $th) {
            $errorMessage = 'Something went wrong! Please try again later.' . $th->getMessage();
            if ($th instanceof \PDOException) {
                $errorMessage = 'Database connection failed! Please check your database credentials.';
            } elseif (str_contains($th->getMessage(), 'SQLSTATE[HY000] [2002]')) {
                $errorMessage = 'Could not connect to the database server. Please check your database host.';
            } elseif (str_contains($th->getMessage(), 'SQLSTATE[HY000] [1045]')) {
                $errorMessage = 'Database authentication failed. Please verify your username and password.';
            } elseif (str_contains($th->getMessage(), 'SQLSTATE[42S02]')) {
                $errorMessage = 'The requested database table does not exist. Please check your database structure.';
            } else {
                $errorMessage = $th->getMessage();
            }
            return view('mysqlinfo::database')->withErrors(['error' => $errorMessage]);
        }
    }

    public function showprocesslist(): JsonResponse
    {
        // load processlist
        try {
            $processList = DB::select('SHOW PROCESSLIST');
            return Response::json(['success' => true, 'data' => $processList]);
        } catch (\Throwable $th) {
            $errorMessage = 'Something went wrong! Please try again later.' . $th->getMessage();
            if ($th instanceof \PDOException) {
                $errorMessage = 'Database connection failed! Please check your database credentials.';
            } elseif (str_contains($th->getMessage(), 'SQLSTATE[HY000] [2002]')) {
                $errorMessage = 'Could not connect to the database server. Please check your database host.';
            } elseif (str_contains($th->getMessage(), 'SQLSTATE[HY000] [1045]')) {
                $errorMessage = 'Database authentication failed. Please verify your username and password.';
            } elseif (str_contains($th->getMessage(), 'SQLSTATE[42S02]')) {
                $errorMessage = 'The requested database table does not exist. Please check your database structure.';
            } else {
                $errorMessage = $th->getMessage();
            }
            return Response::json(['success' => false, 'error' => $errorMessage], 500);
        }
    }

}
