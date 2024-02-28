<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PosController;

    Route::get('/items', [PosController::class,'index']);
    Route::post('/addtocart', [PosController::class,'addtocart']);
    Route::post('/show-item', [PosController::class,'show']);
    Route::get('/items/checkout', [PosController::class,'checkout']);
    Route::post('/deleteitem', [PosController::class,'deleteitem']);
    Route::post('/apply-discount', [PosController::class,'applydiscount']);
    Route::post('/remove-discount', [PosController::class,'removediscount']);
    Route::post('/qtyupdate', [PosController::class,'qtyupdate']);
    Route::post('/placeorder', [PosController::class,'placeorder']);
    Route::get('/orders', [PosController::class,'orders']);