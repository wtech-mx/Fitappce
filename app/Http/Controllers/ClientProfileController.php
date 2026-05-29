<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientProfileController extends Controller
{
    private const BODY_VISUAL_TYPES = [
        'avatar' => [
            'label' => 'Avatar corporal',
            'description' => 'Persona animada segun genero, cintura y composicion.',
        ],
        'scan' => [
            'label' => 'Mapa con globos',
            'description' => 'Estilo limpio con mediciones marcadas.',
        ],
        'realistic' => [
            'label' => 'Anatomia fitness',
            'description' => 'Vista tipo musculos para zonas de enfoque.',
        ],
        'silhouette' => [
            'label' => 'Silueta comparativa',
            'description' => 'Vista sobria para notar volumen y forma.',
        ],
        'athletic' => [
            'label' => 'Transformacion fitness',
            'description' => 'Ideal para cambios de grasa a definicion muscular.',
        ],
    ];

    public function show(Request $request): View
    {
        return view('fitapp.perfil', [
            'user' => $request->user(),
            'bodyVisualTypes' => self::BODY_VISUAL_TYPES,
        ]);
    }

    public function updateVisual(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'body_visual_type' => ['required', 'string', 'in:'.implode(',', array_keys(self::BODY_VISUAL_TYPES))],
        ]);

        $request->user()->update($data);

        return back()->with('status', 'Visual de progreso actualizado.');
    }
}
