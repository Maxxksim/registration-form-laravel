<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable('first_name', 'last_name', 'birthday', 'report_subject', 'country', 'phone', 'email')]
class Member extends Model
{
    //
}
