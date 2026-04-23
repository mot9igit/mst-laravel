<?php

namespace App\Services\Tools;

use App\Http\Requests\API\Files\UploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploaderService
{
    private $disk;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->disk = env('FILESYSTEM_DISK', 'public');
    }

    public function handle(array $data, UploadRequest $request): JsonResponse
    {
        $files = [];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if(is_array($file)) {
                foreach ($file as $f) {
                    $files[] = $f->storeAs(
                        $data['path'],
                        $f->getClientOriginalName(),
                        $this->disk
                    );
                }
            }else {
                $files[] = $file->storeAs(
                    $data['path'],
                    $file->getClientOriginalName(),
                    $this->disk
                );
            }
        }
        return response()->json([
            'message' => 'Успешно загружено',
            'files' => $files
        ], 201);
    }

    public function moveUploadFile(string $filename, string $path){
        if (Storage::disk($this->disk)->exists($filename)) {
            $newpath = $path.basename($filename);
            Storage::disk($this->disk)->move($filename, $newpath);
            return $newpath;
        }else{
            Log::error('Файл не найден: '.$filename);
            return null;
        }
    }

    public function upload(string $path, string $filename){

    }

    public function delete(string $path) : array
    {
        try {
            if (!Storage::disk($this->disk)->exists($path)) {
                return ['error' => "Папка на {$this->disk} не существует"];
            }
            Storage::disk($this->disk)->deleteDirectory($path);
            if (Storage::disk($this->disk)->exists($path)) {
                return ['error' => "Не удалось удалить папку на {$this->disk}"];
            }
            return ['message' => "Папка на {$this->disk} успешно удалена"];
        } catch (\Exception $e) {
            Log::error("Ошибка удаления папки на {$this->disk}: " . $e->getMessage());
            return ['error' => "Ошибка при удалении папки на {$this->disk}"];
        }
    }
}
