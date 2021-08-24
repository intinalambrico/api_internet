<?php
//hannil solutions
/*
#version:1.0
Fecha: 21/07/2021
*/
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("HTTP/1.1 200 OK");
header("Content-type:application/json; charset=utf-8");
header("Content-autor:Creativos de Colombia");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");
header("Allow: POST");
require_once("src/Cliente.php");

@$key = "d3fc3547346f0ef9cc47b9d5951912559bda2322ed3a2794d0ae49f76110dc61";
$response = array();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	
	$documento	= $_POST["documento"];
	$key_solicitud 	= $_POST["token"];
	if($key != $key_solicitud){
			$response["status"]	 = "Error Token";
			$respuesta = json_encode($response);
			echo $respuesta;

	}else{
		
		$getCliente = prepararCliente($documento);
		$respuesta = json_encode($getCliente);
		echo $respuesta;
	}
}else{
	$response["status"] 	= "Error Method";
	$respuesta = json_encode($response);
	echo $respuesta;

}

function prepararCliente($documento){
	$respuesta = array();
	$getCliente	= Cliente::consultarCliente($documento);
	if($getCliente != false){
		$respuesta["id"]			=	$getCliente["id_cliente"];
		$respuesta["status"] 	 	= "OK";
		$respuesta["apellido_paterno"] = $getCliente["apellido_paterno"];
		$respuesta["apellido_materno"] = $getCliente["apellido_materno"];
		$respuesta["nombre_primer"] 	= $getCliente["nombre_primer"];
		$respuesta["nombre_segundo"] 	= $getCliente["nombre_segundo"];
		$respuesta["documento"]			= $getCliente["documento"];
		$respuesta["razon_social"] 		= $getCliente["razon_social"];
		$respuesta["tipo_cliente"] 		= $getCliente["tipo_cliente"];
		$respuesta["mail"] 				= $getCliente["mail"];
		$respuesta["contratos"]			= array();		
		//contratos del cliente
		$getContratos = Cliente::consultarContratos($getCliente["id_cliente"]);
		
		if($getContratos != false){

			foreach ($getContratos as $key) {
			 	$array_contratos = array(
					"id" 		=> $key["id_contrato"],
					"filial" 	=> $key["filial"],
					"estado"	=> $key["estado"],
					"fisico"	=> $key["fisico"],
					"grupo"		=> $key["grupo"],
					"estrato" 	=> $key["estrato"]
				);
				array_push($respuesta["contratos"] ,$array_contratos);
			 } 

		}else{
			$respuesta["contratos"] = null;
		}

	}else{
		$respuesta["status"] = "error";
	}

	return $respuesta;
}

?>