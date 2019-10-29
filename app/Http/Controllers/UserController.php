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
            
        //Recuperar los datos enviados por el usuario por POST
       //voy a recibir un unico objeto json, con varios campos dentro
       //agrego el param 'null' por si no llega json, entonces x default vale nulo
       $json = $request->input('json',null);
       
       $params = json_decode($json); //Objeto json
       $params_array = json_decode($json, true); //Array json
       
       if (!empty($params) && !empty($params_array)){
        
            //Limpiar Datos
           $params_array = array_map('trim', $params_array);
           
           //Validar Datos que mande por json
           //este objeto $validate va a tener distintos metodos propios para verificar las validaciones que 
           //le seteo
           $validate = \Validator::make($params_array,[
              
                   'name'     => 'required|alpha',
                   'surname'  => 'required|alpha',
                   'email'    => 'required|email',
                   'password' => 'required',
                  
            ]);
           
           //Verifico validaciones
           if($validate->fails()){
              //Validacion fallida 
              //array que voy a devolver
               $data = array(
                   'status' =>  'error',
                   'code'   =>  404,
                   'msj'    =>  'El usuario NO se ha creado',
                   'error'  =>  $validate->errors()
                       
               );   
           }else{
               
               //Validacion pasada correctamente
                $data = array(
                   'status' =>  'exito',
                   'code'   =>  200,
                   'msj'    =>  'El usuario se ha creado correctamente'
                );
               
           }
               
           
       }else{ //datos nulos/incorrectos
            $data = array(
                   'status' =>  'error',
                   'code'   =>  404,
                   'msj'    =>  'Los datos enviados desde Front no son correctos'
                );
       }
       
       
       
       //Cifrar la contraseña
       
       //Comprobar si el usuario ya existe (duplicado)
       
       //Crear Usuario
       
       //devuelvo array el cual lo convierto a json
       return response()->json($data, $data['code']);
   }
   
   public function login(request $request){
       
       $name = $request->input('name');
       $surname = $request->input('surname');
  
       return "Accion de login de usuarios: $name $surname ";
   }
   
   
   
   
}
