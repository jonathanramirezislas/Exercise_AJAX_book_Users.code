<?php

function buscarEstados($codigoPais) {
	$estados = array();

	switch($codigoPais)	{
		case 'BR':
			$estados[1] = 'Acre';
			$estados[]  = 'Alagoas';
			$estados[]  = 'Amapá';
			$estados[]  = 'Amazonas';
			$estados[]  = 'Bahía';
			$estados[]  = 'Ceará';
			$estados[]  = 'Espíritu Santo';
			$estados[]  = 'Goiás';
			$estados[]  = 'Marañao';
			$estados[]  = 'Mato Groso';
			$estados[]  = 'Mato Groso del Sur';
			$estados[]  = 'Minas Gerais';
			$estados[]  = 'Pará';
			$estados[]  = 'Paraíba';
			$estados[]  = 'Paraná';
			$estados[]  = 'Pernambuco';
			$estados[]  = 'Piauí';
			$estados[]  = 'Río de Janeiro';
			$estados[]  = 'Río Grande del Norte';
			$estados[]  = 'Río Grande del Sur';
			$estados[]  = 'Rondonia';
			$estados[]  = 'Roraima';
			$estados[]  = 'San Pablo';
			$estados[]  = 'Santa Catalina';
			$estados[]  = 'Sergipe';
			$estados[]  = 'Tocantins';
			$estados[]  = 'Distrito Federal';
			break;
		case 'US':
			$estados[1] = 'Alabama';
			$estados[]  = 'Alaska';
			$estados[]  = 'Arizona';
			$estados[]  = 'Arkansas';
			$estados[]  = 'California';
			$estados[]  = 'Colorado';
			$estados[]  = 'Connecticut';
			$estados[]  = 'Delaware';
			$estados[]  = 'Florida';
			$estados[]  = 'Georgia';
			$estados[]  = 'Hawaii';
			$estados[]  = 'Idaho';   
			$estados[]  = 'Illinois';
			$estados[]  = 'Indiana';
			$estados[]  = 'Iowa';
			$estados[]  = 'Kansas';
			$estados[]  = 'Kentucky'; 
			$estados[]  = 'Louisiana';
			$estados[]  = 'Maine';
			$estados[]  = 'Maryland';
			$estados[]  = 'Massachusetts';
			$estados[]  = 'Michigan';
			$estados[]  = 'Minnesota';
			$estados[]  = 'Mississippi';
			$estados[]  = 'Missouri';
			$estados[]  = 'Montana';
			$estados[]  = 'Nebraska';
			$estados[]  = 'Nevada';
			$estados[]  = 'New Hampshire';
			$estados[]  = 'New Jersey';
			$estados[]  = 'New Mexico';
			$estados[]  = 'New York';
			$estados[]  = 'North Carolina';
			$estados[]  = 'North Dakota';
			$estados[]  = 'Ohio';
			$estados[]  = 'Oklahoma ';
			$estados[]  = 'Oregon';
			$estados[]  = 'Pennsylvania';
			$estados[]  = 'Rhode Island';
			$estados[]  = 'South Carolina';
			$estados[]  = 'South Dakota';
			$estados[]  = 'Tennessee';
			$estados[]  = 'Texas';
			$estados[]  = 'Utah';
			$estados[]  = 'Vermont';
			$estados[]  = 'Virginia';
			$estados[]  = 'Washington';
			$estados[]  = 'West Virginia';
			$estados[]  = 'Wisconsin';
			$estados[]  = 'Wyoming';
			break;
	}

	$respuesta = new xajaxResponse();
	$respuesta->sEncoding = 'iso-8859-1';

	if (count($estados)) {
		$respuesta->addAssign("estados","style.display","");
		$respuesta->addScript("document.getElementById('cboEstados').disabled = false;");
		$respuesta->addScript("document.getElementById('cboEstados').options.length = 0;");

		asort($estados);

		foreach ($estados as $clave => $estado) {
			$respuesta->addScript("agregarOpcion('cboEstados','$estado','$clave');");
		}
	} else {
		$respuesta->addScript("document.getElementById('cboEstados').options.length = 0;");
		$respuesta->addScript("agregarOpcion('cboEstados','-- Seleccione Pais --','');");
		$respuesta->addScript("document.getElementById('cboEstados').disabled = true;");
	}

	return $respuesta;
}

?>
