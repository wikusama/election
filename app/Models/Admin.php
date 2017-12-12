<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;

class Admin extends Model
{
    use SyncableGraphNodeTrait;

    protected $fillable = [
        'id', 'name'
    ];
}
