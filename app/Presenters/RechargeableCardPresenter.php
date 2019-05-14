<?php

namespace App\Presenters;

use App\Transformers\RechargeableCardTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RechargeableCardPresenter.
 *
 * @package namespace App\Presenters;
 */
class RechargeableCardPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return RechargeableCardTransformer
     */
    public function getTransformer()
    {
        return new RechargeableCardTransformer();
    }
}
