<?php

namespace App\Presenters;

use App\Transformers\WechatMenuTransformer;
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
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new WechatMenuTransformer();
    }
}
