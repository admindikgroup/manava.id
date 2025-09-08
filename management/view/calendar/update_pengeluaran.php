<?php
session_start();
include '../../controller/conn.php';

$idAbsensi = $_POST['id_dg_event_detail_attendance'];
$pengeluaran = $_POST['pengeluaran'];

// Update query
$query = "UPDATE dg_event_detail_attendance SET pengeluaran = ? WHERE id_dg_event_detail_attendance = ?";
$stmt = $db2->prepare($query);
$stmt->bind_param("di", $pengeluaran, $idAbsensi);

if ($stmt->execute()) {
    echo "Pengeluaran updated successfully";
} else {
    echo "Error updating pengeluaran: " . $stmt->error;
}

$stmt->close();
$db2->close();
?>
