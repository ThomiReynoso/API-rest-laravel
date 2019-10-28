<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Elocuent es el ORM de Laravel - Es un mapeo con la BDD (como Hibernate)
class Category extends Model
{
    protected $table = 'categories';
    
    //Relacion 1 a MUCHOS
    public function posts(){
      //uso el $this para acceder al modelo
       return $this->hasMany('App\Post');
    }
}
