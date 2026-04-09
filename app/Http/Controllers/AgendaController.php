<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function create(): never
    {
        abort(404);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Agenda::query()->orderBy('tanggal')->orderBy('created_at');

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->string('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->string('date_to'));
        }

        if ($request->filled('limit')) {
            $query->limit((int) $request->integer('limit'));
        }

        return response()->json([
            'data' => $query->get()->map(fn (Agenda $agenda) => $this->transformAgenda($agenda)),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->validateAgenda($request);
        $payload['dibuat_oleh'] = auth()->user()?->username ?? $request->string('dibuat_oleh')->toString();

        $agenda = Agenda::create($payload);

        return response()->json([
            'message' => 'Agenda berhasil ditambahkan.',
            'data' => $this->transformAgenda($agenda->fresh()),
        ], 201);
    }

    public function show(Agenda $agenda): JsonResponse
    {
        return response()->json([
            'data' => $this->transformAgenda($agenda),
        ]);
    }

    public function edit(Agenda $agenda): never
    {
        abort(404);
    }

    public function update(Request $request, Agenda $agenda): JsonResponse
    {
        $payload = $this->validateAgenda($request);
        $payload['dibuat_oleh'] = auth()->user()?->username ?? $agenda->dibuat_oleh;

        $agenda->update($payload);

        return response()->json([
            'message' => 'Agenda berhasil diperbarui.',
            'data' => $this->transformAgenda($agenda->fresh()),
        ]);
    }

    public function destroy(Agenda $agenda): JsonResponse
    {
        $agenda->delete();

        return response()->json([
            'message' => 'Agenda berhasil dihapus.',
        ]);
    }

    private function validateAgenda(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'tanggal' => ['required', 'date'],
            'waktu_kegiatan' => ['nullable', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
        ]);
    }

    private function transformAgenda(Agenda $agenda): array
    {
        return [
            'id' => $agenda->id,
            'title' => $agenda->title,
            'tanggal' => optional($agenda->tanggal)->format('Y-m-d'),
            'tanggal_label' => optional($agenda->tanggal)->translatedFormat('d M Y'),
            'subtitle' => collect([$agenda->waktu_kegiatan, $agenda->lokasi])->filter()->implode(' | '),
            'waktu_kegiatan' => $agenda->waktu_kegiatan,
            'lokasi' => $agenda->lokasi,
            'deskripsi' => $agenda->deskripsi,
            'dibuat_oleh' => $agenda->dibuat_oleh,
            'created_at' => optional($agenda->created_at)->toISOString(),
            'updated_at' => optional($agenda->updated_at)->toISOString(),
        ];
    }
}
