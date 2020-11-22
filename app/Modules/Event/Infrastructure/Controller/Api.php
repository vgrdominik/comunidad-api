<?php


namespace App\Modules\Event\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use Illuminate\Http\JsonResponse;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Event';
    }

    /**
     * Display a listing of own resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(($this->getTransformerClass())::collection(($this->getModelClass())::where('creator_id', auth()->user()->id)->orWhere('destinator_id', auth()->user()->id)->orderBy('created_at', 'desc')->get()));
    }
}
