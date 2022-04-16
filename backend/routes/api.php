<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\v1\AssetController;
use App\Http\Controllers\Api\v1\AssetCategoryController;
use App\Http\Controllers\Api\v1\AssetFoldersController;
use App\Http\Controllers\Api\v1\AuthenticationController;
use App\Http\Controllers\Api\v1\ColorController;
use App\Http\Controllers\Api\v1\DealerController;
use App\Http\Controllers\Api\v1\DealerGroupController;
use App\Http\Controllers\Api\v1\DealerZoneController;
use App\Http\Controllers\Api\v1\ForgotPasswordController;
use App\Http\Controllers\Api\v1\InquiryController;
use App\Http\Controllers\Api\v1\NewsController;
use App\Http\Controllers\Api\v1\InventoryController;
use App\Http\Controllers\Api\v1\LeadsController;
use App\Http\Controllers\Api\v1\ModelVehicleController;
use App\Http\Controllers\Api\v1\ModelYearController;
use App\Http\Controllers\Api\v1\ReservationController;
use App\Http\Controllers\Api\v1\TestDriveController;
use App\Http\Controllers\Api\v1\TestDriveUnitController;
use App\Http\Controllers\Api\v1\SalesConsultantController;
use App\Http\Controllers\Api\v1\VariantController;
use App\Http\Controllers\Api\v1\VariantColorController;
use App\Models\ModelVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\QuotationController;
use App\Http\Controllers\Api\v1\ActionController;
use App\Http\Controllers\Api\v1\ReportController;
use App\Http\Controllers\Api\v1\StatusController;
use App\Http\Controllers\DealerUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
return $request->user();
}); */

Route::post('inquiry-add', [InquiryController::class, 'add'])->name('inquiry.add');
Route::post('reservation', [ReservationController::class, 'store'])->name('reservation.store');

Route::post('/v1/assets/upload', [AssetController::class, 'uploadFile']);

Route::name('honda.')
    ->prefix('v1')
    ->group(function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::group(['middleware' => 'guest'], function () {
                Route::post('login', [AuthenticationController::class, 'login'])->name('login');
                Route::post('register', [AuthenticationController::class, 'register'])->name('register');
                Route::post('forgot-password', [ForgotPasswordController::class, 'forgot'])->name('password.forgot');
                Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.reset');
            });
            Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
        });

        Route::get('actions', [ActionController::class, 'index']);
        Route::get('statuses', [StatusController::class, 'index']);

        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::get('me', function (Request $request) {
                return auth()->user();
            })->name('user');

            Route::resource('news', NewsController::class);
            Route::resource('inventories', InventoryController::class);
            Route::get('inventory-dealer', [InventoryController::class, 'dealer'])->name('inventory.dealer');
            Route::post('inventory-add', [InventoryController::class, 'add'])->name('inventory.add');
            Route::resource('inquiries', InquiryController::class);
            Route::resource('reservation', ReservationController::class);
            Route::resource('leads', LeadsController::class);
            Route::get('leads-download', [LeadsController::class, 'download']);
            Route::resource('test-drive', TestDriveController::class);
            Route::resource('test-drive-unit', TestDriveUnitController::class);

            Route::resource('quotation', QuotationController::class);
            Route::post('quotation/{id}/upload', [QuotationController::class, 'upload']);

            Route::resource('assets/categories', AssetCategoryController::class);
            Route::get('assets/categories/{id}/folders', [AssetCategoryController::class, 'folders']);
            Route::resource('assets/folders', AssetFoldersController::class);
            Route::get('assets/folders/{id}/assets', [AssetFoldersController::class, 'assets']);
            Route::get('assets/storage', [AssetController::class, 'storage']);
            Route::get('assets/branding-guidelines', [AssetController::class, 'getBrandingGuidelines']);
            Route::post('assets/branding-guidelines', [AssetController::class, 'updateBrandingGuidelines']);
            Route::resource('assets', AssetController::class);
            Route::post('assets/{id}', [AssetController::class, 'update']);
            Route::post('assets/{id}/download', [AssetController::class, 'download']);

            Route::resource('model/years', ModelYearController::class);
            Route::resource('colors', ColorController::class);
            Route::resource('models', ModelVehicleController::class);
            Route::resource('variants', VariantController::class);
            Route::resource('variant/colors', VariantColorController::class);

            Route::resource('dealer/zones', DealerZoneController::class);
            Route::resource('dealer/groups', DealerGroupController::class);
            Route::resource('dealers', DealerController::class);
            Route::resource('dealer/users', DealerUserController::class);

            Route::resource('sales-consultants', SalesConsultantController::class);
            Route::post('sales-consultants/upload', [SalesConsultantController::class, 'insert'])->name('sales_consultant.insert');

            Route::post('reports/download', [ReportController::class, 'download'])->name('reports.download');
            Route::post('reports/index', [ReportController::class, 'index'])->name('reports.index');

            Route::get('regions', [AddressController::class, 'index_region'])->name('regions');
            Route::get('regions/{region}/provinces', [AddressController::class, 'region_provinces'])->name('regions.provinces');

            Route::get('barangays', [AddressController::class, 'index_barangay'])->name('barangay');

            Route::get('cities', [AddressController::class, 'index_city'])->name('cities');
            Route::get('cities/{city}/barangays', [AddressController::class, 'cities_barangays'])->name('cities.barangays');

            Route::get('provinces', [AddressController::class, 'index_province'])->name('provinces');
            Route::get('provinces/{province}/cities', [AddressController::class, 'province_cities'])->name('provinces.cities');
        });
    });
