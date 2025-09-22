<?php
// Konfigurasi
$app = "Smart-Room-01";
$deviceRelay = "room-control";  
$apiKey = "f4954d2c29afbda7:0666017d7ed0211c";
$baseUrl = "https://platform.antares.id:8443/~/antares-cse/antares-id/$app";

// Fungsi request POST ke Antares
function antaresPost($url, $key, $body)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "X-M2M-Origin: $key",
            "Content-Type: application/json;ty=4",
            "Accept: application/json"
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(["m2m:cin" => ["con" => $body]])
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// Ambil data dari body request
$d = json_decode(file_get_contents("php://input"), true);

// Kirim data relay ke Antares
$r = antaresPost("$baseUrl/$deviceRelay", $apiKey, json_encode($d));
echo json_encode($d);
