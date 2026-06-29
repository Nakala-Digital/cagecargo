<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HasFileUpload
{
    public function uploadFile(Request $request, string $fieldName, string $directory, ?string $existingFile = null): ?string
    {
        if (!$request->hasFile($fieldName)) {
            return $existingFile;
        }

        if ($existingFile) {
            Storage::disk('public')->delete($existingFile);
        }

        return $request->file($fieldName)->store($directory, 'public');
    }
}
