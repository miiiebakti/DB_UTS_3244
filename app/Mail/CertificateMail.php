<?php

namespace App\Mail;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
{
    $pdf = Pdf::loadView('admin.certificate', [
        'transaction' => $this->transaction
    ]);

    return $this
        ->subject('E-Sertifikat Event')
        ->view('emails.certificate')
        ->attachData(
            $pdf->output(),
            'E-Certificate.pdf',
            [
                'mime' => 'application/pdf',
            ]
        );
}
}