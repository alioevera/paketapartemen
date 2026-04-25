<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use App\Models\Tower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ReceptionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('ReceptionPage', [
            'receptions' => Reception::with('tower')
                ->orderBy('user_name', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'user_nik' => $item->user_nik,
                        'user_name' => $item->user_name,
                        'username' => $item->username,
                        'role' => $item->role,
                        'tower_id' => $item->tower_id,
                        'tower_name' => $item->tower?->tower_name,
                        'created_at' => $item->created_at,
                    ];
                }),

            'towers' => Tower::orderBy('tower_name', 'asc')->get(['tower_id', 'tower_name']),

            'authUser' => [
                'user_nik' => auth()->user()?->user_nik,
                'user_name' => auth()->user()?->user_name,
                'role' => auth()->user()?->role,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat menambahkan reception.');
        }

        $validated = $request->validate([
            'user_nik' => ['required', 'string', 'max:16', 'unique:reception,user_nik'],
            'user_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:reception,username'],
            'password' => ['required', 'string', 'min:4'],
            'role' => ['required', Rule::in(['admin', 'receptionist'])],
            'tower_id' => ['nullable', 'exists:tower,tower_id'],
        ]);

        if ($validated['role'] === 'receptionist' && empty($validated['tower_id'])) {
            return back()->withErrors([
                'tower_id' => 'Tower wajib dipilih untuk receptionist.',
            ])->withInput();
        }

        if ($validated['role'] === 'admin') {
            $validated['tower_id'] = null;
        }

        Reception::create([
            'user_nik' => $validated['user_nik'],
            'user_name' => $validated['user_name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'tower_id' => $validated['tower_id'],
        ]);

        return redirect()->route('reception.index')
            ->with('success', 'Data reception berhasil ditambahkan.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengubah data reception.');
        }

        $reception = Reception::findOrFail($id);

        $validated = $request->validate([
            'user_nik' => [
                'required',
                'string',
                'max:16',
                Rule::unique('reception', 'user_nik')->ignore($reception->user_nik, 'user_nik'),
            ],
            'user_name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('reception', 'username')->ignore($reception->user_nik, 'user_nik'),
            ],
            'password' => ['nullable', 'string', 'min:4'],
            'role' => ['required', Rule::in(['admin', 'receptionist'])],
            'tower_id' => ['nullable', 'exists:tower,tower_id'],
        ]);

        if ($validated['role'] === 'receptionist' && empty($validated['tower_id'])) {
            return back()->withErrors([
                'tower_id' => 'Tower wajib dipilih untuk receptionist.',
            ])->withInput();
        }

        if ($validated['role'] === 'admin') {
            $validated['tower_id'] = null;
        }

        $payload = [
            'user_nik' => $validated['user_nik'],
            'user_name' => $validated['user_name'],
            'username' => $validated['username'],
            'role' => $validated['role'],
            'tower_id' => $validated['tower_id'],
        ];

        if (!empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $reception->update($payload);

        return redirect()->route('reception.index')
            ->with('success', 'Data reception berhasil diupdate.');
    }

    public function destroy(string $id): RedirectResponse
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat menghapus data reception.');
        }

        $reception = Reception::findOrFail($id);
        $reception->delete();

        return redirect()->route('reception.index')
            ->with('success', 'Data reception berhasil dihapus.');
    }
}