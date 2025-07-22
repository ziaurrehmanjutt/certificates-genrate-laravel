<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Intervention\Image\Laravel\Facades\Image;

// use Intervention\Image;
use Intervention\Image\Laravel\Facades\Image;
// use Intervention\Image;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Decoders\DataUriImageDecoder;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Intervention\Image\Decoders\FilePathImageDecoder;

class CertificatePreviewController extends Controller
{


    public function form()
    {
        return view('certificate.preview');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'roll_no' => 'required|string',
        ]);

        $manager = new ImageManager(new Driver());

        $templatePath = public_path('templates/2.png');
        $outputPath = public_path('certificates/output.png');
        // $fontPath = public_path('fonts/Roboto/static/Roboto-Bold.ttf');
        $fontPath = public_path('fonts/awesome/Awesome.ttf');

        $img = $manager->read($templatePath);

        $img->text('Mr XYZ', 550, 660, function ($font) use ($fontPath) {
            $font->filename($fontPath);
            $font->size(50);
            $font->color('#000000');
        });

        $img->save($outputPath);

        return response()->download($outputPath);
    }
}
