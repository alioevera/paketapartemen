<?php

namespace App\Mail;

use App\Models\Paketin;
use App\Models\Penghuni;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaketReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Paketin $paket,
        public Penghuni $penghuni,
        public string $batasPengambilan
    ) {
    }

    public function build()
    {
        return $this->subject('Pengingat: Paket Anda Belum Diambil')
            ->view('emails.paket-reminder');
    }
}