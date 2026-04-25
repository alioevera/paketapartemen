<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Tower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PenghuniController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('PenghuniPage', [
            'penghuni' => Penghuni::with('tower')
                ->orderBy('penghuni_id', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'penghuni_id' => $item->penghuni_id,
                        'tower_id' => $item->tower_id,
                        'tower_name' => $item->tower?->tower_name,
                        'unit' => $item->unit,
                        'nama_penghuni' => $item->nama_penghuni,
                        'nomor_telepon' => $item->nomor_telepon,
                        'email' => $item->email,
                    ];
                }),
            'towers' => Tower::orderBy('tower_name', 'asc')->get(['tower_id', 'tower_name']),
            'authUser' => [
                'user_nik' => auth()->user()?->user_nik,
                'user_name' => auth()->user()?->user_name,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tower_id' => ['required', 'exists:tower,tower_id'],
            'unit' => ['required', 'string', 'max:10'],
            'nama_penghuni' => ['required', 'string', 'max:100'],
            'nomor_telepon' => ['required', 'string', 'max:20', 'unique:penghuni,nomor_telepon'],
            'email' => ['required', 'email', 'max:100', 'unique:penghuni,email'],
        ]);

        $existsUnit = Penghuni::where('tower_id', $validated['tower_id'])
            ->where('unit', $validated['unit'])
            ->exists();

        if ($existsUnit) {
            return back()->withErrors([
                'unit' => 'Unit pada tower tersebut sudah terdaftar.',
            ])->withInput();
        }

        Penghuni::create($validated);

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $penghuni = Penghuni::findOrFail($id);

        $validated = $request->validate([
            'tower_id' => ['required', 'exists:tower,tower_id'],
            'unit' => ['required', 'string', 'max:10'],
            'nama_penghuni' => ['required', 'string', 'max:100'],
            'nomor_telepon' => [
                'required',
                'string',
                'max:20',
                Rule::unique('penghuni', 'nomor_telepon')->ignore($penghuni->penghuni_id, 'penghuni_id'),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('penghuni', 'email')->ignore($penghuni->penghuni_id, 'penghuni_id'),
            ],
        ]);

        $existsUnit = Penghuni::where('tower_id', $validated['tower_id'])
            ->where('unit', $validated['unit'])
            ->where('penghuni_id', '!=', $penghuni->penghuni_id)
            ->exists();

        if ($existsUnit) {
            return back()->withErrors([
                'unit' => 'Unit pada tower tersebut sudah terdaftar.',
            ])->withInput();
        }

        $penghuni->update($validated);

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil diupdate.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $penghuni = Penghuni::findOrFail($id);
        $penghuni->delete();

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil dihapus.');
    }
}