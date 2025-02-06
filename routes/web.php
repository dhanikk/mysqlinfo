<?php
    use Illuminate\Support\Facades\Route;
    use Itpathsolutions\Mysqlinfo\Http\Controllers\PHPServerController;

    Route::get('/dashboard/mysql-info', [PHPServerController::class, 'mysqlinfo']);
?>