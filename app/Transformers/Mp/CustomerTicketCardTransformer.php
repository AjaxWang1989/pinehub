<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/27
 * Time: 18:08
 */

namespace App\Transformers\Mp;
use League\Fractal\TransformerAbstract;
use App\Entities\CustomerTicketCard;


class CustomerTicketCardTransformer extends TransformerAbstract
{
    public function transform(CustomerTicketCard $model){
        return [
            'card_id'=>$model->card->cardId,
            'title' => $model->card->card_info['cash']['base_info']['title'],
            'least_cost' => $model->card->card_info['cash']['least_cost']/100,
            'begin_timestamp' => date('Y-m-d H:i:s',$model->card->card_info['cash']['date_info']['begin_timestamp']),
            'end_timestamp' => date('Y-m-d H:i:s',$model->card->card_info['cash']['date_info']['end_timestamp']),
        ];
    }
}