<?php
// app/Mail/InvitationEmail.php
namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;

    public function __construct(Invitation $invite)
    {
        $this->invite = $invite;
    }

    public function build()
    {
        return $this->view('emails.invite')
                    ->with([
                        'url' => route('signup', ['token' => $this->invite->token]),
                    ]);
    }
}
