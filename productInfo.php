<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once('controllers/ProductController.php');

// Views
require_once('views/templates/header.php');
require_once('views/ProductView.php');
require_once('views/CategoryView.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productView = new ProductView($id);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Info</title>
    <link rel="stylesheet" href="views/styles/header_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/header_script.js"></script>
</head>
<body>
<?php Header::show(); ?>

<?php
if (isset($productView)) {
    $productView->show_basic_info();
} else {
    echo ":(";
}
?>

</body>
</html>
