<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', fn (Request $request) => $request->expectsJson() ? response()->json('Hello World') : 'Hello World');
