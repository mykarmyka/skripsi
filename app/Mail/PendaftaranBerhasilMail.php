<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranBerhasilMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pasien;
    public $noAntrian;
    public $namaLayanan;
    public $estimasiDatang;
    public $tglPendaftaran;

    public function __construct($pasien, $noAntrian, $namaLayanan, $estimasiDatang, $tglPendaftaran)
    {
        $this->pasien = $pasien;
        $this->noAntrian = $noAntrian;
        $this->namaLayanan = $namaLayanan;
        $this->estimasiDatang = $estimasiDatang;
        $this->tglPendaftaran = $tglPendaftaran;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Layanan Klinik Anda Berhasil')
                    ->markdown('emails.pendaftaran')
                    ->with([
                        'pasien' => $this->pasien,
                        'noAntrian' => $this->noAntrian,
                        'namaLayanan' => $this->namaLayanan,
                        'estimasiDatang' => $this->estimasiDatang,
                        'tglPendaftaran' => $this->tglPendaftaran
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Berhasil Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pendaftaran',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
