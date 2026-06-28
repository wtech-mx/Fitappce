<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ProgressPhoto;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ClientProgressPhotoController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $nextAppointment = $this->nextAppointment($user->id);
        $uploadWindow = $this->uploadWindow($nextAppointment);
        $photos = $user->progressPhotos()
            ->with('appointment')
            ->latest()
            ->get();

        return view('fitapp.fotos-progreso', compact('user', 'nextAppointment', 'uploadWindow', 'photos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $nextAppointment = $this->nextAppointment($user->id);
        $uploadWindow = $this->uploadWindow($nextAppointment);

        if (! $uploadWindow['is_open']) {
            return back()->withErrors([
                'photos' => $uploadWindow['reason'] ?: 'La carga de fotos se abre una semana antes de tu cita.',
            ]);
        }

        $validated = $request->validate([
            'photos' => ['required', 'array'],
            'photos.*' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:51200'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'photos.*.mimes' => 'Solo se aceptan JPG, PNG o WebP. Si tu iPhone guarda HEIC, cambia la camara a formato mas compatible o envia una version JPG.',
            'photos.*.max' => 'Cada foto puede pesar hasta 50 MB antes de optimizarse.',
        ]);

        foreach ($request->file('photos', []) as $photo) {
            $stored = $this->storeOptimizedPhoto($photo, $user->id);

            ProgressPhoto::create([
                'user_id' => $user->id,
                'appointment_id' => $nextAppointment?->id,
                'image_path' => $stored['path'],
                'original_name' => $photo->getClientOriginalName(),
                'original_size' => $photo->getSize(),
                'optimized_size' => $stored['size'],
                'width' => $stored['width'],
                'height' => $stored['height'],
                'mime_type' => 'image/jpeg',
                'notes' => $validated['notes'] ?? null,
            ]);
        }

        return back()->with('status', 'Fotos subidas y optimizadas correctamente.');
    }

    private function nextAppointment(int $userId): ?Appointment
    {
        return Appointment::query()
            ->where('user_id', $userId)
            ->where('kind', 'appointment')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->first();
    }

    /**
     * @return array{is_open: bool, starts_at: ?Carbon, ends_at: ?Carbon, reason: ?string}
     */
    private function uploadWindow(?Appointment $appointment): array
    {
        if (! $appointment) {
            return [
                'is_open' => false,
                'starts_at' => null,
                'ends_at' => null,
                'reason' => 'Aun no tienes una cita programada para enviar fotos de avance.',
            ];
        }

        $startsAt = $appointment->starts_at->copy()->subDays(7)->startOfDay();
        $endsAt = $appointment->starts_at->copy()->endOfDay();
        $now = now();

        return [
            'is_open' => $now->greaterThanOrEqualTo($startsAt) && $now->lessThanOrEqualTo($endsAt),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'reason' => $now->lt($startsAt)
                ? 'La carga se activara el '.$startsAt->format('d/m/Y').'.'
                : ($now->gt($endsAt) ? 'La ventana para esta cita ya termino.' : null),
        ];
    }

    /**
     * @return array{path: string, size: int, width: int, height: int}
     */
    private function storeOptimizedPhoto(UploadedFile $file, int $userId): array
    {
        $sourcePath = $file->getRealPath();
        $imageInfo = getimagesize($sourcePath);

        if (! $imageInfo) {
            throw ValidationException::withMessages(['photos' => 'No se pudo leer una de las imagenes.']);
        }

        [$width, $height] = $imageInfo;
        $mime = $imageInfo['mime'] ?? '';
        $source = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($sourcePath),
            'image/png' => imagecreatefrompng($sourcePath),
            'image/webp' => imagecreatefromwebp($sourcePath),
            default => false,
        };

        if (! $source) {
            throw ValidationException::withMessages(['photos' => 'Formato no compatible para optimizar. Usa JPG, PNG o WebP.']);
        }

        if ($mime === 'image/jpeg') {
            $source = $this->applyJpegOrientation($source, $sourcePath);
            $width = imagesx($source);
            $height = imagesy($source);
        }

        $maxSide = 1600;
        $scale = min(1, $maxSide / max($width, $height));
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));
        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        $white = imagecolorallocate($target, 255, 255, 255);
        imagefilledrectangle($target, 0, 0, $targetWidth, $targetHeight, $white);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $directory = public_path('fitapp/media/progress-photos/user_'.$userId);
        File::ensureDirectoryExists($directory);

        $filename = uniqid('progress_', true).'.jpg';
        $absolutePath = $directory.DIRECTORY_SEPARATOR.$filename;

        imagejpeg($target, $absolutePath, 78);
        imagedestroy($source);
        imagedestroy($target);

        return [
            'path' => 'fitapp/media/progress-photos/user_'.$userId.'/'.$filename,
            'size' => filesize($absolutePath) ?: 0,
            'width' => $targetWidth,
            'height' => $targetHeight,
        ];
    }

    private function applyJpegOrientation(\GdImage $image, string $path): \GdImage
    {
        $exif = @exif_read_data($path);
        $orientation = (int) ($exif['Orientation'] ?? 1);

        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => $image,
        };

        return $rotated ?: $image;
    }
}
