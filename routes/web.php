<?php

use Illuminate\Support\Facades\Route;

use Web\Http\Controllers\PostController;
use Web\Http\Controllers\MenuController;

/**
 * Web Routes
 */
Route::group(['prefix' => 'web', 'middleware' => 'web'], function(){

    Route::get('/menu/{key}', [MenuController::class, 'index'])->name('delgont.web.menu');

    Route::get('/posts/post/{id}', [PostController::class, 'index'])->name('delgont.web.post');
    Route::get('/posts/post/{id}/children', [PostController::class, 'children'])->name('delgont.web.post.children');
    Route::get('/posts/oftype/{type}', [PostController::class, 'ofType'])->name('delgont.web.posts.ofType');
    Route::get('/posts/ofcategory/{category}', [PostController::class, 'ofCategory'])->name('delgont.web.posts.ofCategory');

});
