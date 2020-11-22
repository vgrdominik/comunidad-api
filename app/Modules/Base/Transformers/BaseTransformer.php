<?php

namespace App\Modules\Base\Transformers;

use App\Modules\Base\Domain\BaseDomain;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseTransformer extends JsonResource
{

    /**
     * The resource instance.
     *
     * @var mixed|BaseDomain
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
            'created_at' => $this->created_at,
            'description' => $this->readable,
            'id' => $this->id,
            'icon' => $this->getIcon(),
            'updated_at' => $this->updated_at,
        ];
    }
}
