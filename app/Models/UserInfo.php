<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserInfo extends Model
{
  protected $table = 'user_info';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id','age', 'image', 'birthday','email','level_id',
      'sex','identity_type','identity_no','user_description','deleted_at'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
