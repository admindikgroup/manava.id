<?php
session_start();
include '../../controller/conn.php';

$id_dg_client_project = $_GET['id_project'];
$id_user = $_GET['id_user'];

// Query status
$check_status_query = "
    SELECT COUNT(*) as total 
    FROM dg_client_project_status_user cpsu
    INNER JOIN dg_client_project_status cps 
        ON cps.id_dg_client_project_status = cpsu.id_dg_client_project_status
    WHERE cps.id_dg_client_project = $id_dg_client_project 
    AND cpsu.id_dg_user = $id_user
";

$result_check_status = mysqli_query($db2, $check_status_query);
$check_status_data = mysqli_fetch_assoc($result_check_status);

if ($check_status_data['total'] > 0) {
    $result_ps = mysqli_query($db2, "
        SELECT cps.id_dg_client_project_status, cps.nama_status, cps.warna_status, cps.urutan_status, cps.is_deadline_active, cps.is_finish
        FROM dg_client_project_status_user cpsu
        INNER JOIN dg_client_project_status cps 
            ON cps.id_dg_client_project_status = cpsu.id_dg_client_project_status
        WHERE cps.id_dg_client_project = $id_dg_client_project 
        AND cpsu.id_dg_user = $id_user
        AND cps.deleted_by IS NULL
        AND cpsu.is_active = 1
        ORDER BY cpsu.urutan_view ASC, cps.urutan_status ASC, cps.id_dg_client_project_status ASC
    ");
} else {
    $result_ps = mysqli_query($db2, "
        SELECT id_dg_client_project_status, nama_status, warna_status, urutan_status 
        FROM dg_client_project_status
        WHERE id_dg_client_project = $id_dg_client_project 
        AND deleted_by IS NULL
        ORDER BY urutan_status ASC, id_dg_client_project_status ASC
    ");
}

// Query sprint
$check_sprint_query = "
    SELECT COUNT(*) as total 
    FROM dg_client_project_filter_user_sprint cpfs
    INNER JOIN dg_client_project_sprint dcps
    ON dcps.id_dg_client_project_sprint = cpfs.id_dg_client_project_sprint
    WHERE cpfs.id_dg_user = $id_user AND
    dcps.id_dg_client_project = $id_dg_client_project 
";

$result_check_sprint = mysqli_query($db2, $check_sprint_query);
$check_sprint_data = mysqli_fetch_assoc($result_check_sprint);

if ($check_sprint_data['total'] > 0) {
    $sprint_filter = "
        AND cpt.id_sprint IN (
            SELECT id_dg_client_project_sprint 
            FROM dg_client_project_filter_user_sprint
            WHERE id_dg_user = $id_user
        )
    ";
} else {
    $sprint_filter = ""; // Tidak ada filter, tampilkan semua sprint
}

$data = [];

// Proses tasks dengan status tertentu
while ($d_ps = mysqli_fetch_assoc($result_ps)) {
    $tasks = [];
    $result_pt = mysqli_query($db2, "
        SELECT cpt.*, 
        cpt.detail_project,
        GROUP_CONCAT(cpsa.id_dg_user_assign) AS assigned_users,
        cpsa.deadline_status, -- Mengambil deadline dari status terkait
        cpst.nama_type,
        cpss.nama_sprint
        FROM dg_client_project_task cpt 
        
        LEFT JOIN dg_client_project_status_assign cpsa
        ON cpt.id_dg_client_project_task = cpsa.id_dg_client_project_task
        AND cpsa.id_dg_client_project_status = {$d_ps['id_dg_client_project_status']} -- Ambil hanya untuk status aktif
        
        LEFT JOIN dg_client_project_type cpst
        ON cpt.id_type = cpst.id_dg_client_project_type
        
        LEFT JOIN dg_client_project_sprint cpss
        ON cpt.id_sprint = cpss.id_dg_client_project_sprint

        WHERE cpt.id_dg_client_project = $id_dg_client_project 
        AND cpt.id_status = {$d_ps['id_dg_client_project_status']} 
        AND cpt.deleted_by IS NULL 
        $sprint_filter

        GROUP BY cpt.id_dg_client_project_task, cpsa.deadline_status -- Grup berdasarkan task dan deadline
        ORDER BY urutan_task ASC
    ");
    while ($d_pt = mysqli_fetch_assoc($result_pt)) {
        // Ambil user yang di-assign untuk task ini
        $result_users = mysqli_query($db2, "
            SELECT user.id_dg_user, user.photo, user.nama
            FROM dg_client_project_status_assign assign
            INNER JOIN dg_user user ON assign.id_dg_user_assign = user.id_dg_user
            WHERE assign.id_dg_client_project_task = {$d_pt['id_dg_client_project_task']}
              AND assign.id_dg_client_project_status = {$d_ps['id_dg_client_project_status']}
        ");
    
        $users = [];
        while ($user = mysqli_fetch_assoc($result_users)) {
            $users[] = $user; // Simpan data user (ID dan foto profil)
        }
    
        $d_pt['users'] = $users; // Tambahkan data pengguna ke dalam task

        // Pastikan hanya menampilkan deadline jika ada
        if (!empty($d_pt['deadline_status'])) {
            $d_pt['formatted_deadline'] = date('l, d F Y', strtotime($d_pt['deadline_status']));
        } else {
            $d_pt['formatted_deadline'] = null; // Tidak ada deadline
        }

        $tasks[] = $d_pt;
    }
    
    $d_ps['tasks'] = $tasks;
    $data[] = $d_ps;
}

// Proses tasks tanpa status
$no_status_tasks = [];
$result_no_status = mysqli_query($db2, "
    SELECT cpt.*, 
    cpt.detail_project,
    GROUP_CONCAT(cpsa.id_dg_user_assign) AS assigned_users,
    cpsa.deadline_status,
    cpst.nama_type,
    cpss.nama_sprint
    FROM dg_client_project_task cpt 
    
    LEFT JOIN dg_client_project_status_assign cpsa
    ON cpt.id_dg_client_project_task = cpsa.id_dg_client_project_task
    
    LEFT JOIN dg_client_project_type cpst
    ON cpt.id_type = cpst.id_dg_client_project_type
    
    LEFT JOIN dg_client_project_sprint cpss
    ON cpt.id_sprint = cpss.id_dg_client_project_sprint

    LEFT JOIN dg_client_project_status cps
    ON cpt.id_status = cps.id_dg_client_project_status 

    WHERE cpt.id_dg_client_project = $id_dg_client_project 
    AND (cps.deleted_by IS NOT NULL OR cpt.id_status IS NULL)
    AND cpt.deleted_by IS NULL
    OR (cpt.id_dg_client_project = $id_dg_client_project AND cpt.id_status IS NULL)
    OR (cpt.id_dg_client_project = $id_dg_client_project AND cpt.id_status = 0)
    $sprint_filter

    GROUP BY cpt.id_dg_client_project_task, cpsa.deadline_status
    ORDER BY urutan_task ASC
");

// OR (cpt.id_dg_client_project = $id_dg_client_project AND cpt.id_sprint IS NULL)
// OR (cpt.id_dg_client_project = $id_dg_client_project AND cpt.id_sprint = 0)
// OR (cpt.id_dg_client_project = $id_dg_client_project AND cpt.id_type IS NULL)
// OR (cpt.id_dg_client_project = $id_dg_client_project AND cpt.id_type = 0)

while ($d_no_status = mysqli_fetch_assoc($result_no_status)) {
    $result_users = mysqli_query($db2, "
        SELECT user.id_dg_user, user.photo, user.nama
        FROM dg_client_project_status_assign assign
        INNER JOIN dg_user user ON assign.id_dg_user_assign = user.id_dg_user
        WHERE assign.id_dg_client_project_task = {$d_no_status['id_dg_client_project_task']}
    ");

    $users = [];
    while ($user = mysqli_fetch_assoc($result_users)) {
        $users[] = $user;
    }

    $d_no_status['users'] = $users;

    // Pastikan hanya menampilkan deadline jika ada
    if (!empty($d_no_status['deadline_status'])) {
        $d_no_status['formatted_deadline'] = date('l, d F Y', strtotime($d_no_status['deadline_status']));
    } else {
        $d_no_status['formatted_deadline'] = null;
    }

    $no_status_tasks[] = $d_no_status;
}

// Siapkan data calendar untuk semua task (termasuk dari semua status)
$task_calendar_data = [];

foreach ($data as $statusGroup) {
    foreach ($statusGroup['tasks'] as $task) {
        $task_id = $task['id_dg_client_project_task'];

        $dl_query = mysqli_query($db2, "
            SELECT 
                cpsa.id_dg_client_project_status, 
                cps.nama_status, 
                cpsa.deadline_status 
            FROM 
                dg_client_project_status_assign cpsa 
            LEFT JOIN 
                dg_client_project_status cps 
                ON cps.id_dg_client_project_status = cpsa.id_dg_client_project_status 
            WHERE 
                cpsa.id_dg_client_project_task = '$task_id'
        ");

        while ($dl = mysqli_fetch_assoc($dl_query)) {
            
            if (!empty($dl['deadline_status'])) {
                // Ambil user yang assigned untuk status ini
                $assigned_users = [];
                $assigned_query = mysqli_query($db2, "
                    SELECT u.id_dg_user, u.photo, u.nama, cps.warna_status
                    FROM dg_client_project_status_assign sa
                    INNER JOIN dg_user u ON sa.id_dg_user_assign = u.id_dg_user
                    INNER JOIN dg_client_project_status cps ON cps.id_dg_client_project_status = sa.id_dg_client_project_status
                    WHERE sa.id_dg_client_project_task = '$task_id'
                    AND sa.id_dg_client_project_status = '{$dl['id_dg_client_project_status']}'
                ");
                
                while ($au = mysqli_fetch_assoc($assigned_query)) {
                    $assigned_users[] = $au;
                }
                
                $task_calendar_data[] = [
                    'id_task' => $task_id,
                    'nama_task' => $task['nama_task'],
                    'nama_sprint' => $task['nama_sprint'],
                    'nama_status' => $dl['nama_status'],
                    'nama_status_now' => $statusGroup['nama_status'],
                    'deadline_status_now' => $statusGroup['deadline_status'],
                    'deadline_status' => $dl['deadline_status'],
                    'warna_status' => $statusGroup['warna_status'],
                    'assigned_users' => $assigned_users,
                    'detail_project' => $task['detail_project'] ?? ''
                ];
            }
        }
    }
}

// Tambahkan "No Status" sebagai grup terakhir, sekaligus bawa calendar data
$data[] = [
    'id_dg_client_project_status' => null,
    'nama_status' => 'No Status',
    'warna_status' => null,
    'tasks' => $no_status_tasks,
    'task_calendar_data' => $task_calendar_data
];



header('Content-Type: application/json');
echo json_encode($data);
