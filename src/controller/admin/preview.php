<?php 

 
if (empty($_GET['file']) || empty($_GET['name']) || empty($_GET['path'])) {
    http_response_code(400);
    exit("Missing file or name.");
}
$relativePath  = basename($_GET['path']);
$storedFile = basename($_GET['file']); // Prevent directory traversal
$originalName = basename($_GET['name']); // The name you want user to see/download as
 
$fullPath = "";
if($relativePath == "tc")
{
    $fullPath = __DIR__ . '/../../uploads/transaction-code/' . $storedFile;
}else{
    $fullPath = __DIR__ . '/../../uploads/files/' . $storedFile;
}



if (!file_exists($fullPath)) {
    http_response_code(404);
    exit("File not found.");
}


$mimeType = mime_content_type($fullPath);
header("Content-Type: $mimeType");
header("Content-Disposition: inline; filename=\"" . $originalName . "\"");
readfile($fullPath);
exit;
