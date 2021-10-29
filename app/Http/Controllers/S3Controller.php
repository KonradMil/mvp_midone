<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use League\Flysystem\FileNotFoundException;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 *
 */
class S3Controller extends Controller
{
    /**
     * @param Request $request
     * @param $path
     * @return StreamedResponse
     * @throws FileNotFoundException
     */
    public function reRoute(Request $request, $path): StreamedResponse
    {

        if (Storage::disk('s3')->exists($path)) {

        } else {
            if (strpos($path, 'workshop') !== false) {
                $path = 'workshop/' . $path;
            } elseif ((strpos($path, '_images') !== false) || (strpos($path, 'screenshots') !== false) || (strpos($path, 'models') !== false)) {
                $path = $path;
            } else {
                $path = 'unity/' . $path;
            }
        }

        $getMimeType = Storage::disk('s3')->getMimetype($path);

        $headers = [
            'Content-Disposition' => sprintf('attachment; filename="%s"', array_reverse(explode('/', $path))[0])
        ];
//        Log::error($path);
        if ((strpos($path, 'unityweb') !== false || strpos($path, 'wasm') !== false || strpos($path, '.br') !== false) && (strpos($path, 'loader') === false)) {
            $getMimeType = 'application/wasm';
            $headers['Content-Encoding'] = 'br';
        }
        if (strpos($path, 'framework') !== false) {
            $getMimeType = 'application/javascript';
            $headers['Content-Encoding'] = 'br';
        }


        $headers['Content-type'] = $getMimeType;

        $fs = Storage::disk('s3')->getDriver();
        $stream = $fs->readStream($path);
        Log::error($headers);
        return response()->stream(
            function () use ($stream) {
                fpassthru($stream);
            },
            200,
            $headers);
    }

    /**
     * @param Request $request
     * @param $path
     * @return StreamedResponse
     * @throws FileNotFoundException
     */
    public function reRoutes(Request $request, $path): StreamedResponse
    {

        if (Storage::disk('s3')->exists($path)) {

        } else {
            $path = 'models/' . $path;
        }

        $getMimeType = Storage::disk('s3')->getMimetype($path);

        $headers = [
            'Content-Disposition' => sprintf('attachment; filename="%s"', array_reverse(explode('/', $path))[0]),
        ];
        Log::error($path);
        if (strpos($path, 'unityweb') !== false || strpos($path, 'wasm') !== false || strpos($path, '.br') !== false) {
            $getMimeType = 'application/wasm';
            $headers['Content-Encoding'] = 'br';
        }
        $headers['Content-type'] = $getMimeType;

        $fs = Storage::disk('s3')->getDriver();
        $stream = $fs->readStream($path);
        Log::error($headers);
        return response()->stream(
            function () use ($stream) {
                fpassthru($stream);
            },
            200,
            $headers);
    }

    /**
     * @param Request $request
     */
    public function txtFile(Request $request)
    {

//        $myfile = fopen("mateusz.txt", "w") or die("Unable to open file!");
        $myfile = File::put('mateusz.txt', $request->file_string);
        Storage::disk('s3')->putFileAs('uploads', 'mateusz.txt', 'mateusz.txt');
    }

    /**
     * @param $screenshot
     * @return array
     */
    public static function processScreenshot($screenshot): array
    {
        $content = base64_decode($screenshot);
        $name = uniqid('ss_') . '.jpg';
        $path = public_path('screenshots/' . $name);
        $image_normal = Image::make($content)->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image_normal->save(public_path('images/' . $name));

        Storage::disk('s3')->putFileAs('screenshots/', new \Illuminate\Http\File(public_path('images/' . $name)), $name);

        return ['absolute_path' => $path, 'relative' => ('s3/screenshots/' . $name)];
    }

    public function save8KScreenshot(Request $request)
    {
        return response()->json(self::processScreenshot($request->get('data')));
    }
}
