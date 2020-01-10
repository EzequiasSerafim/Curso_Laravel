<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller {

    public function pruebas(Request $request) {
        return " Prueba CONTROLLER-USER ";
    }

    public function register(Request $request) {

        //Recoger los datos del usuario por POST
        $json = $request->input('json', null);

        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); // array

        if (!empty($params) && !empty($params_array)) {
            //Limpiar los datos
            $params_array = array_map('trim', $params_array);


            //Validar datos
            $validate = \Validator::make($params_array, [
                        'name' => 'required|alpha',
                        'surname' => 'required|alpha',
                        'email' => 'required|email|unique:users', //|unique| = Comprobar si el usuario existe ya (duplicado)
                        'password' => 'required'
            ]);



            if ($validate->fails()) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El usuario no se ha creado',
                    'errors' => $validate->errors()
                );
            } else {
                // Validacion pasada correctamente?
                //Cifrar la contrasena
                $pwd = hash('sha256', $params->password);

                //Crear el usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->role = "ROLE_USER";

                // Guardar el usuario
                $user->save();

                $data = array(
                    'status' => 'succes',
                    'code' => 200,
                    'message' => 'El usuario se ha creado correctamente',
                    'user' => $user
                );
            };
        } else {
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviados no son correctos'
            );
        }




        return response()->json($data, $data['code']);
    }

    public function Login(Request $request) {
        $jwtAuth = new \JwtAuth();

        // Recibir datos por POST.
        $json = $request->input('json', null);

        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); // array
        // Validar esos Datos
        $validate = \Validator::make($params_array, [
                    'email' => 'required|email', //|unique| = Comprobar si el usuario existe ya (duplicado)
                    'password' => 'required'
        ]);

        if ($validate->fails()) {
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Login incorrecto',
                'errors' => $validate->errors()
            );
        } else {
            // Cifrar la contraseña
            $pwd = hash('sha256', $params->password);
            // Devolver token o datos

            $signup = $jwtAuth->signup($params->email, $pwd);
            
            if (!empty($params->gettoken)){
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }
        return response()->json($signup);
    }
    
    public function checkToken($jwt, $getIdentily = false){
        $auth = false;                
    }

}
