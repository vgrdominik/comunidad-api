<?php

use Illuminate\Http\Request;
use App\Modules\User\Transformers\User as UserTransformer;

Route::middleware('auth:airlock')->get('/user', function (Request $request) {
    return new UserTransformer(auth()->user());
});

// Used to user authentication api

Route::namespace('\\App\\Modules\\User\\Infrastructure\\Controller\\')->group(function () {
    Route::post('/login', 'Api@login');
    // TODO Route::post('/refreshToken', 'Api@refreshToken');
    Route::middleware('auth:airlock')->post('/logout', 'Api@logout');
    Route::post('/forgotReset', 'Api@forgotReset');
    Route::post('/forgotSendResetLinkEmail', 'Api@forgotSendResetLinkEmail');
    Route::post('/register', 'Api@register');
    Route::post('/verify', 'Api@verify');
});

// Usual routes authed
Route::namespace('\\App\\Modules\\')->group(function () {
    Route::namespace('Raffle\\Infrastructure\\Controller')->group(function () {
        Route::get('raffleSummary', 'Api@index');
    });
});
Route::namespace('\\App\\Modules\\')->middleware('auth:airlock')->group(function () {
    Route::namespace('Event\\Infrastructure\\Controller')->group(function () {
        Route::resource('event', 'Api');
    });
});
Route::namespace('\\App\\Modules\\')->middleware(['auth:airlock', 'role:admin'])->group(function () {
    Route::namespace('Payment\\Infrastructure\\Controller')->group(function () {
        Route::resource('payment', 'Api');
    });
    Route::namespace('Raffle\\Infrastructure\\Controller')->group(function () {
        Route::resource('raffle', 'Api');
        Route::post('raffleUploadPhoto/{raffle}', 'Api@uploadPhoto');
    });
});
