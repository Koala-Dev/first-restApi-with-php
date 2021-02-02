<?php

require_once 'model/user.class.php';
require_once 'model/groups.class.php';
require_once 'model/items.class.php';

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');



class Rest 
{
    public static function open ($requisicao) 
    {
        $url = explode('/', $_REQUEST['url']);
 
        $classe = ucfirst($url[0]);
        array_shift($url);

        $metodo = $url[0];
        array_shift($url);

        $parametros = array();
        $parametros = $url;

        if(class_exists($classe)){
            if(method_exists($classe, $metodo)) {
                $retorno = call_user_func_array(array(new $classe, $metodo), $parametros);
                return json_encode(array(
                    'status'=> 'sucesso',
                    'dados' => $retorno
                ));
            } else {
                return json_encode(array('status'=> 'erro', 'dados' => "Método inexistente"));
            }
        } else {
            return json_encode(array('status'=> 'erro', 'dados' => 'Classe inexistente'));
        }
    }
}

if(isset($_REQUEST)) {
    echo Rest::open($_REQUEST);
}