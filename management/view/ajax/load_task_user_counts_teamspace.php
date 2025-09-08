<?php
include '../../controller/conn.php';

header('Content-Type: application/json'); // Set header JSON

$selectedTeamspaces = isset($_GET['selectedTeamspaces']) ? $_GET['selectedTeamspaces'] : [];
$selectedSprints = isset($_GET['selectedSprints']) ? $_GET['selectedSprints'] : [];

// Pastikan setidaknya satu teamspace dipilih, jika tidak, hentikan eksekusi
if (empty($selectedTeamspaces)) {
    echo json_encode(['finish' => 0, 'not_finish' => 0, 'error' => 'Harus memilih minimal satu Teamspace']);
    exit;
}

// Jika Sprint kosong, ambil semua sprint yang ada dalam teamspace yang dipilih
if (empty($selectedSprints)) {
    $sprintQuery = "
        SELECT id_dg_client_project_sprint 
        FROM dg_client_project_sprint 
        WHERE id_dg_client_project IN (" . implode(',', array_fill(0, count($selectedTeamspaces), '?')) . ")
    ";
    $sprintStmt = $db2->prepare($sprintQuery);
    $sprintStmt->bind_param(str_repeat('i', count($selectedTeamspaces)), ...$selectedTeamspaces);
    $sprintStmt->execute();
    $sprintResult = $sprintStmt->get_result();

    while ($row = $sprintResult->fetch_assoc()) {
        $selectedSprints[] = $row['id_dg_client_project_sprint'];
    }

    $sprintStmt->close();
}

// Jika setelah pengecekan masih kosong, hentikan eksekusi
if (empty($selectedSprints)) {
    echo json_encode(['finish' => 0, 'not_finish' => 0, 'error' => 'Tidak ada sprint yang tersedia dalam Teamspace yang dipilih']);
    exit;
}

// Konversi array menjadi format untuk query
$teamspacePlaceholders = implode(',', array_fill(0, count($selectedTeamspaces), '?'));
$sprintPlaceholders = implode(',', array_fill(0, count($selectedSprints), '?'));

// Query untuk menghitung jumlah task selesai dan belum selesai
$sql = "
    SELECT st.is_finish, COUNT(*) as task_count
    FROM dg_client_project_task t
    INNER JOIN dg_client_project_sprint s ON t.id_sprint = s.id_dg_client_project_sprint
    LEFT JOIN dg_client_project_status st ON t.id_status = st.id_dg_client_project_status
    WHERE t.id_dg_client_project IN ($teamspacePlaceholders)
    AND t.id_sprint IN ($sprintPlaceholders)
    AND t.deleted_at is null
    GROUP BY st.is_finish
";

$params = array_merge($selectedTeamspaces, $selectedSprints);
$stmt = $db2->prepare($sql);
$stmt->bind_param(str_repeat('i', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

$finishCount = 0;
$notFinishCount = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['is_finish'] == 1) {
        $finishCount = $row['task_count'];
    } else {
        $notFinishCount = $row['task_count'];
    }
}

// Format JSON yang sesuai dengan yang diharapkan oleh JavaScript
echo json_encode([
    'not_finish' => $notFinishCount,
    'finish' => $finishCount
]);

$stmt->close();
$db2->close();
?>
