<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Class_;

class Learn extends Model
{
    //
    protected $connection = 'mysql';
    public $incrementing = false;
    public function learnCon()
    {
        return $this->hasOne(LearnCon::Class);
    }
}
