<?php

class ejemplo {
	var $a;
	var $b;
	var $c;

	function ejemplo() {
		$this->a = 10;
		$this->b = 11;
		$this->c = $this->a - $this->b;
	}
}

$x = new ejemplo();
$x->b = $x->a + $x->c;

include 'JSON/JSON.php';
$json = new Services_JSON();
$objeto = $x;
$json = $json->encode($objeto);

?>

<script language="javascript" src="json.js"></script>

<script language="javascript">
    var JSON = '<?php echo $json; ?>';
    var objeto = JSON.parseJSON();
    alert(objeto.b); //salida: 9
</script>
