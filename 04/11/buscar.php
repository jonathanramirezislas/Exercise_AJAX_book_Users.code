<?php

if ($_POST[q] != '') {

	$array[]='ALABAMA';
	$array[]='ALASKA';
	$array[]='AMERICAN SAMOA';
	$array[]='ARIZONA';
	$array[]='ARKANSAS';
	$array[]='CALIFORNIA';
	$array[]='COLORADO';
	$array[]='CONNECTICUT';
	$array[]='DELAWARE';
	$array[]='DISTRICT OF COLUMBIA';
	$array[]='FEDERATED STATES OF MICRONESIA';
	$array[]='FLORIDA';
	$array[]='GEORGIA';
	$array[]='GUAM';
	$array[]='HAWAII';
	$array[]='IDAHO';
	$array[]='ILLINOIS';
	$array[]='INDIANA';
	$array[]='IOWA';
	$array[]='KANSAS';
	$array[]='KENTUCKY';
	$array[]='LOUISIANA';
	$array[]='MAINE';
	$array[]='MARSHALL ISLANDS';
	$array[]='MARYLAND';
	$array[]='MASSACHUSETTS';
	$array[]='MICHIGAN';
	$array[]='MINNESOTA';
	$array[]='MISSISSIPPI';
	$array[]='MISSOURI';
	$array[]='MONTANA';
	$array[]='NEBRASKA';
	$array[]='NEVADA';
	$array[]='NEW HAMPSHIRE';
	$array[]='NEW JERSEY';
	$array[]='NEW MEXICO';
	$array[]='NEW YORK';
	$array[]='NORTH CAROLINA';
	$array[]='NORTH DAKOTA';
	$array[]='NORTHERN MARIANA ISLANDS';
	$array[]='OHIO';
	$array[]='OKLAHOMA';
	$array[]='OREGON';
	$array[]='PALAU';
	$array[]='PENNSYLVANIA';
	$array[]='PUERTO RICO';
	$array[]='RHODE ISLAND';
	$array[]='SOUTH CAROLINA';
	$array[]='SOUTH DAKOTA';
	$array[]='TENNESSEE';
	$array[]='TEXAS';
	$array[]='UTAH';
	$array[]='VERMONT';
	$array[]='VIRGIN ISLANDS';
	$array[]='VIRGINIA';
	$array[]='WASHINGTON';
	$array[]='WEST VIRGINIA';
	$array[]='WISCONSIN';
	$array[]='WYOMING';

	$c = 0;

	foreach ($array as $v) {
		if (strtolower(substr($v, 0, strlen($_POST[q]))) == strtolower($_POST[q])) {
			$c++;
			$salida .= $v.'<br>';
		}
	}

	if ($c != 1)	$c = "$c resultados";
	else			$c = "1 resultado";

	echo $c.'<br><br>'.$salida.'<br>';
}

?>
