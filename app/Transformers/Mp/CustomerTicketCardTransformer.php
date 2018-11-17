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
            'id' => $model->id,
            'card_id'=>$model->card->cardId,
            'card_code' => $model->cardCode,
            'begin_at'  => isset($model->beginAt) ? $model->beginAt->format('Y-m-d H:i:s') : null,
            'end_at'    => isset($model->endAt) ? $model->endAt->format('Y-m-d H:i:s') : null,
            'status'    => $model->status,
            'title' => $model->card->card_info['base_info']['title'],
            'discount' => isset($model->card->cardInfo['discount']) ? round($model->card->cardInfo['discount']/10,2) : null ,
            'type' => mb_strtoupper($model->card->cardType),
            'least_cost' => isset($model->card->card_info['least_cost']) ? round($model->card->card_info['least_cost']/100,2) : null,
            'reduce_cost' => isset($model->card->card_info['reduce_cost']) ? round($model->card->card_info['reduce_cost']/100,2) : null,
            'is_limited'  => isset($model->card->card_info['base_info']['get_limit']) && $model->card->card_info['base_info']['get_limit'] ? true : false,
            'card_type'   => isset($model->card->card_info['base_info']['date_info']['begin_timestamp']) && $model->card->card_info['base_info']['date_info']['begin_timestamp'] == 0
            ? $model->card->card_info['base_info']['date_info']['type'].'_0' : $model->card->card_info['base_info']['date_info']['type'].'_1',
//            'record_count' => $model->card->recordCount,
            'begin_timestamp' => isset($model->card->card_info['base_info']['date_info']['begin_timestamp']) ? date('Y-m-d H:i:s',$model->card->card_info['base_info']['date_info']['begin_timestamp']) : '',
            'end_timestamp' => isset($model->card->card_info['base_info']['date_info']['end_timestamp']) ? date('Y-m-d H:i:s',$model->card->card_info['base_info']['date_info']['end_timestamp']) : '',
            'fixed_begin_term' => isset($model->card->card_info['base_info']['date_info']['fixed_begin_term']) ? $model->card->card_info['base_info']['date_info']['fixed_begin_term'] : '',
            'fixed_term'       =>  isset($model->card->card_info['base_info']['date_info']['fixed_term']) ? $model->card->card_info['base_info']['date_info']['fixed_term'] : '',
        ];
    }
}