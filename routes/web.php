<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController; 

Route::get('/', function () {
    return inertia('Home');
});
Route::get('/auth/create', function () {
    return inertia('Auth/Create');
});



Route::resource('users', UserController::class);

// return redirect('/filelist');
// });

Route::post('/auth/login', function () {
    return inertia('Auth/Login');
    });

Route::get('/filelist', function () {
    $allFiles = Storage::allFiles('/unimported');
    $archivedFiles = Storage::allFiles('/archived');
    return response()->json ([
        'files' => $allFiles,
        'archivedFiles' => $archivedFiles,
    ]);
});

