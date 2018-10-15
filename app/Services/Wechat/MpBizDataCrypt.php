<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/12
 * Time: 10:01
 */

namespace App\Services\Wechat;


use App\Services\AppManager;

class MpBizDataCrypt
{
    private $app;
    private $sessionKey;

    const OK = 0;
    const ILLEGAL_AESKEY = -41001;
    const ILLEGAL_IV = -41002;
    const ILLEGAL_BUFFER = -41003;
    const DECODE_BASE64_ERROR = -41004;

    /**
     * 构造函数
     * @param $sessionKey string 用户在小程序登录后获取的会话密钥
     * @param $app AppManager
     */
    public function __construct( $app, $sessionKey)
    {
        $this->sessionKey = $sessionKey;
        $this->app = $app;
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return array 成功0，失败返回对应的错误码
     */
    public function decryptData( $encryptedData, $iv )
    {
        if (strlen($this->sessionKey) != 24) {
            return [self::ILLEGAL_AESKEY, null];
        }
        $aesKey=base64_decode($this->sessionKey);


        if (strlen($iv) != 24) {
            return [self::ILLEGAL_IV, null];
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return [self::ILLEGAL_BUFFER, null];
        }
        if($this->app->miniProgram && $dataObj->watermark->appid != $this->app->miniProgram->appId )
        {
            return [self::ILLEGAL_BUFFER, null];
        }
        $data = json_decode($result, true);
        $data['session_key'] = $this->sessionKey;
        $data['app_id'] = $this->app->id;
        return [self::OK, $data];
    }
}