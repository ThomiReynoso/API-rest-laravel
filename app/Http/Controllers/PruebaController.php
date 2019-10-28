<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category; //necesito agregar los modelos que voy a consultar
use App\Post;

class PruebaController extends Controller
{
    public function index(){
        $animales = ['Perro', 'Gato', 'Raton'];
        $titulo = 'Listado de animales';
        
        return view('prueba.index', array(
            'titulo' => $titulo,
            'animales' => $animales
        ));
    }
    
    
    public function testOrm() {
        
      /*es como un select * from Post
        devuelve un objeto tipo elocuent "     */
      /*  $posts = Post::all();
        
       * //voy recorriendo y mostrando los distintos posts
        foreach( $posts as $post){
            echo "<h1>".$post->title."</h1>";
            //accedo a los datos relacionados
            //muestro que usuario lo hizo y en que categoria esta el post
            echo "<span style='color:blue;'>{$post->user->name} - {$post->category->name} </span >";
            echo "<p>".$post->content."</p>";
            echo "<hr>";
        }
        */
        
        $categories = Category::all();
        foreach( $categories as $category){
            echo "<h1>".$category->name."</h1>";
            
            //recorro las categorias y muestro que post tiene asociados y usuarios
            foreach( $category->posts as $post){
                echo "<h3>".$post->title."</h3>";
                //accedo a los datos relacionados
                //muestro que usuario lo hizo y en que categoria esta el post
                echo "<span style='color:blue;'>{$post->user->name} - {$post->category->name} </span >";
                echo "<p>".$post->content."</p>";
                
            }
            
            echo "<hr>";
        }
        

                
        die(); //para que no me pida ninguna vista y corte la ejecucion
    }
}