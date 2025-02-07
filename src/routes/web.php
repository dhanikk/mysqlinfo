<?php
    use Illuminate\Support\Facades\Route;
    use Itpathsolutions\Mysqlinfo\Http\Controllers\PHPServerController;

    Route::get('/mysql-info', [PHPServerController::class, 'mysqlinfo']);
    Route::get('/process-list', [PHPServerController::class, 'showprocesslist'])->name("processlist");
?>