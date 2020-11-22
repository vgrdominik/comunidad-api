<?php
namespace App\Modules\Payment\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Descriptive;

class Payment extends BaseDomain
{
    use Descriptive;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'description' => ['required', 'string', 'min:4', 'max:255'],
        'status' => ['required', 'string', 'min:4', 'max:25'],
    ];

    protected $fillable = ['description', 'details', 'creator_id', 'status'];

    // RELATIONS

    public function creator()
    {
        return $this->belongsTo('App\Modules\User\Domain\User', 'creator_id');
    }

    // GETTERS

    public function getValidationContext(): array
    {
        return self::VALIDATION_COTNEXT;
    }

    public function getIcon(): string
    {
        return 'calendar-day';
    }

    // Others

    public function remove(): bool
    {
        return $this->delete();
    }
}
