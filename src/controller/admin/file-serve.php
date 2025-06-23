<?php
if (!isset($_GET['file']) || !isset($_GET['name'])) {
    http_response_code(400);
    exit("Missing file or name.");
}
$relativePath  = basename($_GET['path']);
$storedFile = basename($_GET['file']);
$originalName = basename($_GET['name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($originalName) ?></title>
    <style>
        html, body {
            margin: 0;
            height: 100%;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <iframe src="preview.php?file=<?= urlencode($storedFile) ?>&name=<?= urlencode($originalName)?>&path=<?= urlencode($relativePath)?>"></iframe>
</body>
</html>
