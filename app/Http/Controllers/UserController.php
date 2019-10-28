<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
   //le mando el objeto request para que pueda recibir datos 
   //que le lleguen desde la peticion correspondiente () 
   public function pruebas(request $request){
       return "Accion de pruebas de USER-CONTROLLER";
   }
 
   public function register(request $request){
            
       return "Accion de registro de usuarios: ";
   }
   
   public function login(request $request){
       
       $name = $request->input('name');
       $surname = $request->input('surname');
  
       return "Accion de login de usuarios: $name $surname ";
   }
   
   
   
   
}
