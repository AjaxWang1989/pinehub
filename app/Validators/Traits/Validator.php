<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/4/18
 * Time: 下午3:10
 */
namespace App\Validators\Traits;

use Illuminate\Validation\ValidationException;
trait Validator{
    /**
     * Pass the data and the rules to the validator or throws ValidatorException
     *
     * @param string $action
     * @return mixed
     * @throws ValidationException
     */
    public function passesOrFail($action = null)
    {
        return $this->passes($action);
    }

    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return bool
     * @throws ValidationException
     */
    public function passes($action = null)
    {
        $rules      = $this->getRules($action);
        $messages   = $this->getMessages();
        $attributes = $this->getAttributes();
        $validator  = $this->validator->make($this->data, $rules, $messages, $attributes);

        return $validator->validate();
    }
}