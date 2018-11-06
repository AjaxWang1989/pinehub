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
            'title' => $model->card->card_info['base_info']['title'],
            'discount' => isset($model->card->cardInfo['discount']) ? $model->card->cardInfo['discount'] : null ,
            'type' => mb_strtoupper($model->card->cardType),
            'least_cost' => isset($model->card->card_info['least_cost']) ?$model->card->card_info['least_cost']/100 : null,
            'reduce_cost' => isset($model->card->card_info['reduce_cost']) ?$model->card->card_info['reduce_cost']/100 : null,
            'is_limited'  => isset($model->card->card_info['base_info']['get_limit']) && $model->card->card_info['base_info']['get_limit'] ? true : false,
            'card_type'   => isset($model->card->card_info['base_info']['date_info']['begin_timestamp']) && $model->card->card_info['base_info']['date_info']['begin_timestamp'] == 0
            ? $model->card->card_info['base_info']['date_info']['type'].'_0' : $model->card->card_info['base_info']['date_info']['type'].'_1',
            'record_count' => $model->card->recordCount,
            'begin_timestamp' => isset($model->card->card_info['base_info']['date_info']['begin_timestamp']) ? date('Y-m-d H:i:s',$model->card->card_info['base_info']['date_info']['begin_timestamp']) : '',
            'end_timestamp' => isset($model->card->card_info['base_info']['date_info']['end_timestamp']) ? date('Y-m-d H:i:s',$model->card->card_info['base_info']['date_info']['end_timestamp']) : '',
        ];
    }
}