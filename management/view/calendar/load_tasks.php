<?php
include '../../controller/conn.php';

header('Content-Type: application/json'); // Set header untuk JSON

$id_dg_event = $_GET['id_dg_event'];
$id_dg_event_detail = $_GET['id_dg_event_detail'];
$id_dg_user_group = $_GET['id_dg_user_group'] ?? null; // Pastikan nilai ada atau null


    // Jika $id_dg_user_group ada, gunakan filter WHERE
    $sql = "
        SELECT de.id_dg_event, t.id_dg_event_detail, t.id_dg_event_detail_task, t.isi_task, t.deadline_task, t.date_done, t.status_task, du.nama AS owner_name, du.id_dg_user 
        FROM dg_event_detail_task t
        INNER JOIN dg_user du ON du.id_dg_user = t.id_dg_user
        INNER JOIN dg_event_detail ed ON ed.id_dg_event_detail = t.id_dg_event_detail
        INNER JOIN dg_event de ON de.id_dg_event = ed.id_dg_event
        WHERE de.id_dg_event = ?
          AND (t.status_task IN (0,1) OR (t.status_task = 3 AND t.date_done > DATE_SUB(CURDATE(), INTERVAL 7 DAY)))
        ORDER BY t.status_task ASC, t.deadline_task ASC, t.id_dg_event_detail_task DESC";
    
    $stmt = $db2->prepare($sql);
    $stmt->bind_param('i', $id_dg_event);


// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();

$tasks = []; // Array untuk menyimpan task
while ($row = $result->fetch_assoc()) {
    $tasks[] = [
        'id_dg_event_detail_task' => $row['id_dg_event_detail_task'],
        'isi_task' => htmlspecialchars($row['isi_task'], ENT_QUOTES, 'UTF-8'),
        'deadline_task' => date("d-F-Y", strtotime($row['deadline_task'])),
        'status_task' => $row['status_task'],
        'owner_id' => $row['id_dg_user'],
        'owners' => [] // Akan diisi nanti
    ];
}

// Jika ada ID user group, ambil daftar owners
if ($id_dg_user_group) {
    foreach ($tasks as &$task) {
        // Ambil owners dari grup
        $owner_sql = "SELECT du.id_dg_user, du.nama 
                      FROM dg_user_group_detail dd 
                      INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user 
                      WHERE dd.id_dg_user_group = ?";
        
        $owner_stmt = $db2->prepare($owner_sql);
        $owner_stmt->bind_param('i', $id_dg_user_group);
        $owner_stmt->execute();
        $owner_result = $owner_stmt->get_result();
        
        $owners = [];
        $owner_ids = [];

        while ($owner_row = $owner_result->fetch_assoc()) {
            $owners[] = [
                'id' => $owner_row['id_dg_user'],
                'name' => htmlspecialchars($owner_row['nama'], ENT_QUOTES, 'UTF-8'),
                'in_group' => true
            ];
            $owner_ids[] = $owner_row['id_dg_user'];
        }

        // Jika task memiliki owner tapi tidak ada di grup, tambahkan dengan tanda 'not in group'
        if (!in_array($task['owner_id'], $owner_ids) && $task['owner_id']) {
            $stmt_extra = $db2->prepare("SELECT nama FROM dg_user WHERE id_dg_user = ?");
            $stmt_extra->bind_param("i", $task['owner_id']);
            $stmt_extra->execute();
            $result_extra = $stmt_extra->get_result();
            if ($row_extra = $result_extra->fetch_assoc()) {
                $owners[] = [
                    'id' => $task['owner_id'],
                    'name' => htmlspecialchars($row_extra['nama'], ENT_QUOTES, 'UTF-8') . ' (not in group)',
                    'in_group' => false
                ];
            }
        }

        $task['owners'] = $owners;
    }
}


echo json_encode(['tasks' => $tasks]);

$stmt->close();
$db2->close();

?>
