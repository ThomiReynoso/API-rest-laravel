<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; //Importo Modelo Usuario para crear un objeto de este tipo

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
                   'email'    => 'required|email|unique:users', //Comprobar si el usuario ya existe (duplicado)
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

                //Cifrar la contraseña
                //$pwd = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4 ]);
                
                //uso este algo para que siempre cifre de la misma forma la pw
                $pwd = hash('sha256', $params->password);
               
                //Crear Usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->role = 'ROLE_USER';


               //Guardar Usuario
                $user->save();
               

                $data = array(
                   'status' =>  'exito',
                   'code'   =>  200,
                   'msj'    =>  'El usuario se ha creado correctamente',
                   'user'   =>  $user //devuelvo tambien, el objeto entero creado (por json a la vista)
                );
               
           }
               
           
       }else{ //datos nulos/incorrectos
            $data = array(
                   'status' =>  'error',
                   'code'   =>  404,
                   'msj'    =>  'Los datos enviados desde Front no son correctos'
                );
       }
       
      
       
       //devuelvo array el cual lo convierto a json
       return response()->json($data, $data['code']);
   }
   
   public function login(request $request){
       
       $jwtAuth = new \JwtAuth(); 
      
       
       //Recibir datos por POST
       $json = $request->input('json',null);
       
       $params = json_decode($json); //Objeto json
       $params_array = json_decode($json, true); //Array json. el 'true' era para que se guarde en forma de array

       //Validar esos datos 
        $validate = \Validator::make($params_array,[
              
                   'email'    => 'required|email', //Comprobar si el usuario ya existe (duplicado)
                   'password' => 'required',
                  
            ]);
           
        //Verifico validaciones
        if($validate->fails()){
           //Validacion fallida 
           //array que voy a devolver
            $signup = array(
                'status' =>  'error',
                'code'   =>  404,
                'msj'    =>  'El usuario NO se ha podido loguear',
                'error'  =>  $validate->errors()

            );   
        }else{
       
            //Cifrar la pw
            //$pwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4 ]); //el problema de usar esa func, es que NUNCA se cifra de la misma forma
            $pwd = hash('sha256', $params->password);
            
            if(empty($params->getToken)){
                //Devolver token 
                $signup = $jwtAuth->signup($params->email, $pwd);
                
            } else {//devolver datos JSON
            
                $signup = $jwtAuth->signup($params->email, $pwd, true);
                
            }       
            
        }
       

       //devuelvo un objeto json
       return response()->json($signup,200);
   }
   
   //metodo para actualizar datos del usuario
   public function update(request $request) {
       //recojo cabecera del token
       
       $token = $request->header('Authorization');
       $jwtAuth = new \JwtAuth(); //lo instancio por el Alias
       
       $checkToken = $jwtAuth->checkToken($token);
       
       if($checkToken){
           echo "Login CORRECTO";
       } else {
           echo "Login INCORRECTO";
       }
       
       die();
   }
   
   
}
