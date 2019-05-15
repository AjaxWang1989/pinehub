<?php

namespace App\Presenters;

use App\Transformers\WechatMenuTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class WechatMenuPresenter.
 *
 * @package namespace App\Presenters;
 */
class WechatMenuPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return new WechatMenuTransformer();
    }
}
