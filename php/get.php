<?php
// Konfigurasi
$app = "Smart-Room-01";
$deviceSensor = "room-monitor";  
$apiKey = "f4954d2c29afbda7:0666017d7ed0211c";
$baseUrl = "https://platform.antares.id:8443/~/antares-cse/antares-id/$app";

// Fungsi request GET ke Antares
function antaresGet($url, $key)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "X-M2M-Origin: $key",
            "Accept: application/json"
        ]
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// Ambil data terakhir dari device sensor
$r = antaresGet("$baseUrl/$deviceSensor/la", $apiKey);
echo $r["m2m:cin"]["con"] ?? "{}";
