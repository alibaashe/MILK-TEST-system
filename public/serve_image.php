<?php

// A simple script to securely serve images from a non-public directory

if (isset($_GET['file'])) {
    // Sanitize the filename to prevent directory traversal
    $filename = basename($_GET['file']);

    $upload_dir = dirname(__DIR__) . '/uploads/signatures/';
    $filepath = $upload_dir . $filename;

    if (file_exists($filepath) && is_readable($filepath)) {
        // Get the file's mime type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $filepath);
        finfo_close($finfo);

        // Set the content type header
        header('Content-Type: ' . $mime_type);
        header('Content-Length: ' . filesize($filepath));

        // Read the file and output its contents
        readfile($filepath);
        exit;
    }
}

// If file not found or invalid, return a 404
http_response_code(404);
echo "<h1>404 - Image Not Found</h1>";
exit;
