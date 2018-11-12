<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 17:41
 */

namespace App\Transformers\Mp;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use League\Fractal\TransformerAbstract;
use App\Entities\Shop;

class ShopPositionTransformer extends TransformerAbstract
{
    protected $lat;
    protected $lng;

    public function transform(Shop $model)
    {

        tap($model->position, function (Point $point){
            $this->lat = $point->getLat();
            $this->lng = $point->getLng();
        });
        return [
            'id'         => $model->id,
            'name' => $model->name,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'address' => $model->address,
            'mobile' =>  null,
        ];
    }
}