<?php

namespace App\Trait;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

trait UploadStorage
{
    /**
     * Faz upload de arquivo de acordo com disco colocado
     * Geração de thumbmail e modificação de tamanhos
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string $newName
     * @param array $resize
     * @param boolean $thumbmail
     * @param string $disk
     * @return string
     * Retorna do arquivo gerado
     */
    public function uploadStorage(UploadedFile $file, string $path, $newName = '', array $resize = [], bool $thumbmail = false, string $disk = 'local'): string
    {
        if ($file instanceof UploadedFile && $file->isValid()) {
            $filename = uniqid($newName . '_') . '.' . $file->extension();
            $path_thumbmail = $thumbmail ? 'thumbmail/' : ''; //caso thumbmail
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
            if ($thumbmail && !Storage::exists($path . $path_thumbmail)) {
                Storage::makeDirectory($path . $path_thumbmail);
            }
            if (!empty($resize)) { //caso redimensionamento especificado
                $image = Image::read($file->getRealPath());
                $image->resize($resize[0], $resize[1]);
                $image->save(storage_path('app/' . $path . $path_thumbmail . $filename));
            }
            if (
                empty($resize) || ($thumbmail && !empty($resize)) //caso tamanho não definido ou thumbail gerada acima
            ) {
                $file->storeAs($path, $filename, $disk);
            }
            return $filename;
        } else {
            throw new \Exception("Invalid upload file. Expected UploadedFile, but received: '" . get_debug_type($file) . "'");
        }
    }
}
