<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Modules\ApplicationLogger;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReport;
use App\Services\UserIssueService;

class SendDailyReportMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * 非同期で日報メール送信
     *
     * @return void
     */
    public function handle()
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write("ユーザーを取得します");
            app(UserIssueService::class)->fetchAndSendTodaysUpdateIssues();
        } catch (\Throwable $e) {
            $logger->write($e->getMessage());
        }
    }
}
