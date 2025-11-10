<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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


Route::get('users', function () {
    $users = User::all(); // Fetch all users
    return response()->json($users); // Return JSON
});

Route::get('/get-users', function () {
    $users = DB::table('users')->get(); // Fetch all rows from users table
    return response()->json($users);
});

Route::get('/show-users', function () {
    try {
        $users = User::all(); // fetch all rows from 'users' table
        return response()->json([
            'status' => 'Connected',
            'count' => $users->count(),
            'data' => $users
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'Error',
            'message' => $e->getMessage()
        ]);
    }
});

