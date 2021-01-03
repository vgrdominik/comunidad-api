<?php


namespace App\Modules\Raffle\Infrastructure\Controller;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Raffle\Domain\Raffle;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Raffle';
    }

    public function uploadPhoto(Raffle $raffle)
    {
        $transformerClass = $this->getTransformerClass();
        $request = request();

        $validation = Validator::make($request->all(), [
            'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if($validation->passes())
        {
            $image = $request->file('select_file');
            $new_name = rand() . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('raffles'), $new_name);

            $raffle->photo = '/raffles/' . $new_name;
            $raffle->save();

            return response()->json(new $transformerClass($raffle));
        } else {
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     * @throws
     */
    public function store()
    {
        $modelClass = $this->getModelClass();
        $transformerClass = $this->getTransformerClass();
        /** @var BaseDomain $model */
        $model = new $modelClass();
        $validator = Validator::make(request()->all(), $model->getValidationContext());

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $model = new $modelClass(request()->all());
        $model->photo = '';
        $model->save();

        return response()->json(new $transformerClass($model));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws
     */
    public function update($id)
    {
        $transformerClass = $this->getTransformerClass();
        /** @var BaseDomain $model */
        $model = ($this->getModelClass())::findOrFail($id);
        $validator = Validator::make(request()->all(), $model->getValidationContext());

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $model->update(request()->all());

        return response()->json(new $transformerClass($model));
    }
}
