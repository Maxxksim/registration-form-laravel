<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable('first_name', 'last_name', 'birthdate', 'report_subject', 'country', 'phone', 'email', 'company', 'position', 'about_me', 'path_to_photo')]
class Member extends Model
{
    #[Scope]
    protected function visible(Builder $query): void
    {
        $query->where('is_visible', true);
    }
}
