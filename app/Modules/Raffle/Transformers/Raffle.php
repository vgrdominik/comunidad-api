<?php

namespace App\Modules\Raffle\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Raffle\Domain\Raffle as RaffleModel;

class Raffle extends BaseTransformer
{

    /**
     * The resource instance.
     *
     * @var mixed|RaffleModel
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
            'status'  => $this->status,
            'photo'   => $this->photo,
            'creator' => new BaseTransformer($this->creator),
        ];
    }
}
