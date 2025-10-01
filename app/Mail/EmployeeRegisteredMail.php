<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $plainPassword;

    /**
     * Create a new message instance.
     */
    public function __construct($employee, $plainPassword)
    {
        $this->employee = $employee;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to the Company - Your Account Details')
                    ->view('emails.employee_registered')
                    ->with([
                        'employee'      => $this->employee,
                        'plainPassword' => $this->plainPassword,
                    ]);
    }
}
