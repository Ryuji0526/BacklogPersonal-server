<?php

namespace App\Console\Commands;

use App\Modules\ApplicationLogger;
use Illuminate\Console\Command;
use App\Jobs\SendDailyReportMailJob;

class SendDailyReportBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendDailyReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 日報バッチ処理
     *
     * @return void
     */
    public function handle()
    {
        $logger = new ApplicationLogger(__METHOD__);
        $logger->write("バッチ処理を実行します");
        SendDailyReportMailJob::dispatch();
        $logger->success();
    }
}
