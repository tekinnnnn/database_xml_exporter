<?php
header("content type:text/xml");

try {
	$dsn = "mysql:host=localhost;dbname=sakila;charset=utf8";
	$db = new PDO($dsn, "root", "");

	$result = $db->query("show tables");
	while ($row = $result->fetch(PDO::FETCH_NUM)) {
		$table = $row[0];
		//$table = "film";

		$fp = fopen($table . "_" . date("YmdHis") . ".xml", "w");
		$veri .= "<$table>\n";
		$sorgu = $db->query("SELECT * FROM $table");

		$sayac = 1;
		while ($row = $sorgu->fetch(PDO::FETCH_ASSOC)) {
			$veri .= "\t<$table$sayac>\n";
			foreach ($row as $key => $value) {
				$veri .= "\t\t<$key>$value</$key>\n";
			}
			$veri .= "\t</$table$sayac>\n";

			$sayac++;
		}

		$veri .= "</$table>";

		fputs($fp, $veri);

	}
} catch (Exception $e) {
	echo "Hata : " . $e->getMessage();
}

?>