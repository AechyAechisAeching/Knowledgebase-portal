<?php

namespace App\Mail;

use App\Models\Workspace;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Workspace $workspace,
        public string $acceptUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uitnodiging voor ' . $this->workspace->name,
        );
    }

    public function content(): Content
    {
        $appName = config('app.name');
        $workspaceName = e($this->workspace->name);
        $acceptUrl = e($this->acceptUrl);
        $year = date('Y');

        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="nl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Uitnodiging</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f5;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    color: #18181b;
                }
                .wrapper { padding: 40px 16px; }
                .card {
                    max-width: 520px;
                    margin: 0 auto;
                    background: #ffffff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
                }
                .header { background-color: #18181b; padding: 28px 40px; }
                .header span { color: #ffffff; font-size: 18px; font-weight: 600; }
                .body { padding: 36px 40px; }
                .body h1 { margin: 0 0 12px; font-size: 22px; font-weight: 600; color: #18181b; }
                .body p { margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #52525b; }
                .btn {
                    display: inline-block;
                    background-color: #18181b;
                    color: #ffffff !important;
                    text-decoration: none;
                    font-size: 15px;
                    font-weight: 500;
                    padding: 12px 28px;
                    border-radius: 8px;
                    margin-bottom: 28px;
                }
                .divider { border: none; border-top: 1px solid #e4e4e7; margin: 0 0 24px; }
                .footer { padding: 0 40px 32px; font-size: 13px; color: #a1a1aa; line-height: 1.6; }
            </style>
        </head>
        <body>
            <div class="wrapper">
                <div class="card">
                    <div class="header">
                        <span>{$appName}</span>
                    </div>
                    <div class="body">
                        <h1>Je bent uitgenodigd</h1>
                        <p>
                            Je bent uitgenodigd om lid te worden van <strong>{$workspaceName}</strong>.<br>
                            Klik op de knop hieronder om de uitnodiging te accepteren. De link is 7 dagen geldig.
                        </p>
                        <a href="{$acceptUrl}" class="btn">Uitnodiging accepteren</a>
                        <hr class="divider">
                        <p style="margin:0;font-size:13px;color:#a1a1aa;">
                            Als je deze uitnodiging niet verwacht, kun je deze e-mail negeren.
                        </p>
                    </div>
                    <div class="footer">
                        &copy; {$year} {$appName}
                    </div>
                </div>
            </div>
        </body>
        </html>
        HTML;

        return new Content(htmlString: $html);
    }
}