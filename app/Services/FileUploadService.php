<?php

namespace App\Services;

use Illuminate\Http\Request;

trait FileUploadService
{
    public function uploadImage_(Request $request, $path)
    {
        try {
            $filename = null;
            if ($request->file('file')) {
                $file = $request->file('file');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path($path), $filename);
            }
            return [
                'error' => false,
                'filename' => $filename
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
