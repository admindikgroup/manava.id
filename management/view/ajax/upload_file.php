<?php
$allowedTypes = [
    'img' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'tiff'],
    'video' => ['mp4', 'avi', 'mov', 'mkv', 'webm', 'flv', 'wmv', 'm4v'],
    'audio' => ['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a'],
    'doc' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'odt', 'ods', 'odp', 'rtf', 'apk', 'exe', 'dmg', 'iso', 'html', 'css', 'js', 'php', 'py', 'java', 'cpp', 'c', 'cs', 'json', 'xml', 'sql', 'md', 'zip', 'rar', '7z', 'tar', 'gz', 'bz2', 'xz']
];

if (isset($_FILES['file_upload'])) {
    $file = $_FILES['file_upload'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    $id_user = isset($_POST['id_user']) ? preg_replace('/\D/', '', $_POST['id_user']) : '0';
    $id_chat = isset($_POST['id_chat']) ? preg_replace('/\D/', '', $_POST['id_chat']) : '0';

    foreach ($allowedTypes as $folder => $exts) {
        if (in_array($ext, $exts)) {
            $uploadDir = __DIR__ . "/../../storage/upload/$folder/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filename = $id_user . '-' . $id_chat . '-' .uniqid(). '.' . $ext;
            $destination = $uploadDir . $filename;
            $publicPath = "storage/upload/$folder/" . $filename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                echo json_encode(['success' => true, 'file_path' => $publicPath]);
                exit;
            }
        }
    }
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Upload gagal']);
