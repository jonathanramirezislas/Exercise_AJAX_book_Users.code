<?php

$username = 'admin';
$password = 'admin';

if ($_GET[username] && $_GET[password]) 
{
	if ($_GET[username]==$username && $_GET[password]==$password)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
} 
else
{
	echo '2';
}
?>
