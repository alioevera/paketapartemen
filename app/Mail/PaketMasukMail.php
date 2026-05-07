<?php

namespace App\Mail;

use App\Models\Paketin;
use App\Models\Penghuni;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaketMasukMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paket;
    public $penghuni;
    public $qrValue;
    public $qrPng;

    public function __construct(Paketin $paket, Penghuni $penghuni)
    {
        $this->paket = $paket;
        $this->penghuni = $penghuni;
        $this->qrValue = 'PAKET-' . $paket->paketin_id;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($this->qrValue)
            ->size(260)
            ->margin(10)
            ->build();

        $this->qrPng = $result->getString();
    }

    public function build()
    {
        return $this->subject('Paket Anda Sudah Tiba di Resepsionis')
            ->view('emails.paket-masuk')
            ->with([
                'paket' => $this->paket,
                'penghuni' => $this->penghuni,
                'qrValue' => $this->qrValue,
                'qrPng' => $this->qrPng,
            ]);
    }
}