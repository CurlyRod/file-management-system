<?php
if (!isset($_GET['file']) || !isset($_GET['name'])) {
    http_response_code(400);
    exit("Missing file or name.");
}

$storedFile = basename($_GET['file']); // Prevent directory traversal
$originalName = basename($_GET['name']); // The name you want user to see/download as

$fullPath = __DIR__ . '/../../uploads/files/' . $storedFile;

if (!file_exists($fullPath)) {
    http_response_code(404);
    exit("File not found.");
}

$mimeType = mime_content_type($fullPath);
header("Content-Type: $mimeType");
header("Content-Disposition: inline; filename=\"" . $originalName . "\"");
readfile($fullPath);
exit;
