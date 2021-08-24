<?php
//hannil solutions
/*
#version:1.0
Fecha: 21/08/2021
*/
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("HTTP/1.1 200 OK");
header("Content-type:application/json; charset=utf-8");
header("Content-autor:Creativos de Colombia");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");
header("Allow: POST");
/**Hannil-Facturas
	https://emn178.github.io/online-tools/sha256.html
*/
@$token_api="0129cbf5900f0ba08c4c957ebb388cd8ac4737247392650daa4cce898eeeccfe";
$validacion = 0 ;
/*
	creamos el array que se adjunta los valores enviados
*/
$response = array();
/*

la version del api esta en construcción para poder realizar varias consultas
*/

/*
	consultas donde los request method sean por POST
*/
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		/*
			validamos el caption enviado sea = a cus
		*/
			if($_GET["caption"] == "cus"){
				/*
				recibimos los parametros enviados por post el token y el cus, usando file_get_contents
				*/
				$body_form 	=	file_get_contents("php://input");
				/*
					decodificando el json recibio y pasado a un array
				*/
				$content 	= 	json_decode($body_form , true);
				/*
				los parametros recibidos por POST token , cus
				*/
				$cus 	= 	(int)$content['cus'];				 
				$token 	= 	$content['token'];
				
				
				/*actualizamos la validacion para armar y enviar json*/

				$validacion = 1 ;
				/*
					creamos el array el cual sera codificado en json
				*/
				$return["estado"] = true;
				$return["version"] = "1.0";
				/*
					validamos que el token sean el correcto
				*/
					if($token == $token_api){
						/*al validar que el token enviado sea el correcto se procede a enviar la consulta a la clase Cus
							se importa la clase
						*/
							require_once("src/Cus.php");

							/**
								instanciamos la clase para enviar un el valor de cus y mes de servicio
							*/
								$busqueporCus = Cus::buscarCus($cus);
							/*
								validamos que el retorno sea diferente de false
							*/
								if($busqueporCus != false){
									/*
										respondemos la respuesta como true
									**/
									$return["respuesta"]	= true;
									/*
										depues de recibir la respuesta positiva se procede armar array para el json	
									*/
										$return["razon_social"]	=	$busqueporCus["razon_social"];
										$return["nombre_cliente"] 	= $busqueporCus["nombre_cliente"];
										/*
											restamos el al valor total el parcial
										*/
										$deuda = (double)$busqueporCus["total"] - (double)$busqueporCus["parcial"];
										/*
											resultado de la resta se agrega al array return
										*/
										$return["deuda"]	=	$deuda;


								}else{
									/*
										retornamos los errores necesarios para el json
										en caso que la consulta arroje un false
									*/
										$return["error"] = "sin registros";
										$return["respuesta"] = false;
								}


					}else{
						/*
							retorna error de token
						*/
							$return["error"] = "error de token";
							$return["respuesta"] = false;
					}

			}else{
				$validacion = 1;
				$return["error"] = "nombre variable";
				$return["respuesta"] = false;
			}

	/*
		armamos el json para enviar siempre y cuando el validador sea = 1
	*/
		if($validacion == 1){
			array_push($response, $return);
			echo json_encode($response);
		}

	}


	/*
		consultas donde los request method por GET
	*/

	if($_SERVER["REQUEST_METHOD"] == "GET"){

	}



/**
	sera enviadas por metodo el valor a consultar
*/



?>