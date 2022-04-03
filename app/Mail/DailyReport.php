<?php

namespace App\Mail;

use App\Modules\ApplicationLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Psr\Http\Message\StreamInterface;

class DailyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $issues;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $issues)
    {
        $this->issues = $issues;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $logger = new ApplicationLogger(__METHOD__);
        $logger->write($this->issues[0]['summary']);
        return $this->view('emails.dailyReport.index')->subject('[BacklogPersonal]日報');
    }
}
