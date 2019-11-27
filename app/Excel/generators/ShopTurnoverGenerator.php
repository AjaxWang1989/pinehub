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
            ['key' => 'shopName', 'desc' => '店铺名称', 'width' => 20, 'type' => DataType::TYPE_STRING],
            ['key' => 'shopKeeperName', 'desc' => '店铺主姓名', 'width' => 30, 'type' => DataType::TYPE_STRING],
            ['key' => 'shopKeeperMobile', 'desc' => '店铺主手机号', 'width' => 30, 'type' => DataType::TYPE_STRING],
            ['key' => 'shopNo', 'desc' => '店铺编号', 'width' => 20, 'type' => DataType::TYPE_STRING],
            ['key' => 'shopAddress', 'desc' => '店铺地址', 'width' => 40, 'type' => DataType::TYPE_STRING],
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

    public function getShopKeeperName(Shop $shop)
    {
        return $shop->shopManager ? ($shop->shopManager->realName ?? $shop->shopManager->nickname) : "未找到ID为{$shop->id}店铺的店铺主";
    }

    public function getShopKeeperMobile(Shop $shop)
    {
        return $shop->shopManager ? $shop->shopManager->mobile : "未找到ID为{$shop->id}店铺的店铺主";
    }

    public function getShopAddress(Shop $shop)
    {
        return $shop->address;
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

        $data = $shopRepository->with(['shopManager'])->withSellAmount($params['fieldOptions'])->all();

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