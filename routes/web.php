<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Home');
});


Route::get('/filelist', function () {
    $allFiles = Storage::allFiles('/unimported');
    $archivedFiles = Storage::allFiles('/archived');
    return response()->json ([
        'files' => $allFiles,
        'archivedFiles' => $archivedFiles,
    ]);
});

// Route::post('/filehandler', [FileHandlerController::class, 'handleFile']); {
//     return inertia('Home');
// });

