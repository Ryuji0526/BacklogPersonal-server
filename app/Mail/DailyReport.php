<?php

namespace App\Mail;

use App\Modules\ApplicationLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
     * 日報メール送信
     *
     * @return void
     */
    public function build()
    {
        $logger = new ApplicationLogger(__METHOD__);
        return $this->view('emails.dailyReport.index')->subject('[BacklogPersonal]日報');
    }
}
