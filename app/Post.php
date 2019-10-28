<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    
    //Relacion de MUCHOS a 1. (Muchos Posts pueden ser creados por UN usr)
    public function user(){
      //uso el $this para acceder al modelo
       return $this->belongsTo('App\User', 'user_id');
    }
    
    //para traer todos los post relacionados a una categoria
    public function category(){
        return $this->belongsTo('\App\Category', 'category_id');
    }

}
