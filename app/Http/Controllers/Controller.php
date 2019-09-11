<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function base64ToImage($base64_string, $output_file) {
        //$file = fopen($output_file, "w");
        //$file = fopen('public/f.png', "w");

        $data = explode(',', $base64_string);

        //fwrite($file, base64_decode($data[1]));
        //fclose($file);
        $data = base64_decode($data[1]);

        Storage::put($output_file, $data);


        return storage_path($output_file);
    }
}
