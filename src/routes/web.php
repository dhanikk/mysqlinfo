<?php
    use Illuminate\Support\Facades\Route;
    use Itpathsolutions\Mysqlinfo\Http\Controllers\PHPServerController;

    Route::get('/dashboard/mysql-info', [PHPServerController::class, 'mysqlinfo']);
    Route::get('/dashboard/process-list', [PHPServerController::class, 'showprocesslist'])->name("processlist");
?>