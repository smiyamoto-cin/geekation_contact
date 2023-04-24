<?php
require_once ('../Controllers/ContactController.php'); 

$dbh = (new DbModel())->dbConnect();
        $delete = new ContactController();
        $result =$delete ->delete($_GET['id']);
?>