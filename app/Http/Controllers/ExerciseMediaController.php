<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExerciseMediaController extends Controller
{
    public function __invoke(Exercise $exercise): BinaryFileResponse
    {
        abort_unless($exercise->demo_source === 'upload' && filled($exercise->demo_path), 404);

        $mediaDirectory = realpath(public_path('fitapp/media/exercises'));
        $mediaPath = realpath(public_path($exercise->demo_path));

        abort_unless(
            $mediaDirectory
                && $mediaPath
                && str_starts_with($mediaPath, $mediaDirectory.DIRECTORY_SEPARATOR)
                && is_file($mediaPath),
            404
        );

        return response()->file($mediaPath, [
            'Content-Type' => File::mimeType($mediaPath) ?: 'application/octet-stream',
            'Cache-Control' => 'private, max-age=86400',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
