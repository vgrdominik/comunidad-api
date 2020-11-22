<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\User\Domain\User as BaseUser;
use Illuminate\Notifications\Notifiable;

class User extends BaseUser
{
}
