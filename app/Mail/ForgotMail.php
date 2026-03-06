<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
        // public $otp;
    public function __construct()
    {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Wachtwoord vergeten',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        // $otp = $this->otp;


        return new Content(
            htmlString: "
          <!DOCTYPE html>
<html lang='nl'>
    <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@500&display=swap');
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                background-color: #f0ede8;
                font-family: 'DM Sans', sans-serif;
                padding: 48px 16px;
                color: #1a1a1a;
            }
            .wrapper {
                max-width: 520px;
                margin: 0 auto;
            }
            .header {
                background-color: #1a1a1a;
                border-radius: 16px 16px 0 0;
                padding: 24px 36px;
            }
            .header-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background-color: #129900;
                display: inline-block;
                margin-right: 10px;
                vertical-align: middle;
            }
            .header-title {
                font-size: 13px;
                font-weight: 600;
                color: #ffffff;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                vertical-align: middle;
            }
            .card {
                background-color: #ffffff;
                border-radius: 0 0 16px 16px;
                padding: 44px 36px 40px;
                border: 1px solid #e4e0d8;
                border-top: none;
            }
            .eyebrow {
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 0.14em;
                text-align: center;
                text-transform: uppercase;
                color: #999;
                margin-bottom: 12px;
            }
            h1 {
               text-align: center;
                font-size: 26px;
                font-weight: 600;
                color: #1a1a1a;
                line-height: 1.3;
                margin-bottom: 18px;
            }
            
            .divider {
               text-align: center;
                height: 1px;
                background: #f0ede8;
                margin: 28px 0;
            }
            .otp-label {
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: #999;
                margin-bottom: 14px;
            }
            .text {
               text-align: center;
            }
        
            .body-text {
               text-align: center;
                font-size: 14px;
                color: #666;
                line-height: 3.7;
            }
            .action {
            line-height: 3.9;
            }

            .footer {
                text-align: center;
                margin-top: 28px;
                font-size: 12px;
                color: #aaaa9f;
                line-height: 1.3;
            }
        </style>
    </head>
    <body>
        <div class='wrapper'>
            <div class='header'>
                <span class='header-dot'></span>
                <span class='header-title'>Wachtwoord vergeten</span>
            </div>
            <div class='card'>
                <p class='eyebrow'>Beveiligingsemail</p>
                <h1>Wachtwoord Wijziging<br>Plaats gevonden</h1>
                <p class='body-text'>
                    Er is een wachtwoord wijziging plaats gevonden op jouw account.
                </p>
                <div class='divider'></div>
                <div class='text'>
                    Heb jij dit niet aangevraagd?
                </div>
                    <div class='action'>
                    <p class='eyebrow'>Neem actie zo snel mogelijk!</p>
                </div>
                </div>
            <div class='footer'>
                <p>Je ontvangt deze e-mail omdat er een wachtwoord vergeten is
                    plaats gevonden voor jouw account.
                </p>
            </div>
        </div>
    </body>
</html>

"
            
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
