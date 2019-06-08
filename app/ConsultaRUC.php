<?php

namespace App;

class ConsultaRUC
{
    protected static $ruta = "https://ruc.com.pe/api/beta/ruc";
    protected static $token = "27ccbf03-304a-401d-8faf-f1ee03f9ff00-e29ab79f-1dac-4bd0-ac8c-18a5438148ef";

    public static function consultar($ruc)
    {
        $data = array(
            "token"	=> self::$token,
            "ruc"   => $ruc
        );

        $data_json = json_encode($data);

        // Invocamos el servicio a ruc.com.pe
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$ruta);
        curl_setopt(
        	$ch, CURLOPT_HTTPHEADER, array(
        	'Authorization: Token token="'.self::$token.'"',
        	'Content-Type: application/json',
        	)
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        $leer_respuesta = json_decode($respuesta, true);

        return $leer_respuesta['entity'];
    }
}
