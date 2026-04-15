<?php

        $file = '../../../data/blocker.json';
        $data = [];
        if (isset($file)) {
            $data = json_decode(file_get_contents($file),true);
            print_r($data);
        }else{
            $data = [];
        }
        $data[] = $_POST['ip'];
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

?>