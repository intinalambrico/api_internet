<?php

require_once("src/connections/Connections.php");

Class Cus {

	

	/*
		funcion que realiza la busqueda con el cus, para traer deudas y clientes
	*/
	public function buscarCus($cus){
		/*
			creamos exception para validar consultas
		*/
		try{

		/*
			Instanciamos la clase Connections la cual hace la conexión a la base de datos
		*/

		$conn =    Connections::Connectar();
		/*
			la consulta trae informacion tales como razon_social, nombre_cliente, parcial, total
		*/
		$stm	=	$conn->prepare("SELECT 
			 
			clientes.razon_social, 
			concat(clientes.nombre_primer,' ',clientes.nombre_segundo,' ',clientes.apellido_paterno,' ',clientes.apellido_materno) as nombre_cliente,
			SUM(deudas.valor_parcial) as parcial, 
			SUM(deudas.valor_total) as total 
			FROM deudas 
			INNER JOIN clientes on clientes.id_cliente = deudas.id_cliente

		  	WHERE deudas.id_contrato = :cus AND deudas.factura > 0 AND deudas.estado IN (1,3)  GROUP BY deudas.id_contrato");
		/*
			se debe validar el serial :cus
		*/
			$stm->bindParam(":cus" , $cus , PDO::PARAM_INT);
		/*
			ejecutamos la consulta con el comando execute()
		*/
		$stm->execute();
		/*
			validamos que la consulta haya traido mas de 1 arreglo
		*/
			if ($stm->rowCount() > 0) {
				/*
					si existe mas de un resultado retornamos el arreglo fetch
				*/
					return $stm->fetch(PDO::FETCH_ASSOC);
			}else{
				/*
					en caso que no hayan mas resultado superior a 0 retornamos false
				*/
					return false;
			}
		}catch(Exception $e){
			/*
				Retornamos false, en caso que exista un error en el codigo anterior
			*/
				return false;
		}

		
			 
	}



}


?>