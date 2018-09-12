<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 14:56
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\UserTicket;


class UserTicketsTransformer extends TransformerAbstract
{
    public function transform(UserTicket $model){
        return [
            'id'=>$model->tickets->id,
            'card_id'=>$model->tickets->cardId,
            'discount' => $model->tickets->cardInfo['discount'],
            'full_amount' => $model->tickets->cardInfo['full_amount'],
            'cute_amount' => $model->tickets->cardInfo['cute_amount'],
        ];
    }
}