<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 15:44
 */

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Traits\ModelAttributesAccess;

/**
 * App\Entities\StorePurchaseOrders
 *
 * @property int $id
 * @property string $code 订单编号
 * @property string|null $openId 微信open id或支付宝user ID
 * @property string|null $wechatAppId 维系app id
 * @property string|null $aliAppId 支付宝app id
 * @property string|null $appId 系统app id
 * @property int|null $shopId 店铺id
 * @property int|null $merchandiseNum 此订单商品总数量
 * @property float $totalAmount 应付款
 * @property float $paymentAmount 实际付款
 * @property float $discountAmount 优惠价格
 * @property \Carbon\Carbon|null $paidAt 支付时间
 * @property string $payType 支付方式默认微信支付
 * @property int $status 订单状态：1-待发货 2-配送中 3-已完成 4-申请中 5-退货中 6-已拒绝
 * @property int $cancellation 取消人 0未取消 1买家取消 2 卖家取消  3系统自动取消
 * @property \Carbon\Carbon|null $signedAt 签收时间
 * @property string|null $receiverCity 收货城市
 * @property string|null $receiverDistrict 收货人所在城市区县
 * * @property string|null $receiverName 收货人姓名
 * @property string|null $receiverAddress 收货地址
 * @property string|null $receiverMobile 收货人电话
 * @property string|null $sendTime 配送时间
 * @property string|null $comment 配送时间
 * @property \Carbon\Carbon|null $consignedAt 发货时间
 * @property int $type 订单类型：1-进货订单 2-退货订单
 * @property int $postType 0-无需物流，1000 - 未知运输方式 2000-空运， 3000-公路， 4000-铁路， 5000-高铁， 6000-海运
 * @property int $scoreSettle 积分是否已经结算
 * @property string|null $postNo 快递编号
 * @property string|null $postCode 邮编
 * @property string|null $postName 快递公司名称
 * @property string|null $transactionId 支付交易流水
 * @property string|null $ip 支付终端ip地址
 * @property string|null $tradeStatus 交易状态:TRADE_WAIT 等待交易 TRADE_FAILED 交易失败 TRADE_SUCCESS 交易成功
 *                 TRADE_FINISHED 交易结束禁止退款操作 TRADE_CANCEL 交易关闭禁止继续支付
 * @property \Carbon\Carbon|null $createdAt
 * @property \Carbon\Carbon|null $updatedAt
 * @property string|null $deletedAt
 * @property-read \App\Entities\Customer|null $customer
 * @property-read \App\Entities\Member|null $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItem[] $orderItems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereAliAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereConsignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereReceiverDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereScoreSettle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereShopId($shopId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereTradeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Order whereWechatAppId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderItemMerchandise[] $orderItemMerchandises
 */


class StorePurchaseOrders extends Model implements Transformable
{
    use TransformableTrait, ModelAttributesAccess;

    const CANCEL = 1;
    const WAIT = 2;
    const MAKE_SURE = 3;
    const PAID = 4;
    const SEND = 5;
    const COMPLETED = 6;

    const EXPIRES_SECOND = 600;

    const VIRTRUAL_MERCHANDISE = 0;
    const REAL_MERCHANDISE = 1;

    protected $dates = [
        'signed_at',
        'consigned_at',
        'paid_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code','open_id','wechat_app_id','ali_app_id','app_id','shop_id','merchandise_num','total_amount','payment_amount',
        'discount_amount','paid_at','pay_type','status','cancellation','signed_at','receiver_city','receiver_district','receiver_name',
        'receiver_address','receiver_mobile','send_time','comment','consigned_at','type','post_type','score_settle','post_no','post_code',
        'post_name','transaction_id','ip','trade_status'
    ];

    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderPurchaseItems::class, 'order_id', 'id');
    }

    public function buildAliAggregatePaymentOrder() {
        $now = Carbon::now();
        $expire = $now->addSeconds(self::EXPIRES_SECOND);
        $request = app('request');
        $clientIp = $request->getClientIp();
        return [
            'body'    => 'ali qr pay',
            'subject'    => '支付宝扫码支付',
            'order_no'    => $this->code,
            'timeout_express' => $expire->timestamp,// 表示必须 600s 内付款
            'amount'    => $this->paymentAmount,// 单位为元 ,最小为0.01
            'client_ip' => $clientIp,// 客户地址
            'goods_type' => self::REAL_MERCHANDISE,// 0—虚拟类商品，1—实物类商品
            'store_id' => '',
            'operator_id' => '',
            'terminal_id' => '',// 终端设备号(门店号或收银设备ID) 默认值 web
            'buyer_id' => $this->openId
        ];
    }

    public function buildWechatWapPaymentOrder(){
        $now = Carbon::now();
        $expire = $now->addSeconds(self::EXPIRES_SECOND);
        $clientIp = app('request')->getClientIp();
        return [
            'body'    => 'PineHub offline scan qrcode pay',
            //'subject'    => '微信扫码支付',
            'order_no'    => $this->code,
            'timeout_express' => $expire->timestamp,// 表示必须 600s 内付款
            'amount'    => $this->paymentAmount,// 微信沙箱模式，需要金额固定为3.01
            'return_param' => '123',
            'client_ip' => $clientIp,// 客户地址
            // 如果是服务商，请提供以下参数
            'sub_appid' => '',//微信分配的子商户公众账号ID
            'sub_mch_id' => '',// 微信支付分配的子商户号
        ];
    }

    public function buildWechatAggregatePaymentOrder() {
        $now = Carbon::now();
        $expire = $now->addSeconds(self::EXPIRES_SECOND);
        $request = app('request');
        $clientIp = $request->getClientIp();
        return [
            'body'    => 'PineHub offline scan qrcode pay',
            'subject'    => '线下扫码支付',
            'order_no'    => $this->code,
            'timeout_express' => $expire->timestamp,// 表示必须 600s 内付款
            'amount'    => $this->paymentAmount,// 微信沙箱模式，需要金额固定为3.01
            'return_param' => base64_encode(json_encode([
                'id' => $this->id,
                'order_no' => $this->code
            ])),
            'client_ip' => $clientIp,// 客户地址
            'openid' => $this->openId,
        ];
    }

}