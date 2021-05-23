<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
		$abs1 = gmp_abs("274982683358123123123");
		$abs2 = gmp_abs("-27498268335812312312312313123");

		echo gmp_strval($abs1) . "\n";
		echo gmp_strval($abs2) . "\n";
		echo 'Size of int is '.PHP_INT_SIZE;
	?>
</body>
</html>