<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{   
    // 一気に三つのカラムを同時に入力保存できるようにしている　$fillable変数
    protected $fillable = ['user_id', 'url', 'comment'];
    
    // MovieモデルがUserモデルに所属しているということを明示している
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
