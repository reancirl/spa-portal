<?php

use App\Http\Controllers\Api\v1\InquiryController;
use App\Http\Controllers\Api\v1\InventoryController;
use App\Http\Controllers\Api\v1\LeadsController;
use App\Http\Controllers\Api\v1\TestDriveUnitController;
use App\Http\Controllers\Api\v1\QuotationController;
use App\Http\Controllers\Test;
use App\Jobs\StoreInquiryJobs;
use App\Models\Dealer;
use App\Models\InquiriesUpload;
use App\Models\Inquiry;
use App\Models\InventoriesUpload;
use App\Models\Inventory;
use App\Models\Leads;
use App\Models\UploadStatus;
use App\Services\InventoryService;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Box\Spout\Writer\Common\Entity\Options;
use Box\Spout\Writer\Common\Manager\WorkbookManagerAbstract;
use Box\Spout\Writer\XLSX\Manager\WorksheetManager;
use Box\Spout\Writer\XLSX\Writer;
use App\Http\Controllers\Api\v1\AssetController;
use App\Http\Controllers\Api\v1\ReportController;
use App\Http\Controllers\Api\v1\SalesConsultantController;
use App\Jobs\SQLJob;
use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use GuzzleHttp\Handler\Proxy;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('upload', function () {
    return view('upload');
});

Route::post('upload', [TestDriveUnitController::class, 'store']);
Route::get('assets/{id}/file/{filename}/download', [AssetController::class, 'getDownload']);
Route::get('assets/branding-guidelines/download', [AssetController::class, 'downloadBrandingGuidelines']);

Route::get('quotation/{id}/download', [QuotationController::class, 'download']);

Route::view('forgot_password', 'auth.reset_password')->name('password.reset');
