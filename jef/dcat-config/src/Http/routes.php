<?php

use Dcat\Admin\Jef\DcatConfig\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('jef/dcat-config', Controllers\DcatConfigController::class.'@index');
Route::any('jef/dcat-config', Controllers\DcatConfigController::class.'@index');
