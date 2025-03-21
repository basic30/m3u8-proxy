<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/vnd.apple.mpegurl");

// Get the stream URL from the query string
$url = isset($_GET['url']) ? $_GET['url'] : '';

if (filter_var($url, FILTER_VALIDATE_URL) === false) {
    http_response_code(400);
    echo "Invalid URL.";
    exit;
}

// Use cURL to fetch the stream
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Check for errors
if ($http_code !== 200) {
    http_response_code($http_code);
    echo "Error fetching the stream.";
    exit;
}

echo $result;
?>
