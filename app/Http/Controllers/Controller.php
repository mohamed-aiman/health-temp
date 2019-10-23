<?php

namespace App\Http\Controllers;

use App\Framework\Controllers\Controller as FrameworkController;

use Response;
use File;
use Exception;

class Controller extends FrameworkController
{
	public function getImage($filePath)
    {
        try {
            $file = File::get($filePath);

            $type = File::mimeType($filePath);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
