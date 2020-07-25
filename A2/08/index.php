<?php

$var  = "{							";
$var .= "    xxx:{					";
$var .= "        yyy:{				";
$var .= "            zzz:[			";
$var .= "                'abc',		";
$var .= "                'def',		";
$var .= "                'ghi'		";
$var .= "            ]				";
$var .= "        }					";
$var .= "    }						";
$var .= "}							";

include 'JSON/JSON.php';
$json = new Services_JSON();
$json = $json->decode($var);

/*

estructura de $json en PHP:

stdClass Object
(
	[xxx] => stdClass Object
		(
			[yyy] => stdClass Object
				(
					[zzz] => Array
						(
							[0] => abc
							[1] => def
							[2] => ghi
						)
				)
		)
)

*/

echo $json->xxx->yyy->zzz[1]; //salida: def

?>
