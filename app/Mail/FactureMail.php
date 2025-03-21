<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FactureMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    public $facturePath;

    public function __construct(Commande $commande, $facturePath)
    {
        $this->commande = $commande;
        $this->facturePath = $facturePath;
    }

    public function build()
    {
        return $this->subject('Votre facture - Commande #' . $this->commande->id)
                    ->view('emails.facture')
                    ->attach($this->facturePath, [
                        'as' => 'facture_' . $this->commande->id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}