<?php

namespace App\Http\Controllers;

use App\Models\Tower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TowerController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('TowerPage', [
            'towers' => Tower::orderBy('tower_id', 'asc')->get(),
            'authUser' => [
                'user_nik' => auth()->user()?->user_nik,
                'user_name' => auth()->user()?->user_name,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tower_name' => ['required', 'string', 'max:255'],
        ]);

        Tower::create($validated);

        return redirect()->route('tower.index')
            ->with('success', 'Data tower berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'tower_name' => ['required', 'string', 'max:255'],
        ]);

        $tower = Tower::findOrFail($id);
        $tower->update($validated);

        return redirect()->route('tower.index')
            ->with('success', 'Data tower berhasil diupdate.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $tower = Tower::findOrFail($id);
        $tower->delete();

        return redirect()->route('tower.index')
            ->with('success', 'Data tower berhasil dihapus.');
    }
}