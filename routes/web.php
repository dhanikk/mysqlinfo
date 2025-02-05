<?php
    use Illuminate\Support\Facades\Route;
    use Itpathsolutions\Databaseinfo\Http\Controllers\PHPServerController;

    Route::get('/dashboard/database-info', [PHPServerController::class, 'dbinfo']);
?>