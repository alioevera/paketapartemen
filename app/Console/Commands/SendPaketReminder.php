<?php

namespace App\Console\Commands;

use App\Mail\PaketReminderMail;
use App\Models\Paketin;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPaketReminder extends Command
{
    protected $signature = 'paket:send-reminder';
    protected $description = 'Kirim reminder mingguan untuk paket yang belum diambil';

    public function handle(): int
    {
        $pakets = Paketin::with(['penghuni', 'expedisi'])
            ->where('status_verifikasi', 'Belum Diambil')
            ->get();

        foreach ($pakets as $paket) {
            if (! $paket->penghuni || empty($paket->penghuni->email) || ! $paket->input_date) {
                continue;
            }

            $inputDate = Carbon::parse($paket->input_date)->startOfDay();
            $today = now()->startOfDay();

            $daysSinceInput = $inputDate->diffInDays($today);

            if ($daysSinceInput < 7 || $daysSinceInput % 7 !== 0) {
                continue;
            }

            $batasPengambilan = $inputDate->copy()->addMonth()->subDays(7)->translatedFormat('d F Y');

            Mail::to($paket->penghuni->email)->send(
                new PaketReminderMail($paket, $paket->penghuni, $batasPengambilan)
            );

            $this->info("Reminder dikirim untuk paket ID {$paket->paketin_id}");
        }

        return self::SUCCESS;
    }
}