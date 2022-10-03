<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string $firstName */
    public $firstName;

    /** @var string $lastName */
    public $lastName;

    /** @var string $subject */
    public $subject;

    /** @var string $message */
    public $message;

    /** @var string $email */
    public $email;

    /** @var string $phone */
    public $phone;

    /**
     * Create a new message instance.
     *
     * @param array $array
     * @return void
     */
    public function __construct(array $array)
    {
        $this->firstName = $array['firstName'];
        $this->lastName = $array['lastName'];
        $this->subject = $array['subject'];
        $this->email = $array['email'];
        $this->phone = $array['phone'];

        $this->message = str_replace(
            array("[[first_name]]", "[[last_name]]", "[[phone]]", "[[email]]"),
            array($this->firstName, $this->lastName, $this->phone, $this->email),
            $array['message']
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.member-mail')
            ->with([
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'subject' => $this->subject,
                'message' => $this->message,
            ])
        ;
    }
}
