<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});


Route::get('main', function(){
    return "This is The world of Programming";
});

Route::get('check-db', function() {
    try {
        DB::connection()->getPdo(); // Test DB connection
        $tables = DB::select('SHOW TABLES'); // List all tables
        return response()->json([
            'status' => 'Connected!',
            'tables' => $tables
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'Failed!',
            'error' => $e->getMessage()
        ]);
    }
});
