<?php


require_once("src/connections/Connections.php");


class Cliente {

	private $apellidoPaterno;
	private $apellidoMaterno;
	private $nombrePrimer;
	private $nombreSegundo;
	private $documento;
	private $razonSocial;
	private $tipoCliente;
	private $celularA;
	private $celularB;
	private $mail;
	private $idContrato;
	private $estado;
	private $fisico;
	private $grupo;
	private $estrato;

	function __construct($apellidoMaterno = null, $apellidoPaterno = null, $nombrePrimer=null, $nombreSegundo=null,$documento=null, $razonSocial = null, $tipoCliente=null,$celularA=null, $celularB=null, $mail=null,$idContrato=null,$estado=null,$fisico=null,$grupo=null,$estrato=null){

		$this->$apellidoPaterno	= $apellidoPaterno;
	$this->$apellidoMaterno 	= $apellidoMaterno;
	$this->$nombrePrimer 		= $nombrePrimer;
	$this->$nombreSegundo 		= $nombreSegundo;
	$this->$documento 			= $documento;
	$this->$razonSocial 		= $razonSocial;
	$this->$tipoCliente 		= $tipoCliente;
	$this->$celularA 			= $celularA;
	$this->$celularB			= $celularB;
	$this->$mail 				= $mail;
	$this->$idContrato 			= $idContrato;
	$this->$estado 				= $estado;
	$this->$fisico   			= $fisico;
	$this->$grupo 				= $grupo;
	$this->$estrato 			= $estrato;
	$this->servicio 			= $servicio;

	}
/**Funcion para consultar cliente*/

	public function consultarCliente($documento){
		$conn 	= Connections::Connectar();
		$stm 	= $conn->prepare("SELECT clientes.id_cliente,clientes.apellido_paterno, clientes.apellido_materno, clientes.nombre_primer, clientes.nombre_segundo,
								clientes.documento, clientes.razon_social,clientes.tipo_cliente, clientes.mail, clientes.id_cliente FROM clientes WHERE clientes.documento = :documento LIMIT 0,1");
		$stm->bindParam(":documento" , $documento, PDO::PARAM_STR);
		$stm->execute();
		if ($stm->rowCount() > 0) {
			return $stm->fetch(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
	}
/*funcion para buscar contratos*/

	public function consultarContratos($idCliente){
		$conn =  Connections::Connectar();
		$stm	= $conn->prepare("SELECT 
								contratos.id_contrato,
								servicios.nombre as filial,

								CASE 

									WHEN contratos.estado = '0' THEN 'Creado'
									WHEN contratos.estado = '1' THEN 'Activo'
									WHEN contratos.estado = '2' THEN 'Cortado'
									WHEN contratos.estado = '3' THEN 'Anulado'
									WHEN contratos.estado = '4' THEN 'Retirado'

								END as estado,


								contratos.fisico,contratos.grupo,contratos.estrato FROM contratos
 
									inner join servicios on servicios.id_servicio = contratos.id_servicio
									WHERE contratos.id_cliente = :idCliente AND contratos.id_servicio IN(1,2,3,4,5,6,7,8,9)  ");

	$stm->bindParam(":idCliente" , $idCliente , PDO::PARAM_INT);
	$stm->execute();
	if ($stm->rowCount() > 0) {
		return $stm->fetchAll(PDO::FETCH_ASSOC);

	}else{
		return false;
	}

	}
}


?>

