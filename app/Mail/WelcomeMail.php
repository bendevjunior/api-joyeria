<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,  $password = null)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contato@joyeria.com.br', 'Contato Joyeria')
                ->view('templates.mail.welcome', [
                    'user' => $this->user,
                    'password' => $this->password
                ]);
    }
}
