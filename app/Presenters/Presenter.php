<?php

namespace App\Presenters;

use App\Transformers\Transformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class Presenter.
 *
 * @package namespace App\Presenters;
 */
class Presenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new Transformer();
    }
}
