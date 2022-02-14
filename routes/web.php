<?php

use App\Http\Controllers\AdviserController;
use App\Http\Controllers\CirController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\MeritController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IrController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SiteHistoryController;
use App\Http\Controllers\SiteManualController;
use App\Http\Controllers\TestUploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VulnerableClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::redirect('/', 'dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('complaints', ComplaintController::class)->only([
        'index',
    ])->middleware(['permission:complaints']);


    Route::resource('memos', MemoController::class)->only([
        'index',
    ])->middleware(['permission:memos']);

    Route::resource('policy', PolicyController::class)->only([
        'index',
    ]);

    Route::resource('merits', MeritController::class)->only([
        'index',
    ]);

    Route::resource('attendance', AttendanceController::class)->only([
        'index',
    ]);

    Route::resource('claims', ClaimController::class)->only([
        'index',
    ])->middleware(['permission:claims']);

    Route::group(['as' => 'cir.', 'prefix' => 'cir'], function () {
        Route::get('login', [CirController::class, 'login'])->name('login')->middleware(['permission:cir']);
    });

    Route::group(['as' => 'ir.', 'prefix' => 'ir'], function () {
        Route::get('login', [IrController::class, 'login'])->name('login')->middleware(['permission:ir']);
    });

    Route::resource('vulnerable-clients', VulnerableClientController::class)->only([
        'index',
    ])->middleware(['permission:vulnerable-clients']);

    Route::resource('software', SiteController::class)->only([
        'index',
    ])->names([
        'index' => 'sites.index',
    ])->middleware(['permission:software']);

    Route::resource('software.manuals', SiteManualController::class)->only([
        'show',
    ])->parameters([
        'software' => 'site',
    ])->names([
        'show' => 'sites.manuals.show',
    ])->middleware(['permission:software-manuals']);

    Route::resource('software.history', SiteHistoryController::class)->only([
        'index',
    ])->parameters([
        'software' => 'site',
    ])->names([
        'index' => 'sites.history.index',
    ])->middleware(['permission:software-history']);

    Route::resource('advisers', AdviserController::class)->only([
        'index',
    ])->middleware(['permission:advisers']);



    // Route::get('/test', function () {
    //     return 'Hello World';
    // });

    // Route::controller(MemoController::class)->group(function () {
    //     // Route::get('/orders/{id}', 'show');
    //     Route::post('/signature', 'testsignature');
    // });

    // Route::get('/testing', 'MemoController@test');
    Route::get('/testing', [MemoController::class, 'testget']);

    // Route::post('/testing', [MemoController::class, 'testingsignature']);

    Route::post('/getmsg', [MemoController::class, 'submitmemo']);
    Route::post('/updategetmsg', [MemoController::class, 'memoupdate']);

    Route::post('/sendEmail', [MemoController::class, 'sendEmail']);

    Route::post('/memoDelete', [MemoController::class, 'memoDelete']);

    // Route::post('/signature', [MemoController::class, 'testsignature'])->name('testsignature');
    Route::post('/testsignature', 'MemoController@testsignature');


    Route::group(['as' => 'reports.', 'prefix' => 'reports'], function () {
        Route::group(['as' => 'complaints.', 'prefix' => 'complaints'], function () {
            Route::get('/', [ComplaintController::class, 'report'])->name('index')->middleware(['permission:complaints.generate-report']);
            Route::get('/{complaint}', [ComplaintController::class, 'pdf'])->name('pdf')->middleware(['permission:complaints.view-pdf']);
        });

        Route::group(['as' => 'policy.', 'prefix' => 'policy'], function () {
            Route::get('/', [PolicyController::class, 'report'])->name('index')->middleware(['permission:policy.generate-report']);
            Route::get('/{policy}', [PolicyController::class, 'pdf'])->name('pdf')->middleware(['permission:policy.view-pdf']);
        });

        Route::group(['as' => 'claims.', 'prefix' => 'claims'], function () {
            Route::get('/', [ClaimController::class, 'report'])->name('index')->middleware(['permission:claims.generate-report']);
            Route::get('/{claim}', [ClaimController::class, 'pdf'])->name('pdf')->middleware(['permission:claims.view-pdf']);
        });

        Route::group(['as' => 'vulnerable-clients.', 'prefix' => 'vulnerable-clients'], function () {
            Route::get('/', [VulnerableClientController::class, 'report'])->name('index')->middleware(['permission:vulnerable-clients.generate-report']);
            Route::get('{vulnerableClient}', [VulnerableClientController::class, 'pdf'])->name('pdf')->middleware(['permission:vulnerable-clients.view-pdf']);
        });

        Route::group(['as' => 'sites.', 'prefix' => 'software'], function () {
            Route::get('/', [SiteController::class, 'report'])->name('index')->middleware(['permission:software.generate-report']);
        });

        Route::group(['as' => 'advisers.', 'prefix' => 'advisers'], function () {
            Route::get('/{adviser}', [AdviserController::class, 'pdf'])->name('pdf')->middleware(['permission:advisers.view-pdf']);
        });

        Route::group(['as' => 'memos.', 'prefix' => 'memos'], function () {
            Route::get('/{memo}', [MemoController::class, 'pdf'])->name('pdf')->middleware(['permission:memos.view-pdf']);
        });
    });

    Route::resource('users', UserController::class)->only([
        'index',
    ])->middleware(['permission:users']);
});