<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Workspace Uitnodiging',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
        htmlString: "
            <!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
  <title>Workspace Invitation</title>
</head>
<body style='margin:0;padding:0;background-color:#0f0f0f;font-family:'Georgia',serif;'>

  <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#0f0f0f;padding:48px 16px;'>
    <tr>
      <td align='center'>
        <table width='560' cellpadding='0' cellspacing='0' style='max-width:560px;width:100%;'>

          <tr>
            <td style='padding-bottom:32px;' align='center'>
              <span style='font-family:'Georgia',serif;font-size:13px;letter-spacing:0.2em;text-transform:uppercase;color:#666;'>
                ✦ &nbsp; Workspace &nbsp; ✦
              </span>
            </td>
          </tr>

          <tr>
            <td style='background-color:#1a1a1a;border-radius:4px;border:1px solid #2a2a2a;overflow:hidden;'>

              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='height:3px;background:linear-gradient(90deg,#c9a96e,#e8c98a,#c9a96e);'></td>
                </tr>
              </table>

              <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='padding:48px 48px 40px;'>

                    <p style='margin:0 0 28px;font-size:12px;letter-spacing:0.15em;text-transform:uppercase;color:#666;font-family:'Georgia',serif;'>
                      You've been invited by
                    </p>

                    <table cellpadding='0' cellspacing='0' style='margin-bottom:36px;'>
                      <tr>
                        <td style='width:44px;height:44px;border-radius:50%;background-color:#c9a96e;text-align:center;vertical-align:middle;'>
                          <span style='font-size:16px;font-weight:bold;color:#0f0f0f;font-family:'Georgia',serif;'>JD</span>
                        </td>
                        <td style='padding-left:14px;'>
                          <p style='margin:0;font-size:15px;font-weight:bold;color:#f0ead6;font-family:'Georgia',serif;'>Jane Doe</p>
                          <p style='margin:2px 0 0;font-size:13px;color:#666;'>jane@example.com</p>
                        </td>
                      </tr>
                    </table>

                    <h1 style='margin:0 0 16px;font-size:28px;line-height:1.25;color:#f0ead6;font-family:'Georgia',serif;font-weight:normal;'>
                      Join <em style='color:#c9a96e;'>Acme Corp</em><br/>on Workspace
                    </h1>

                    <p style='margin:0 0 36px;font-size:15px;line-height:1.75;color:#999;'>
                      Jane has invited you to collaborate on the <strong style='color:#c9a96e;'>Acme Corp</strong> workspace. 
                      Accept the invitation to start working together on projects, documents, and more.
                    </p>

                    <table cellpadding='0' cellspacing='0'>
                      <tr>
                        <td style='background-color:#c9a96e;border-radius:3px;'>
                          <a href='#' style='display:inline-block;padding:14px 36px;font-size:13px;letter-spacing:0.12em;text-transform:uppercase;color:#0f0f0f;text-decoration:none;font-family:'Georgia',serif;font-weight:bold;'>
                            Accept Invitation
                          </a>
                        </td>
                      </tr>
                    </table>

                    <table width='100%' cellpadding='0' cellspacing='0' style='margin:36px 0;'>
                      <tr>
                        <td style='height:1px;background-color:#2a2a2a;'></td>
                      </tr>
                    </table>

                    <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#141414;border-radius:3px;border:1px solid #2a2a2a;'>
                      <tr>
                        <td style='padding:20px 24px;'>
                          <p style='margin:0 0 12px;font-size:11px;letter-spacing:0.15em;text-transform:uppercase;color:#555;'>Workspace Details</p>
                          <table width='100%' cellpadding='0' cellspacing='0'>
                            <tr>
                              <td style='padding:4px 0;'>
                                <span style='font-size:13px;color:#666;'>Workspace</span>
                              </td>
                              <td align='right'>
                                <span style='font-size:13px;color:#c9a96e;'>Acme Corp</span>
                              </td>
                            </tr>
                            <tr>
                              <td style='padding:4px 0;'>
                                <span style='font-size:13px;color:#666;'>Your role</span>
                              </td>
                              <td align='right'>
                                <span style='font-size:13px;color:#f0ead6;'>Member</span>
                              </td>
                            </tr>
                            <tr>
                              <td style='padding:4px 0;'>
                                <span style='font-size:13px;color:#666;'>Expires</span>
                              </td>
                              <td align='right'>
                                <span style='font-size:13px;color:#f0ead6;'>in 7 days</span>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <p style='margin:24px 0 0;font-size:12px;color:#555;line-height:1.6;'>
                      If the button doesn't work, copy this link:<br/>
                      <a href='#' style='color:#666;word-break:break-all;'>https://workspace.example.com/invite/abc123xyz</a>
                    </p>

                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <tr>
            <td style='padding:28px 0 0;' align='center'>
              <p style='margin:0;font-size:12px;color:#444;'>
                If you weren't expecting this invitation, you can safely ignore it.
              </p>
              <p style='margin:8px 0 0;font-size:11px;letter-spacing:0.1em;color:#333;text-transform:uppercase;'>
                © 2026 &nbsp;·&nbsp; Workspace &nbsp;·&nbsp; <a href='#' style='color:#333;text-decoration:none;'>Unsubscribe</a>
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

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
