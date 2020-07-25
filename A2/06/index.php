<?php

include 'JSON/JSON.php';
$json = new Services_JSON();
$array = Array('cero', 'uno', 'dos', 'tres');
$json = $json->encode($array);

//en JSON $json es ["cero","uno","dos","tres"] 

?>

<script language="javascript" src="json.js"></script>

<script language="javascript">
    var JSON = '<?php echo $json; ?>';
    var matriz = JSON.parseJSON();
    alert(matriz[1]); //salida: uno
</script>
