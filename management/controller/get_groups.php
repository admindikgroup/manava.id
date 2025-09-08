<?php
include 'conn.php';

$query = "SELECT *, dug.id_dg_division as dug_id_dg_division 
          FROM `dg_user_group` dug
          LEFT JOIN dg_division dd ON dug.id_dg_division = dd.id_dg_division";

$result = mysqli_query($db2, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id_dg_user_group = $row['id_dg_user_group'];

    // Ambil anggota group
    $member_query = "SELECT du.nama FROM `dg_user_group_detail` dd
                     INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
                     WHERE dd.id_dg_user_group = $id_dg_user_group";

    $member_result = mysqli_query($db2, $member_query);
    $members = [];
    while ($member_row = mysqli_fetch_assoc($member_result)) {
        $members[] = $member_row['nama'];
    }

    $data[] = [
        'id_dg_user_group' => $row['id_dg_user_group'],
        'division_name' => $row['dug_id_dg_division'] != 0 ? $row['division_name'] : "Not Set",
        'nama_group' => $row['nama_group'],
        'deskripsi_group' => $row['deskripsi_group'],
        'members' => $members,
        'dug_id_dg_division' => $row['dug_id_dg_division']
    ];
}

echo json_encode($data);
?>
