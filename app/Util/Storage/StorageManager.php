<?php
namespace App\Util\Storage;

use App\Enums\StoragePath;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class StorageManager
{
    /**
     * Store an uploaded file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param StoragePath $path
     * @param string|null $customName
     * @return string Stored file path
     */
    public function store(UploadedFile $file, StoragePath $path, ?string $customName = null): string
    {
        $this->validateFile($file);

        $fileName = $this->generateFileName($file, $customName);
        $fullPath = $path->getFullPath();

        return $file->storeAs(
            $fullPath,
            $fileName,
            options: 'public'
        );
    }

    /**
     * Store multiple uploaded files
     *
     * @param array<UploadedFile> $files
     * @param StoragePath $path
     * @return array Stored file paths
     */
    public function storeMultiple(array $files, StoragePath $path): array
    {
        $storedPaths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $storedPaths[] = $this->store($file, $path);
            }
        }

        return $storedPaths;
    }

    /**
     * Delete a stored file
     *
     * @param string $filePath
     * @param StoragePath $path
     * @return bool
     */
    public function delete(string $filePath, StoragePath $path): bool
    {
        if (!$this->exists($filePath, $path)) {
            return false;
        }

        return Storage::disk('public')->delete($filePath);
    }

    /**
     * Delete multiple stored files
     *
     * @param array<string> $filePaths
     * @param StoragePath $path
     * @return bool
     */
    public function deleteMultiple(array $filePaths, StoragePath $path): bool
    {
        return Storage::disk('public')->delete($filePaths);
    }

    /**
     * Check if a file exists
     *
     * @param string $filePath
     * @param StoragePath $path
     * @return bool
     */
    public function exists(string $filePath, StoragePath $path): bool
    {
        return Storage::disk('public')->exists($filePath);
    }

    /**
     * Get the URL for a stored file
     *
     * @param string $filePath
     * @param string $filePath
     * @return string
     */
    public static function getUrl(string $filePath): string
    {
        $filePath = Str::startsWith($filePath, '/') ? $filePath : '/' . $filePath;

        return config('filesystems.disks.public.url') . $filePath;
    }

    /**
     * Move a file to a new location
     *
     * @param string $oldPath
     * @param StoragePath $oldLocation
     * @param StoragePath $newLocation
     * @return string New file path
     */
    public function move(string $oldPath, StoragePath $oldLocation, StoragePath $newLocation): string
    {
        if (!$this->exists($oldPath, $oldLocation)) {
            throw new InvalidArgumentException("Source file does not exist");
        }

        $fileName = basename($oldPath);
        $newPath = $newLocation->getFullPath() . '/' . $fileName;

        Storage::disk('public')
            ->move($oldPath, $newPath);

        return $newPath;
    }

    /**
     * Generate a unique filename
     *
     * @param UploadedFile $file
     * @param string|null $customName
     * @return string
     */
    private function generateFileName(UploadedFile $file, ?string $customName): string
    {
        if ($customName) {
            return Str::slug($customName) . '.' . $file->getClientOriginalExtension();
        }

        return Str::random(40) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Validate the uploaded file
     *
     * @param UploadedFile $file
     * @return void
     */
    private function validateFile(UploadedFile $file): void
    {
        if (!$file->isValid()) {
            throw new InvalidArgumentException('Invalid file upload');
        }
    }
}
