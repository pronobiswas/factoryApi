<?php
// proxy.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = 'http://137.184.57.238/x12/validate';

    // Prepare the POST fields
    $postFields = [];
    foreach ($_POST as $key => $value) {
        $postFields[$key] = $value;
    }

    // Handle file upload
    if (isset($_FILES['content'])) {
        $file = $_FILES['content'];
        $cfile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
        $postFields['content'] = $cfile;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Optional: Set headers if needed
    // curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //     "Content-Type: multipart/form-data"
    // ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        http_response_code(500);
        echo "cURL Error: $error";
    } else {
        echo $response;
    }
    exit;
}
?>