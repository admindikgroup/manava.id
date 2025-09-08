<?php
include '../../controller/conn.php';

header('Content-Type: application/json'); // Set header JSON

$selectedTeamspaces = isset($_GET['select_teamspace']) ? $_GET['select_teamspace'] : [];
$selectedSprints = isset($_GET['select_sprint']) ? $_GET['select_sprint'] : [];

// Pastikan setidaknya satu teamspace dipilih, jika tidak, hentikan eksekusi
if (empty($selectedTeamspaces)) {
    echo json_encode(['tasks' => [], 'error' => 'Harus memilih minimal satu Teamspace']);
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
    echo json_encode(['tasks' => [], 'error' => 'Tidak ada sprint yang tersedia dalam Teamspace yang dipilih']);
    exit;
}

// Konversi array menjadi format untuk query
$teamspacePlaceholders = implode(',', array_fill(0, count($selectedTeamspaces), '?'));
$sprintPlaceholders = implode(',', array_fill(0, count($selectedSprints), '?'));

// Query untuk mengambil tugas berdasarkan teamspace dan sprint
$sql = "
    SELECT 
        t.id_dg_client_project, 
        t.id_dg_client_project_task, 
        t.nama_task, 
        t.priority, 
        t.detail_project, 
        t.urutan_task, 
        t.id_status, 
        s.nama_sprint,
        st.is_finish,
        st.nama_status, -- Ambil nama status dari tabel status
        MAX(h.edited_at) AS date_done,
        MAX(a.deadline_status) AS deadline_status, -- Ambil deadline terbaru
        GROUP_CONCAT(DISTINCT CONCAT(u.id_dg_user, ':', u.nama, ':', u.photo) ORDER BY u.nama ASC) AS assigned_users
    FROM dg_client_project_task t
    INNER JOIN dg_client_project_sprint s ON t.id_sprint = s.id_dg_client_project_sprint
    LEFT JOIN dg_client_project_status st ON t.id_status = st.id_dg_client_project_status -- Join tabel status
    LEFT JOIN dg_client_project_task_status_history h ON t.id_dg_client_project_task = h.id_dg_client_project_task
    LEFT JOIN dg_client_project_status_assign a ON t.id_dg_client_project_task = a.id_dg_client_project_task
    LEFT JOIN dg_user u ON a.id_dg_user_assign = u.id_dg_user
    WHERE t.id_dg_client_project IN ($teamspacePlaceholders)
    AND t.id_sprint IN ($sprintPlaceholders)
    AND t.deleted_at is null
    GROUP BY t.id_dg_client_project_task
    ORDER BY st.is_finish ASC, st.id_dg_client_project_status ASC, t.id_dg_client_project_task DESC
";

$params = array_merge($selectedTeamspaces, $selectedSprints);
$stmt = $db2->prepare($sql);
$stmt->bind_param(str_repeat('i', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $assignedUsers = [];
    if (!empty($row['assigned_users'])) {
        $userEntries = explode(',', $row['assigned_users']);
        foreach ($userEntries as $entry) {
            list($userId, $userName, $userPhoto) = explode(':', $entry);
            $assignedUsers[] = [
                'id' => $userId,
                'name' => $userName,
                'photo' => !empty($userPhoto) ? "img/profile/$userPhoto" : "img/profile/default.jpg" // Default jika kosong
            ];
        }
    }
    $tasks[] = [
        'id_dg_client_project_task' => $row['id_dg_client_project_task'],
        'id_dg_client_project' => $row['id_dg_client_project'],
        'nama_task' => htmlspecialchars($row['nama_task'], ENT_QUOTES, 'UTF-8'),
        'priority' => $row['priority'],
        'detail_project' => htmlspecialchars($row['detail_project'], ENT_QUOTES, 'UTF-8'),
        'urutan_task' => $row['urutan_task'],
        'status_task' => $row['id_status'],
        'is_finish' => $row['is_finish'],
        'nama_status' => htmlspecialchars($row['nama_status'], ENT_QUOTES, 'UTF-8'), // Menampilkan nama status
        'date_done' => $row['date_done'] ? date("d-F-Y", strtotime($row['date_done'])) : null,
        'deadline_status' => $row['deadline_status'] ? date("d F Y", strtotime($row['deadline_status'])) : "Deadline tidak disetting",
        'nama_sprint' => htmlspecialchars($row['nama_sprint'], ENT_QUOTES, 'UTF-8'),
        'assigned_users' => $assignedUsers
    ];
}

echo json_encode(['tasks' => $tasks]);

$stmt->close();
$db2->close();
?>
