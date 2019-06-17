<?php

namespace App\Excel\generators;

use App\Criteria\Admin\SearchRequestCriteria;
use App\Entities\Shop;
use App\Excel\BaseGenerator;
use App\Repositories\ShopRepository;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Prettus\Repository\Criteria\RequestCriteria;

class ShopTurnoverGenerator extends BaseGenerator
{

    /**
     * 表头
     * @return mixed
     */
    public function header()
    {
        return [
            ['key' => 'shopName', 'desc' => '店铺名称', 'width' => 20],
            ['key' => 'shopNo', 'desc' => '店铺编号', 'width' => 20],
            ['key' => 'turnover', 'desc' => '汇总金额(元)', 'type' => DataType::TYPE_NUMERIC, 'width' => 20]
        ];
    }

    public function getShopName(Shop $shop)
    {
        return $shop->name;
    }

    public function getShopNo(Shop $shop)
    {
        return $shop->code;
    }

    public function getTurnover(Shop $shop)
    {
        return round($shop->sell_amount ?: 0, 2);
    }

    /**
     * 表数据
     * @param array $params 查询参数
     * @return mixed
     */
    public function bodyData(array $params)
    {
        $shopRepository = app(ShopRepository::class);

        $shopRepository->pushCriteria(app(RequestCriteria::class));

        $shopRepository->pushCriteria(app(SearchRequestCriteria::class));

        $data = $shopRepository->withSellAmount($params['fieldOptions'])->all();

        return $data;
    }

    /**
     * 表名
     * @return mixed
     */
    public function fileName()
    {
        return '店铺营业额统计';
    }
}