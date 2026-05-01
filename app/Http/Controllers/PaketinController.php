<?php

namespace App\Http\Controllers;

use App\Models\Expedisi;
use App\Models\Penghuni;
use App\Models\Paketin;
use App\Models\Paketout;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class PaketinController extends Controller
{
    public function index(): Response
    {
        $paket = Paketin::with(['reception', 'expedisi', 'tower', 'penghuni'])
            ->orderByDesc('input_date')
            ->get()
            ->map(function ($item) {
                return [
                    'paketin_id' => $item->paketin_id,
                    'input_date' => optional($item->input_date)->format('Y-m-d'),
                    'input_time' => optional($item->input_date)->format('H:i'),
                    'input_date_raw' => optional($item->input_date)?->toDateTimeString(),
                    'penerima_input' => $item->reception?->user_name,
                    'expedisi_name' => $item->expedisi?->expedisi_name,
                    'nomor_unit' => $item->unit,
                    'tower_name' => $item->tower?->tower_name,
                    'kepada' => $item->penghuni?->nama_penghuni,
                    'status_verifikasi' => $item->status_verifikasi,
                ];
            });

        return Inertia::render('LihatPaket', [
            'paket' => $paket,
            'authUser' => [
                'user_nik' => Auth::user()?->user_nik,
                'user_name' => Auth::user()?->user_name,
            ],
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('TambahPaketMasuk', [
            'authUser' => [
                'user_nik' => Auth::user()?->user_nik,
                'user_name' => Auth::user()?->user_name,
            ],
            'expedisi' => Expedisi::orderBy('expedisi_name')->get(['expedisi_id', 'expedisi_name']),
            'prefill' => [
                'unit' => $request->query('unit'),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_masuk' => ['required', 'date'],
            'jam_masuk' => ['required'],
            'expedisi_id' => ['required', 'exists:expedisi,expedisi_id'],
            'unit' => ['required', 'string', 'max:10'],
            'bentuk_paket' => ['required', 'string'],
            'jumlah_paket' => ['required', 'integer', 'min:1'],
            'lokasi_simpan' => ['required', 'string'],
            'foto_paket' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $penghuni = Penghuni::where('unit', $validated['unit'])->first();

        if (! $penghuni) {
            return back()->withErrors([
                'unit' => 'Nomor unit tidak ditemukan pada data penghuni.',
            ])->withInput();
        }

        $inputDateTime = Carbon::parse($validated['tanggal_masuk'].' '.$validated['jam_masuk']);

        $fotoPath = null;
        if ($request->hasFile('foto_paket')) {
            $fotoPath = $request->file('foto_paket')->store('foto-paket', 'public');
        }

        Paketin::create([
            'user_nik' => Auth::user()->user_nik,
            'input_date' => $inputDateTime,
            'tower_id' => $penghuni->tower_id,
            'penghuni_id' => $penghuni->penghuni_id,
            'unit' => $validated['unit'],
            'bentuk_paket' => $validated['bentuk_paket'],
            'jumlah_paket' => $validated['jumlah_paket'],
            'lokasi_simpan' => $validated['lokasi_simpan'],
            'expedisi_id' => $validated['expedisi_id'],
            'foto_paket' => $fotoPath,
            'hasil_ocr' => null,
            'status_verifikasi' => 'Belum Diambil',
        ]);

        return redirect()->route('lihat-paket.index')
            ->with('success', 'Paket berhasil disimpan.');
    }

    public function show($id): Response
    {
        $paket = Paketin::with([
            'reception',
            'expedisi',
            'tower',
            'penghuni',
            'paketout.reception',
        ])->findOrFail($id);

        return Inertia::render('PaketEdit', [
            'paket' => [
                'paketin_id' => $paket->paketin_id,
                'unit' => $paket->unit,
                'input_date' => optional($paket->input_date)->format('Y-m-d'),
                'input_time' => optional($paket->input_date)->format('H:i'),
                'reception_name' => $paket->reception?->user_name,
                'tower_name' => $paket->tower?->tower_name,
                'penghuni_name' => $paket->penghuni?->nama_penghuni,
                'expedisi_name' => $paket->expedisi?->expedisi_name,
                'bentuk_paket' => $paket->bentuk_paket,
                'jumlah_paket' => $paket->jumlah_paket,
                'lokasi_simpan' => $paket->lokasi_simpan,
                'status_verifikasi' => $paket->status_verifikasi,
                'foto_paket' => $paket->foto_paket,
                'paketout' => $paket->paketout ? [
                    'paketout_id' => $paket->paketout->paketout_id,
                    'out_date' => optional($paket->paketout->out_date)->format('Y-m-d'),
                    'out_time' => optional($paket->paketout->out_date)->format('H:i'),
                    'pengambil' => $paket->paketout->pengambil,
                    'saksi_keluar' => $paket->paketout->reception?->user_name,
                ] : null,
            ],
            'authUser' => [
                'user_nik' => Auth::user()?->user_nik,
                'user_name' => Auth::user()?->user_name,
            ],
        ]);
    }

    public function edit($id): Response
    {
        $paket = Paketin::with([
            'reception',
            'expedisi',
            'tower',
            'penghuni',
            'paketout.reception',
        ])->findOrFail($id);

        return Inertia::render('PaketEdit', [
            'paket' => [
                'paketin_id' => $paket->paketin_id,
                'unit' => $paket->unit,
                'input_date' => optional($paket->input_date)->format('Y-m-d'),
                'input_time' => optional($paket->input_date)->format('H:i'),
                'reception_name' => $paket->reception?->user_name,
                'tower_name' => $paket->tower?->tower_name,
                'penghuni_name' => $paket->penghuni?->nama_penghuni,
                'expedisi_name' => $paket->expedisi?->expedisi_name,
                'bentuk_paket' => $paket->bentuk_paket,
                'jumlah_paket' => $paket->jumlah_paket,
                'lokasi_simpan' => $paket->lokasi_simpan,
                'status_verifikasi' => $paket->status_verifikasi,
                'foto_paket' => $paket->foto_paket,
                'paketout' => $paket->paketout ? [
                    'paketout_id' => $paket->paketout->paketout_id,
                    'out_date' => optional($paket->paketout->out_date)->format('Y-m-d'),
                    'out_time' => optional($paket->paketout->out_date)->format('H:i'),
                    'pengambil' => $paket->paketout->pengambil,
                    'saksi_keluar' => $paket->paketout->reception?->user_name,
                ] : null,
            ],
            'authUser' => [
                'user_nik' => Auth::user()?->user_nik,
                'user_name' => Auth::user()?->user_name,
            ],
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'out_date' => ['nullable', 'date'],
            'out_time' => ['nullable'],
            'pengambil' => ['nullable', 'string', 'max:255'],
        ]);

        $paketin = Paketin::findOrFail($id);

        if (! empty($validated['out_date']) && ! empty($validated['out_time']) && ! empty($validated['pengambil'])) {
            $outDateTime = Carbon::parse($validated['out_date'].' '.$validated['out_time']);

            Paketout::updateOrCreate(
                ['paketin_id' => $paketin->paketin_id],
                [
                    'user_nik' => Auth::user()->user_nik,
                    'out_date' => $outDateTime,
                    'pengambil' => $validated['pengambil'],
                ]
            );

            $paketin->update([
                'status_verifikasi' => 'Sudah Diambil',
            ]);
        }

        return redirect()->route('paket.show', $paketin->paketin_id)
            ->with('success', 'Detail paket keluar berhasil diperbarui.');
    }

    public function ocrCreate(): Response
    {
        return Inertia::render('PaketMasukOCR', [
            'authUser' => [
                'user_nik' => Auth::user()?->user_nik,
                'user_name' => Auth::user()?->user_name,
            ],
            'expedisi' => Expedisi::orderBy('expedisi_name')
                ->get(['expedisi_id', 'expedisi_name']),
        ]);
    }

    public function ocrProcess(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $file = $request->file('foto');

        $response = Http::timeout(180)
            ->attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )
            ->post(config('services.ocr.url', env('OCR_SERVICE_URL', 'http://127.0.0.1:8001/ocr')));

        if (! $response->successful()) {
            return back()->withErrors([
                'foto' => 'OCR gagal diproses. Status: '.$response->status().' | Response: '.$response->body(),
            ]);
        }



        $ocr = $response->json();

        $ocrTexts = collect();

        // kalau ada texts langsung
        if (isset($ocr['texts'])) {
            $ocrTexts = collect($ocr['texts']);
        }

        // kalau pakai PaddleOCR result
        elseif (isset($ocr['result'])) {
            foreach ($ocr['result'] as $item) {
                if (isset($item['rec_texts'])) {
                    $ocrTexts = $ocrTexts->merge($item['rec_texts']);
                }
            }
        }

        $ocrTexts = $ocrTexts->filter()->values();
        $hasilText = $ocrTexts->implode("\n");

        $detectedExpedisiName = null;
        $matchedExpedisiOptions = [];
        $detectedUnit = null;

        $expedisiList = Expedisi::orderBy('expedisi_name')->get(['expedisi_id', 'expedisi_name']);

        foreach ($expedisiList as $exp) {
            if (stripos($hasilText, $exp->expedisi_name) !== false) {
                $detectedExpedisiName = $exp->expedisi_name;
                $matchedExpedisiOptions[] = [
                    'expedisi_id' => $exp->expedisi_id,
                    'expedisi_name' => $exp->expedisi_name,
                ];
            }
        }

        // cocok untuk: UNIT 3205, UNIT3205, UNIT 3205JL, UNIT3205JL
        if (preg_match('/unit\s*(\d{3,5})/i', $hasilText, $matches)) {
            $detectedUnit = $matches[1];
        }
        // fallback kalau ada angka 4 digit yang paling masuk akal
        elseif (preg_match('/\b(3\d{3})\b/', $hasilText, $matches)) {
            $detectedUnit = $matches[1];
        }

        return redirect()->route('paket-masuk.create', [
            'unit' => $detectedUnit,
        ])->with([
            'ocr_result' => [
                'texts' => $ocrTexts,
                'raw_text' => $hasilText,
                'detected_expedisi_name' => $detectedExpedisiName,
                'matched_expedisi_options' => $matchedExpedisiOptions,
                'detected_unit' => $detectedUnit,
            ],
        ]);
    }
}