<?php
session_start();
include '../../controller/conn.php';

// Ambil data dari request POST
$id_dg_event_detail_attendance = $_POST['id_dg_event_detail_attendance'];
$id_dg_event_detail = $_POST['id_dg_event_detail'];
$id_dg_user = $_POST['id_dg_user'];
$status_absen = $_POST['status_absen'];
$updated_by = $_POST['updated_by'];

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");

$response = array();

if (empty($id_dg_event_detail_attendance)) {
    // Insert new record
    $query = "INSERT INTO dg_event_detail_attendance (id_dg_event_detail, id_dg_user, status_absen, updated_at, updated_by) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $db2->prepare($query)) {
        $stmt->bind_param("sssss", $id_dg_event_detail, $id_dg_user, $status_absen, $tanggal_now, $updated_by);
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }
        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = $db2->error;
    }
} else {
    // Update existing record
    $query = "UPDATE dg_event_detail_attendance SET status_absen = ?, updated_at = ?, updated_by = ? WHERE id_dg_event_detail_attendance = ?";
    if ($stmt = $db2->prepare($query)) {
        $stmt->bind_param("ssss", $status_absen, $tanggal_now, $updated_by, $id_dg_event_detail_attendance);
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }
        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = $db2->error;
    }
}

// Set header type to JSON and output the response
header('Content-Type: application/json');
echo json_encode($response);
?>