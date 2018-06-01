<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/5/29
 * Time: 下午2:28
 */

namespace App\Services;


use EasyWeChat\OfficialAccount\Server\Guard;

class WechatService
{
    protected $config = null;

    protected $officeAccount = null;

    protected $miniProgram = null;

    protected $payment = null;

    public function officeAccount()
    {
        if(!$this->officeAccount)
            $this->officeAccount= app('wechat.official_account.default');
        $this->officeAccount->config->merge($this->config);
        return ($this->officeAccount);
    }

    public function payment()
    {
        if(!$this->payment)
            $this->payment = app('wechat.payment.default');
        $this->payment->config->merge($this->config);
        return $this->payment;
    }

    public function miniProgram()
    {
        if(!$this->miniProgram)
            $this->miniProgram = app('wechat.mini_program.default');
        $this->miniProgram->config->merge($this->config);
        return $this->miniProgram;
    }

    public function memberCard(array $data)
    {
        return $this->officeAccount()->card->member_card->create(MEMBER_CARD, $data);
    }

    public function redPack()
    {
        return $this->payment()->redpack;
    }

    public function couponCard(array $data)
    {
        return $this->officeAccount()->card->general_card->create(COUPON_CARD, $data);
    }

    public function discountCard(array $data)
    {
        return $this->officeAccount()->card->general_card->create(DISCOUNT_CARD, $data);
    }

    public function grouponCard(array $data)
    {
        return $this->officeAccount()->card->general_card->create(GROUPON_CARD, $data);
    }

    public function cardCodeCheck(string $cardId, string $code)
    {
        return $this->officeAccount()->card->code->check($cardId, array($code));
    }

    public function cardCodeConsume(string $cardId, string $code)
    {
        return $this->officeAccount()->card->code->consume($cardId, $code);
    }

    public function decryptCode(string  $code)
    {
        return $this->officeAccount()->card->code->decrypt($code);
    }

    public function getCard(string $cardId)
    {
        return $this->officeAccount()->card->general_card->get($cardId);
    }

    public function miniProgramServer()
    {
        return $this->miniProgram()->server;
    }

    public function officeAccountServer()
    {
        return $this->officeAccount()->server;
    }

    public function officeAccountServerHandle()
    {
        $this->officeAccountServer()->push(function ($message) {
            $this->serverMessageHandle($this->officeAccountServer(), $message);
        });
        return $this->officeAccountServer()->serve();
    }

    public function miniProgramServerHandle()
    {

        $this->miniProgramServer()->push(function ($message) {
           $this->serverMessageHandle($this->miniProgramServer(), $message);
        });

        return $this->miniProgramServer()->serve();
    }

    protected function serverMessageHandle(Guard $server, $message)
    {
        switch ($message['MsgType']) {
            case WECHAT_TEXT_MESSAGE: {
                $server->dispatch();
                break;
            }
            case WECHAT_IMAGE_MESSAGE: {
                $server->dispatch();
                break;
            }
            case WECHAT_VOICE_MESSAGE: {
                $server->dispatch();
                break;
            }
            case WECHAT_EVENT_MESSAGE: {
                $server->dispatch($message['Event'], $message);
                break;
            }
            default:
                break;
        }
    }

}