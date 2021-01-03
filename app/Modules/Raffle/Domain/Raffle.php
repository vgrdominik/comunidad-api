<?php
namespace App\Modules\Raffle\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Descriptive;
use App\Modules\Base\Traits\Photo;

class Raffle extends BaseDomain
{
    use Descriptive, Photo;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'description' => ['required', 'string', 'min:4', 'max:255'],
    ];

    protected $fillable = ['description', 'details', 'creator_id', 'photo'];

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
