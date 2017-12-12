<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;

class Member extends Model
{
    use SyncableGraphNodeTrait;

    protected $fillable = [
        'id', 'name', 'administrator', 'voted_at'
    ];

    public function voted(){
        return $this->belongsTo('App\Models\Candidate', 'voted_at', 'id');
    }
}
