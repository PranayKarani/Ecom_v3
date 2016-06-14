<?php

session_start();

if (isset($_SESSION['seller_loggedIn']) && $_SESSION['seller_loggedIn'] == true) {
    echo $_SESSION['seller_id'];
} else {

    if (isset($_POST['username']) && isset($_POST['password'])) {

        require_once 'include/config.php';
        require_once 'include/DBHandler.php';
        require_once 'controllers/SSellerController.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = SSellerController::authorize($username, $password);

        $id = $result['seller_id'];

        if (isset($id)) {
            $_SESSION['seller_id'] = $id;
            $_SESSION['seller_loggedIn'] = true;
            echo $id;
        } else {
            echo -1;
        }

    }

}
?>
