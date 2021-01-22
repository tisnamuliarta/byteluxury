<?php

use Illuminate\Support\Facades\Route;

Route::get('logo', 'WelcomeController@mainLogo');
Route::resource("users", 'Api\MasterUserController');
Route::resource("menu", 'Api\MasterMenuController');
Route::resource("menu-user", 'Api\MasterMenuUserController');
