<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetFolder;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class AssetsService
{
    /**
     * Update assets
     *
     * @param \App\Models\Asset $asset
     * @param array $data
     * @return \App\Models\Asset
     */
    public function update($asset, $data)
    {
        if (array_key_exists("file", $data)) {
            $file = $data['file'];

            $file = $asset['file'];

            $get = Storage::get("public/assets/{$file}");

            if (!$get) {
                throw new AppException("Failed to upload {$file}. File not found.");
            }

            $properties = $this->getFileProperties($file);

            if (!$this->validateStorageSize($properties->size)) {
                throw new AppException("Failed to upload {$file}. Storage limit is reached.");
            }

            $data['file'] = $properties->file;
            $data['extension'] = $properties->extension;
            $data['size'] = $properties->size;
            $data['mime_type'] = $properties->mime_type;
            $data['width'] = $properties->width;
            $data['height'] = $properties->height;
        } else {
            unset($data['file']);
        }

        //Clean dealers
        $data['dealers'] = json_decode($data['dealers']);

        $data['description'] = ($data['description']) ? $data['description'] : "";

        //Update data
        $asset->update(array_merge($data, [
            'updated_by_user_id' => auth()->user()->id
        ]));

        return $asset;
    }

    /**
     * Stores assets
     *
     * @param array $data
     * @return \App\Models\Asset
     */
    public function store($data)
    {
        if (!$data['files']) {
            throw new AppException("Please upload files.");
        }

        DB::beginTransaction();

        try {
            $created = [];

            foreach ($data['files'] as $key => $asset) {

                $file = $asset['file'];

                $get = Storage::get("public/assets/{$file}");

                if (!$get) {
                    throw new AppException("Failed to upload {$file}. File not found.");
                }

                $properties = $this->getFileProperties($file);

                if (!$this->validateStorageSize($properties->size)) {
                    throw new AppException("Failed to upload {$file}. Storage limit is reached.");
                }

                $item = Asset::create([
                    'category_id' => $data['category_id'],
                    'folder_id' =>  $data['folder_id'],
                    'name' => array_key_exists("name", $asset) ? $asset['name'] : '',
                    'file' => $properties->file,
                    'description' => array_key_exists("description", $asset) ? $asset['description'] : '',
                    'extension' => $properties->extension,
                    'size' => $properties->size,
                    'mime_type' => $properties->mime_type,
                    'height' => $properties->height,
                    'width' => $properties->width,
                    'published_at' => Carbon::now()->toDateTimeString(),
                    'expired_at' => array_key_exists("name", $asset) ? $asset['expired_at'] : '',
                    'status' => true,
                    'precedence' => $key,
                    'dealers' => json_decode($data['dealers']),
                    'created_by_user_id' => auth()->user()->id
                ]);


                array_push($created, $item->id);
            }

            DB::commit();

            return Asset::whereIn('id', $created)->get();
        } catch (AppException $th) {
            DB::rollback();
            throw new AppException($th->getMessage());
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Get file properties
     *
     * @param mixed $file
     * @param array $data
     * @return object
     */
    public function getFileProperties($file)
    {
        $get = Storage::path("public/assets/{$file}");

        $dimension = getimagesize($get);

        $size = Storage::size("public/assets/{$file}");

        $mime = Storage::mimeType("public/assets/{$file}");

        $extension = pathinfo(storage_path("public/assets/{$file}"), PATHINFO_EXTENSION);

        return (object) [
            'file' =>  $file,
            'extension' => $extension,
            'size' =>  $size,
            'mime_type' => $mime,
            'width' => ($dimension) ? $dimension[0] : null,
            'height' => ($dimension) ? $dimension[1] : null,
        ];
    }

    /**
     * Get storage usage
     *
     * @param mixed $file
     * @param array $data
     * @return int
     */
    public function getStorageUsage()
    {
        $usage = DB::table('assets')->whereNull('deleted_at')->sum('size');

        return $usage;
    }

    /**
     * Get storage size
     *
     * @param mixed $file
     * @param array $data
     * @return int
     */
    public function getStorageSize()
    {
        $free = disk_free_space("/");

        $usage = $this->getStorageUsage();

        return ($free + $usage);
    }

    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return string
     */
    public function formatSize($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    /**
     * Validates file size in storage
     *
     * @param  integer $size
     * @return boolean
     */
    public function validateStorageSize($size)
    {
        $usage  = (int) $this->getStorageUsage();
        $available = (int) $this->getStorageSize();

        $current = (int) $size + $usage;

        return $current <= $available;
    }

    /**
     * Update branding guidelines
     *
     * @param \Illuminate\Http\UploadedFile  $file
     * @return mixed
     */
    public function updateBrandingGuidelines($file)
    {
        $upload = Storage::putFile("public/assets", $file, 'public');

        if (!$upload) {
            throw new AppException("Failed to upload {$file->getClientOriginalName()}.");
        }

        //Set settings
        (new SettingsService())->setValue('branding_guidelines', $file->hashName());

        return $file->hashName();
    }

    /**
     * Get preview image
     *
     * @param \App\Models\Asset $asset
     * @return mixed
     */
    public function getPreviewImageUrl($asset)
    {
        if (strpos($asset->mime_type, 'image') !== false) {
            return url("storage/assets/{$asset->file}");
        }

        switch ($asset->extension) {
            case 'mp4':
                return url("images/previews/mp4.jpg");
                break;
            case 'pdf':
                return url("images/previews/pdf.jpg");
                break;
            case 'doc':
            case 'docx':
                return url("images/previews/doc.jpg");
                break;
            case 'xls':
            case 'xlsx':
                return url("images/previews/excel.jpg");
                break;
            case 'ppt':
            case 'pptx':
                return url("images/previews/ppt.jpg");
                break;
            default:
                return url("images/previews/default.jpg");
                break;
        }
    }

    /**
     * Uplaod file in chunk
     *
     * @param \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function uploadChunkFile($request)
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveChunkedFile($save->getFile(), $request);
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return [
            "progress" => $handler->getPercentageDone(),
        ];
    }

    /**
     * Saves the file from chunk
     *
     * @param UploadedFile $file
     * @param \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function saveChunkedFile($file, $request)
    {
        $file_name = $file->hashName(); //$this->createFilename($file);

        // Get file mime type
        $mime_original = $file->getMimeType();
        $mime = str_replace('/', '-', $mime_original);

        $file_path = "public/assets";
        $final_path = storage_path("app/" . $file_path);

        // move the file name
        $file->move($final_path, $file_name);

        $url_base = 'storage/upload/assets/' . $file_name;

        return [
            'path' => $file_path,
            'name' => $file_name,
            'mime_type' => $mime
        ];
    }

    /**
     * Deletes assets by category
     *
     * @param App\Models\AssetCategory $category
     * @return mixed
     */
    public function deleteAssetByCategory($category)
    {
        $query = Asset::where('category_id', $category->id);

        //Get files
        $files = $query->pluck('file')->toArray();

        if (!$files) {
            return false;
        }

        //Append directory
        $files = substr_replace($files, 'public/assets/', 0, 0);

        //Delete files in storage
        Storage::delete($files);

        //Delete in DB
        $query->delete();

        return true;
    }

    /**
     * Deletes assets
     *
     * @param App\Models\Asset $asset
     * @return mixed
     */
    public function deleteAsset($asset)
    {
        //Delete files in storage
        Storage::delete("public/assets/{$asset->file}");

        //Delete in DB
        $asset->delete();

        return true;
    }

    /**
     * Deletes assets by folder
     *
     * @param App\Models\AssetFolder $folder
     * @return mixed
     */
    public function deleteAssetByFolder($folder)
    {
        $query = Asset::where('folder_id', $folder->id);

        //Get files
        $files = $query->pluck('file')->toArray();

        if (!$files) {
            return false;
        }

        //Append directory
        $files = substr_replace($files, 'public/assets/', 0, 0);

        //Delete files in storage
        Storage::delete($files);

        //Delete in DB
        $query->delete();

        return true;
    }

    /**
     * Deletes a folder and connected files by category
     *
     * @param App\Models\AssetCategory $category
     * @return mixed
     */
    public function deleteFolderByCategory($category)
    {
        //Delete folders
        AssetFolder::where('category_id', $category->id)->delete();

        //Delete assets 
        $this->deleteAssetByCategory($category);

        return true;
    }

    /**
     * Deletes a folder and connected files
     *
     * @param App\Models\AssetFolder $folder
     * @return mixed
     */
    public function deleteFolder($folder)
    {
        //Delete folders
        AssetFolder::where('id', $folder->id)->delete();

        //Delete assets 
        $this->deleteAssetByFolder($folder);

        return true;
    }

    /**
     * Deletes a category and connected files
     *
     * @param App\Models\AssetCategory $category
     * @return mixed
     */
    public function deleteCategory($category)
    {
        $category->delete();

        $this->deleteFolderByCategory($category);

        return true;
    }

    /**
     * Updates a category and connected files
     *
     * @param App\Models\AssetCategory $category
     * @param array $data
     * @return mixed
     */
    public function updateCategory($category, $data)
    {
        //Update category
        $category->update(array_merge($data, [
            'updated_by_user_id' => auth()->user()->id
        ]));

        //Update folders
        AssetFolder::where('category_id', $category->id)->update([
            'status' => $data['status']
        ]);

        //Update folders
        Asset::where('category_id', $category->id)->update([
            'status' => $data['status']
        ]);
    }

    /**
     * Updates a folder and connected files
     *
     * @param App\Models\AssetFolder $folder
     * @param array $data
     * @return mixed
     */
    public function updateFolder($folder, $data)
    {
        //Update folder
        $folder->update(array_merge($data, [
            'updated_by_user_id' => auth()->user()->id
        ]));

        //Update folders
        Asset::where('folder_id', $folder->id)->update([
            'status' => $data['status']
        ]);
    }
}
