<?php
session_start();
include '../../controller/conn.php';

// Ambil data dari form
$id_dg_user_organization     = $_POST['id_dg_user_organization'] ?? null;
$organization_name           = $_POST['inputName'] ?? '';
$organization_slug           = $_POST['slugName'] ?? '';
$organization_jenis_usaha    = $_POST['organization_jenis_usaha'] ?? '';
$organization_tanggal_beridri = !empty($_POST['deadline3']) ? date('Y-m-d', strtotime($_POST['deadline3'])) : null;
$organization_email          = $_POST['inputorganization_email'] ?? '';
$organization_telp           = $_POST['inputNo'] ?? '';
$organization_nomor_rekening = $_POST['inputRe'] ?? '';
$organization_nama_bank      = $_POST['bankName'] ?? '';
$organization_country        = $_POST['country'] ?? '';
$organization_province       = $_POST['province'] ?? '';
$organization_city           = $_POST['city'] ?? '';
$organization_district       = $_POST['district'] ?? '';
$organization_village        = $_POST['village'] ?? '';
$organization_alamat         = $_POST['address'] ?? '';
$organization_zip_code       = $_POST['zipCode'] ?? '';
$organization_nib            = $_POST['nib'] ?? '';
$organization_npwp           = $_POST['npwp'] ?? '';
$id_user                     = $_POST['id_user'] ?? null;
$now                         = date('Y-m-d H:i:s');


// Upload logo (jika ada)
$organization_logo = $_POST['bannerLama'] ?? 't0.jpg';
$old_logo = $organization_logo;

if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] == 0 && $id_dg_user_organization) {
    $target_dir = "../../img/organization/";
    $ext = strtolower(pathinfo($_FILES['lampiran']['name'], PATHINFO_EXTENSION));
    
    // Bersihkan nama organisasi
    $safe_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', strtolower($organization_name));
    $newname = "logo_{$id_dg_user_organization}_{$safe_name}." . $ext;
    $upload_path = $target_dir . $newname;

    if (move_uploaded_file($_FILES['lampiran']['tmp_name'], $upload_path)) {
        $organization_logo = $newname;

        // Hapus logo lama jika bukan default (t0.jpg) dan bukan file yang sama
        if ($old_logo !== 't0.jpg' && $old_logo !== $newname) {
            $old_path = $target_dir . $old_logo;
            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }
    }
}

// Update ke database
$query = "UPDATE dg_user_organization SET 
    organization_name = ?, 
    organization_slug = ?, 
    organization_jenis_usaha = ?, 
    organization_tanggal_beridri = ?, 
    organization_email = ?, 
    organization_telp = ?, 
    organization_logo = ?, 
    organization_nomor_rekening = ?, 
    organization_nama_bank = ?, 
    organization_country = ?, 
    organization_province = ?, 
    organization_city = ?, 
    organization_district = ?, 
    organization_village = ?, 
    organization_alamat = ?, 
    organization_zip_code = ?, 
    organization_nib = ?,
    organization_npwp = ?,
    edited_at = ?, 
    edited_by = ?
WHERE id_dg_user_organization = ?";

$stmt = $db2->prepare($query);
$stmt->bind_param(
    "ssssssssssssssssssssi",
    $organization_name,
    $organization_slug,
    $organization_jenis_usaha,
    $organization_tanggal_beridri,
    $organization_email,
    $organization_telp,
    $organization_logo,
    $organization_nomor_rekening,
    $organization_nama_bank,
    $organization_country,
    $organization_province,
    $organization_city,
    $organization_district,
    $organization_village,
    $organization_alamat,
    $organization_zip_code,
    $organization_nib,
    $organization_npwp,
    $now,
    $id_user,
    $id_dg_user_organization
);

if ($stmt->execute()) {
    echo "Data berhasil diperbarui.";
} else {
    echo "Gagal memperbarui data: " . $stmt->error;
}
?>
