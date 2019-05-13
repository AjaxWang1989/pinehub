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
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RechargeableCardTransformer();
    }
}
