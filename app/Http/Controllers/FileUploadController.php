<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;

class FileUploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            // Subir archivo a Google Cloud Storage
            $storage = new StorageClient([
                'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE')
            ]);

            $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
            $object =$bucket->upload(
                fopen($file->getPathname(), 'r'),
                ['name' => $fileName]
            );
            $url = $object->signedUrl(new \DateTime('tomorrow'));

            // Aquí puedes guardar la URL en tu base de datos
            // Ejemplo:
            // TuModelo::create(['archivo_url' => $url]);

            return 'URL del archivo subido: ' . $url;
        }

        return 'No se ha seleccionado ningún archivo.';
    }
}
