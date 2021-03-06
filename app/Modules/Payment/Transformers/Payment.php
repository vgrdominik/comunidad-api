<?php

namespace App\Modules\Payment\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Payment\Domain\Payment as PaymentModel;

class Payment extends BaseTransformer
{

    /**
     * The resource instance.
     *
     * @var mixed|PaymentModel
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->merge(parent::toArray($request)),
            'status' => $this->status,
            'creator' => new BaseTransformer($this->creator),
        ];
    }
}
