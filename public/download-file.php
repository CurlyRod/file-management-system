    <?php
    if (!isset($_GET['file'], $_GET['path'], $_GET['name'])) {
        http_response_code(400);
        exit("Missing parameters.");
    }

    $storedFile = basename($_GET['file']);
    $originalName = basename($_GET['name']);
    $pathKey = $_GET['path'];

    // Adjusted relative path — goes up 3 levels from /admin/myfiles/public/
    switch ($pathKey) {
        case 'tc':
            $folder = realpath(__DIR__ . '../../src/uploads/transaction-code');
            break;
        case 'files':
            $folder = realpath(__DIR__ . '../../src/uploads/files');
            break; 
        case 'rt':
            $folder = realpath(__DIR__ . '../../src/uploads/resolved-tickets');
            break; 
        default:
            http_response_code(400);
            exit("Invalid path.");
    }

    if (!$folder) {
        http_response_code(500);
        exit("Invalid folder path resolution.");
    }

    $fullPath = $folder . DIRECTORY_SEPARATOR . $storedFile;

    if (!file_exists($fullPath)) {
        http_response_code(404);
        exit("File not found at: $fullPath");
    }

    // Force file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $originalName . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fullPath));

    readfile($fullPath);
    exit;
