<?php

namespace App\Jobs;

use App\Models\Dealer;
use App\Models\FileFolder;
use App\Models\Inquiry;
use App\Models\Inventory;
use App\Models\Leads;
use App\Models\Notifications;
use App\Models\TestDrive;
use App\Models\TestDriveUnit;
use App\Models\Role;
use App\Models\UploadStatus;
use App\Models\User;
use App\Models\UserRole;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

class ExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public $modelUploaded;

    public $folderName;

    public $authUser;

    public function __construct($modelUploaded, $folderName, $authUser)
    {
        $this->modelUploaded = $modelUploaded;
        $this->folderName        = $folderName;
        $this->authUser           = $authUser;
    }

    /**
     * Execute the job.
     * 1. Update status of inventories_upload to processing
     * 2. Read the uploaded file
     * 3. Insert to inventories table
     * 4. Update status to completed
     * 5. Insert to notifications table (failed and success)
     *
     * @return void
     */
    public function handle()
    {

        $this->modelUploaded->update([
            'status' => UploadStatus::STAT_PROCESSING,
        ]);

        /** inventory **/
        if (FileFolder::FOLDER_INVENTORY == $this->folderName) {
            $invSoftDelete = Inventory::get();
            $invSoftDelete->each->delete();
            $path =  public_path('storage'. DIRECTORY_SEPARATOR . UploadStatus::FOLDER_INVENTORY . DIRECTORY_SEPARATOR . $this->modelUploaded->filename);
        }
        /** inquiries **/
        if (FileFolder::FOLDER_INQUIRIES == $this->folderName) {

            if (!$this->authUser->dealer_id) {
                $invSoftDelete = Inquiry::whereNull('dealer_id')->get();
            } else {
                $invSoftDelete = Inquiry::where('dealer_id', $this->authUser->dealer_id)->get();
            }
            $invSoftDelete = Inquiry::get();
            $invSoftDelete->each->delete();
            $path =  public_path('storage'. DIRECTORY_SEPARATOR .UploadStatus::FOLDER_INQUIRIES . DIRECTORY_SEPARATOR . $this->modelUploaded->filename);
        }
        /** leads **/
        if (FileFolder::FOLDER_LEADS == $this->folderName) {
            $leadsSoftDelete = Leads::get();
            $leadsSoftDelete->each->delete();
            $path =  public_path( 'storage'. DIRECTORY_SEPARATOR .UploadStatus::FOLDER_LEADS . DIRECTORY_SEPARATOR . $this->modelUploaded->filename);
        }
        /** test drive **/
        if (UploadStatus::FOLDER_TEST_DRIVE == $this->folderName) {
            $testDriveSoftDelete = TestDrive::get();
            $testDriveSoftDelete->each->delete();
            $path =  public_path('storage' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_TEST_DRIVE . DIRECTORY_SEPARATOR . $this->modelUploaded->filename);
        }

        /** test drive unit**/
        if (UploadStatus::FOLDER_TEST_DRIVE_UNIT == $this->folderName) {
            $testDriveUnitSoftDelete = TestDriveUnit::get();
            $testDriveUnitSoftDelete->each->delete();
            $path =  public_path('storage' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_TEST_DRIVE_UNIT . DIRECTORY_SEPARATOR . $this->modelUploaded->filename);
        }

        /** sales consultant **/
        if (UploadStatus::FOLDER_SALES_CONSULTANT == $this->folderName) {
            $consultants = User::whereHas('userRoles.role', function (Builder $query) {
                $query->where('slug', 'sales_consultant');
            })->get();
            $consultants->each->delete();
            $path =  public_path(UploadStatus::FOLDER_SALES_CONSULTANT . DIRECTORY_SEPARATOR . $this->modelUploaded->filename);
        }

        $reader = ReaderEntityFactory::createXLSXReader($path);
        // $reader->setShouldFormatDates(true);
        $reader->open($path);

        DB::transaction(function () use ($reader) {
            foreach ($reader->getSheetIterator() as  $sheet) {
                foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                    $value = $row->toArray();

                    if ($rowIndex === 1) {
                        continue;
                    }
                    /** inventory **/
                    if ($this->folderName === UploadStatus::FOLDER_INVENTORY) {
                        $dealer  = DB::table('dealers')->where('code', $value[6])->first();
                        $color   = DB::table('colors')->where('code', $value[5])->first();
                        $variant = DB::table('variants')->where('code', $value[0])->first();

                        Inventory::insert(
                            [
                                'dealer_id'             => $dealer ? $dealer->id : null,
                                'dealer_code'           => $dealer ? $dealer->code : null,
                                'dealer_name'           => $dealer ? $dealer->name : null,
                                'model_name'            => $value[1],
                                'model_year'            => $value[3],
                                'color_name'            => $color->name,
                                'color_code'            => $color->code,
                                'color_id'              => $color->id,
                                'variant_id'            => $variant ? $variant->id : null,
                                'variant_name'          =>  $variant ? $variant->name : null,
                                'variant_code'          => $variant ? $variant->code : null,
                                'created_by_user_id'   => $this->authUser->id,
                            ]
                        );
                    }

                    /** inquiries **/
                    if ($this->folderName === UploadStatus::FOLDER_INQUIRIES) {
                        $dealer  = DB::table('dealers')->where('code', $value[12])->first();
                        $variant = DB::table('variants')->where('code', $value[14])->first();

                        $bdate_unix = ($value[3] - 25569) * 86400;
                        $birthday = gmdate("Y-m-d", $bdate_unix);
                        $inquiry_unix = (!$this->authUser->dealer_id ? $value[16] : $value[15] - 25569) * 86400;
                        $inquiry_date = gmdate("Y-m-d", $inquiry_unix);

                        Inquiry::insert([
                            'title'                         => $value[0],
                            'first_name'                    => $value[1],
                            'last_name'                     => $value[2],
                            'birthdate'                     => $birthday,
                            'province'                      => $value[4],
                            'municipality'                  => $value[5],
                            'zipcode'                       => $value[6],
                            'barangay'                      => $value[7],
                            'street'                        => $value[8],
                            'mobile'                        => $value[9],
                            'preferred_communication'       => $value[10],
                            'email'                         => $value[11],
                            'dealer_id'                     => $dealer ? $dealer->id : null,
                            'dealer_code'                   => $dealer ? $dealer->code : null,
                            'model_name'                    => $dealer ? $value[13] : $value[12],
                            'variant_code'                  => $variant ? $variant->code : $value[13],
                            'variant_id'                    => $variant ? $variant->id : null,
                            'color_name'                    =>  $dealer ? $value[15] : $value[14],
                            'inquiry_date'                  => $inquiry_date,
                            'created_by_user_id'           => $this->authUser->id,
                        ]);
                    }

                    /** leads **/
                    if ($this->folderName === UploadStatus::FOLDER_LEADS) {

                        $dealer  = DB::table('dealers')->where('code', $value[5])->first();
                        $variant = DB::table('variants')->where('code', $value[7])->first();


                        Leads::insert(
                            [
                                'dealer_id'             => $dealer ? $dealer->id : null,
                                'dealer_code'           => $dealer ? $dealer->code : null,
                                'model_name'            => $value[6],
                                'first_name'            => $value[1],
                                'last_name'             => $value[2],
                                'mobile'                => $value[3],
                                'email'                 => $value[4],
                                'variant_id'            => $variant ? $variant->id : null,
                                'variant_name'          => $variant ? $variant->name : null,
                                'uploaded_at'           => Carbon::now(),
                                'accepted_at'           => Carbon::now(),
                                'status'                => UploadStatus::STAT_PENDING,
                                'created_by_user_id'    => $this->authUser->id,
                            ]
                        );
                    }

                    /** test drive */
                    if ($this->folderName === UploadStatus::FOLDER_TEST_DRIVE) {

                        $dealer_code = $this->authUser->dealer_id ? $value[13] : $value[12];
                        $variant_code =  $this->authUser->dealer_id ? $value[15] : $value[14];


                        $dealer  = DB::table('dealers')->where('code', $dealer_code)->first();
                        $variant = DB::table('variants')->where('code', $variant_code)->first();
                        $bdate_unix = ($value[3] - 25569) * 86400;
                        $birthday = gmdate("Y-m-d", $bdate_unix);

                        $testDate_unix = ($this->authUser->dealer_id ? $value[15] : $value[16] - 25569) * 86400;
                        $testDate = gmdate("Y-m-d", $testDate_unix);

                        TestDrive::insert(
                            [
                                'title'                 => $value[0],
                                'first_name'            => $value[1],
                                'last_name'             => $value[2],
                                'birthdate'             => $birthday,
                                'province'              => $value[4],
                                'municipality'          => $value[5],
                                'barangay'              => $value[6],
                                'street'                => $value[7],
                                'zipcode'               => $value[8],
                                'mobile'                => $value[9],
                                'preferred_communication' => $value[10],
                                'email'                   => $value[11],
                                'dealer_id'             => $dealer ? $dealer->id : null,
                                'dealer_code'           => $dealer ? $dealer->code : null,
                                'model_name'            => $this->authUser->dealer_id ? $value[12] : $value[13],
                                'variant_id'            => $variant ? $variant->id : null,
                                'variant_name'          => $variant ? $variant->name : null,
                                'color_name'            =>  $this->authUser->dealer_id ? $value[14] : $value[15],
                                'status'                => UploadStatus::STAT_PENDING,
                                'test_drive_date'       => $testDate,
                                'created_by_user_id'    => $this->authUser->id,
                            ]
                        );
                    }

                    /**  test drive unit **/
                    if ($this->folderName === UploadStatus::FOLDER_TEST_DRIVE_UNIT) {

                        $dealer  = DB::table('dealers')->where('code', $value[4])->first();
                        TestDriveUnit::insert(
                            [
                                'dealer_id'             => $dealer ? $dealer->id : null,
                                'dealer_code'           => $dealer ? $dealer->code : null,
                                'model_name'            => $value[0],
                                'variant_name'          => $value[1],
                                'model_year'            => $value[2],
                                'color_name'            => $value[3],
                                'quantity'              => $value[5],
                                'created_by_user_id'    => $this->authUser->id,
                            ]
                        );
                    }

                    /** sales consultant **/
                    if ($this->folderName === UploadStatus::FOLDER_SALES_CONSULTANT) {

                        $role = Role::where('slug', 'sales_consultant')->firstOrFail();
                        $user = User::updateOrCreate(
                            [
                                'email'            => $value[2],
                            ],
                            [
                                'first_name'       => $value[0],
                                'last_name'        => $value[1],
                                'email'            => $value[2],
                                'crm_id'          => $value[3]
                            ]
                        );

                        UserRole::Create(
                            [
                                'user_id' => $user->id,
                                'role_id' => $role->id
                            ]
                        );
                    }

                    $this->modelUploaded->update([
                        'status' => UploadStatus::STAT_COMPLETED,
                        'completed_at' => Carbon::now()
                    ]);
                }
            }
            Notifications::create([
                'message' => 'successfully added ' . $this->folderName,
                'opened' => false
            ]);
            $reader->close();
        });
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {

        /** inventory **/
        if (UploadStatus::FOLDER_INVENTORY === $this->folderName) {
            $this->modelUploaded->update([
                'status' => UploadStatus::STAT_FAILED,
                'completed_at' => Carbon::now()
            ]);
            Inventory::withTrashed()->restore();
        }

        /** inquiries **/
        if (UploadStatus::FOLDER_INQUIRIES === $this->folderName) {
            $this->modelUploaded->update([
                'status' => UploadStatus::STAT_FAILED,
                'completed_at' => Carbon::now()
            ]);
            Inquiry::withTrashed()->restore();
        }

        /** leads **/
        if (UploadStatus::FOLDER_LEADS === $this->folderName) {
            $this->modelUploaded->update([
                'status' => UploadStatus::STAT_FAILED,
                'completed_at' => Carbon::now()
            ]);
            Leads::withTrashed()->restore();
        }

        /** test drive **/
        if (UploadStatus::FOLDER_TEST_DRIVE === $this->folderName) {
            $this->modelUploaded->update([
                'status' => UploadStatus::STAT_FAILED,
                'completed_at' => Carbon::now()
            ]);
            TestDrive::withTrashed()->restore();
        }

        /** test drive unit**/
        if (UploadStatus::FOLDER_TEST_DRIVE_UNIT === $this->folderName) {
            $this->modelUploaded->update([
                'status' => UploadStatus::STAT_FAILED,
                'completed_at' => Carbon::now()
            ]);
            TestDriveUnit::withTrashed()->restore();
        }

        /** sales consultant **/
        if (UploadStatus::FOLDER_SALES_CONSULTANT === $this->folderName) {
            $this->modelUploaded->update([
                'status' => UploadStatus::STAT_FAILED,
                'completed_at' => Carbon::now()
            ]);

            //TODO: Add more condition to restore users attached on the dealer
            User::withTrashed()->restore();
        }

        Notifications::create([
            'message' => 'failed to insert ' . $this->folderName,
            'opened' => false
        ]);
    }
}
