<?php
$ids = array();
if (isset($_GET['ids'])) {
	$ids = explode(' ', trim($_GET['ids']));
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Compare</title>
</head>
<body>
<?php
echo "<pre>";
print_r($ids);
echo "</pre>";
?>
</body>
</html>
