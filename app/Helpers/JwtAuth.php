<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB; //libreria de BD, para llamarla y consultar con QueryBuilder
use App\User;   //para trabajar con el ORM y consultar datos a esa clase/tabla

//El helper es como un servicio
class JwtAuth{

    public $key;

    
    public function __construct() {
        $this->key = 'esto_es_una_clave_supersecreta-14121995';
        
    }
    
   
    public function signup($email, $password, $getToken = null ) {

        //Buscar si existe el usuario con sus credenciales 
        //metodo where es del ORM, puedo buscar "first", "all", entre otros
        $user = User::where([
            'email'     => $email,
            'password'  => $password 
        ])->first();
        
        
        //Comprobar si son correctas (si es objeto)
        $signup = false;
        if(is_object($user)) $signup = true;
        
        
        //Generar el token con los datos del usuario identificado
        if($signup){
            
            $token = array(
                'sub'       => $user->id, //se suele mencionar con 'sub' el 'id'
                'email'     => $user->email,
                'name'      => $user->name,
                'surname'   => $user->surname,
                'iat'       => time(), //creacion del token
                'exp'   => time() + (7 * 24 * 60 * 60), //cuando termina el token
            );

            //codifico el token, le indico el token, la clave que SOLO YO SE, y el alg de codif
            $jwt  = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256'] );
            
            //Devolver los datos decodificados o el token, en funcion de un parametro
            if (is_null($getToken)) {
               //devuelvo el token codificado 
                $data = $jwt;
            } else {
                //devuelvo el token decodificado (puro)
                $data = $decoded;
            }
            
        } else { //se produjo un error
            $data = array(
                'status'    => 'error',
                'message'   => 'Login incorrecto'
            );
        }
        

        return $data;
    
    }
    
    
   public function checkToken($jwt, $getIdentity = false){
        
       $auth = false;
       
       try {  
           $jwt = str_replace('"', '', $jwt);
           //Este metodo es muy susceptible a fallos, por eso el ttry catch
           $decoded = JWT::decode($jwt, $this->key, ['HS256']);
           
       } catch (\UnexpectedValueException $e) {
           $auth = false;
       } catch (\DomainException $e){
           $auth = false;
       }
       
       if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
           $auth = true;
       } else {
           $auth = false;
       }
       
       if($getIdentity){
           return $decoded; //devuelvo objeto json
       }
       
       
       return $auth;
   }

    
}