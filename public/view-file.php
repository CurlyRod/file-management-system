<?php
if (!isset($_GET['file'], $_GET['path'], $_GET['name'])) {
    http_response_code(400);
    exit("Missing parameters.");
}

$storedFile = basename($_GET['file']);         
$originalName = basename($_GET['name']);     
$pathKey = $_GET['path'];                    

// Map logical path
switch ($pathKey) {
    case 'tc':
        $folder = __DIR__ . '../../src/uploads/transaction-code/';
        break;
    case 'files':
        $folder = __DIR__ . '../../src/uploads/files/';
        break;
    default:
        http_response_code(400);
        exit("Invalid path.");
}

// Build absolute file path
$fullPath = $folder . $storedFile;

if (!file_exists($fullPath)) {
    http_response_code(404);
    exit("File not found.");
}

// Detect MIME type
$mimeType = mime_content_type($fullPath);
header("Content-Type: $mimeType");

// Tell browser to display inline, but use original name when downloaded
header("Content-Disposition: inline; filename=\"" . $originalName . "\"");

// Output file contents
readfile($fullPath);
exit;
