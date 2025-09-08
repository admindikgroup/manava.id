<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

$id_chat = $_POST['id_dg_chat_ai_title'];
$id_user = $_POST['id_user'];

if (!$id_chat || !$id_user) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$uploadBase = __DIR__ . '/../../storage/upload/';
$aiBase = __DIR__ . '/../../storage/ai/';
$folders = ['img', 'video', 'audio', 'doc'];

// 1. Hapus file upload biasa: id_user-id_chat-*
foreach ($folders as $folder) {
    $path = $uploadBase . $folder . '/';
    $pattern = $path . "{$id_user}-{$id_chat}-*";

    foreach (glob($pattern) as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

// 2. Hapus file AI dengan prefix mng_ai: mng_ai-id_user-id_chat-*
foreach ($folders as $folder) {
    $path = $aiBase . $folder . '/';
    $pattern = $path . "mng_ai-{$id_user}-{$id_chat}-*";

    foreach (glob($pattern) as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

// 3. Hapus dari database
$query1 = "DELETE FROM dg_chat_ai_title WHERE id_dg_chat_ai_title = '$id_chat'";
$query2 = "DELETE FROM dg_chat_ai WHERE id_dg_chat_ai_title = '$id_chat'";

if (mysqli_query($db2, $query1)) {
    if (mysqli_query($db2, $query2)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete detail chat']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete']);
}
?>
