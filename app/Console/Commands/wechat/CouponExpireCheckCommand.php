<?php
/**
 * Created by PhpStorm.
 * User: katherine
 * Date: 19-4-15
 * Time: 下午2:49
 */

namespace App\Console\Commands\wechat;

use App\Entities\CustomerTicketCard;
use App\Jobs\wechat\SendMiniprogramTemplateMessage;
use App\Services\TemplateParser\TicketExpireParser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CouponExpireCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:expirecheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Coupon\'s expire status.';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        CustomerTicketCard::query()->where('status', CustomerTicketCard::STATUS_ON)
            ->where('end_at', '<=', Carbon::now()->subHours(5))
            ->chunk(100, function (Collection $customerTicketCards) {
                $customerTicketCards->map(function (CustomerTicketCard $customerTicketCard) {
                    $ticket = $customerTicketCard->ticket;
                    $customer = $customerTicketCard->customer;
                    $template = $ticket->templateMessage($customer->platformAppId, 'expire');
                    $wxTemplate = $template->wxTemplateMessage;
                    $job = (new SendMiniprogramTemplateMessage($customer, $wxTemplate->templateId, $template->content, new TicketExpireParser($ticket)))->delay(1);
                    dispatch($job);
                });
            });
    }
}