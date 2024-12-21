<?php

use App\Models\Post;
use App\Models\User;
use App\DataTables\UsersDataTable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (UsersDataTable $dataTable) {
    return $dataTable->render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('create-role', function () {
    // $role = Role::create(['name' => 'writer']);

    // return $role;

    // $permission = Permission::create(['name' => 'edit articles']);

    // return $permission;

    $user = auth()->user();
    // $user->assignRole('writer');
    // $user->load('roles');

    // $user->givePermissionTo('edit articles');
    // $user->load('permissions');

    // $checkPermission = $user->can('edit articles');

    if ($user->can('edit articles')) {
        return 'user has permission';
    } else {
        return 'user does not have permission';
    }
});

Route::get('posts', function () {
    $posts = Post::all();
    return view('post.post', compact('posts'));
});
