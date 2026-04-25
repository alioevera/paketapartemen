<?php

namespace App\Http\Controllers;

use App\Models\Expedisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExpedisiController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('ExpedisiPage', [
            'expedisi' => Expedisi::orderBy('expedisi_id', 'asc')->get(),
            'authUser' => [
                'user_nik' => auth()->user()?->user_nik,
                'user_name' => auth()->user()?->user_name,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'expedisi_name' => ['required', 'string', 'max:255'],
        ]);

        Expedisi::create($validated);

        return redirect()->route('expedisi.index')
            ->with('success', 'Data expedisi berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'expedisi_name' => ['required', 'string', 'max:255'],
        ]);

        $expedisi = Expedisi::findOrFail($id);
        $expedisi->update($validated);

        return redirect()->route('expedisi.index')
            ->with('success', 'Data expedisi berhasil diupdate.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $expedisi = Expedisi::findOrFail($id);
        $expedisi->delete();

        return redirect()->route('expedisi.index')
            ->with('success', 'Data expedisi berhasil dihapus.');
    }
}