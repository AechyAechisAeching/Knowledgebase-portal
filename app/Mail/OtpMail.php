<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Wachtwoord wijzigen"
        );
    }

    public function content(): Content
    {
        $otp = $this->otp;

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
                background-color: #e8c547;
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
                text-transform: uppercase;
                color: #999;
                margin-bottom: 12px;
            }
            h1 {
                font-size: 26px;
                font-weight: 600;
                color: #1a1a1a;
                line-height: 1.3;
                margin-bottom: 18px;
            }
            .divider {
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
            .otp-box {
                background-color: #f7f5f1;
                border: 1.5px dashed #d4cfc6;
                border-radius: 12px;
                padding: 12px;
                text-align: center;
                margin-bottom: 28px;
            }
            .otp-code {
                font-family: 'DM Mono', monospace;
                font-size: 42px;
                font-weight: 500;
                letter-spacing: 0.18em;
                color: #1a1a1a;
                display: inline-block;
            }
            .notice {
                background-color: #fff8e1;
                border-left: 3px solid #e8c547;
                border-radius: 0 8px 8px 0;
                padding: 12px 16px;
                margin-bottom: 28px;
                font-size: 13px;
                color: #7a6b2e;
                line-height: 1.5;
            }
            .body-text {
               text-align: center;
                font-size: 14px;
                color: #666;
                line-height: 1.7;
            }
            .footer {
                text-align: center;
                margin-top: 28px;
                font-size: 12px;
                color: #aaaa9f;
                line-height: 1.6;
            }
        </style>
    </head>
    <body>
        <div class='wrapper'>
            <div class='header'>
                <span class='header-dot'></span>
                <span class='header-title'>Bevestigings code</span>
            </div>
            <div class='card'>
                <p class='eyebrow'>Beveiligingscode</p>
                <h1>Bevestig jouw <br> e-mailadres</h1>
                <p class='body-text'>
                    Gebruik de onderstaande code om jouw wachtwoord te veranderen.
                    Voer de code in op de pagina waar je hierom werd gevraagd.
                </p>
                <div class='divider'></div>
                <p class='otp-label'>Jouw code</p>
                <div class='otp-box'>
                    <span class='otp-code'>{$otp}</span>
                </div>
                <div class='notice'>
                    Deze code <strong>verloopt over 10 minuten</strong>.
                    Heb jij dit niet aangevraagd? Dan kun je deze e-mail veilig
                    negeren.
                </div>
                <p class='body-text'>
                    Deel deze code nooit met anderen. <br> Het word maar èèn keer gevraagd
                </p>
            </div>
            <div class='footer'>
                <p>
                    Je ontvangt deze e-mail omdat er een wachtwoord reset is
                    aangevraagd voor jouw account.
                </p>
            </div>
        </div>
    </body>
</html>


"
            
        );
    }

    // public function attachments(): array
    // {
    //     return [];
    // }
}
