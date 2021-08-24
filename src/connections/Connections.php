<?php

class Connections extends PDO{

	 

	public function Connectar(){
		
		$server	=	'mysql:host=localhost; dbname=controlmas';
		 
		$password	= '9C9UAaqKecHRZA79';
		$username	= 'LNWW(345';
	

		try {
			
			$conn = new PDO($server, $username , $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return $conn;

		} catch (PDOException $e) {
			echo 'Fallo la Conexión: '. $e->getMessage();
		}
	



}


}



?>