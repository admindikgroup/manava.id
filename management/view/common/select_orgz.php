<?php

include __DIR__ . "/../../controller/conn.php";

// Pastikan user sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header("Location: ../../login.php");
    exit();
}

// Ambil data user dari session
$userId    = $_SESSION['id_user'] ?? null;
$userOrgId = $_SESSION['id_dg_user_organization'] ?? null;

$optionHtml = "<option value=''>-- Pilih Organisasi --</option>";

// Kalau userId ada, ambil semua organisasi dari DB
if ($userId) {
    $res = $db2->query("SELECT id_dg_user_organization, organization_name FROM dg_user_organization");
    while ($row = $res->fetch_assoc()) {
        $selected = ($row['id_dg_user_organization'] == $userOrgId) ? "selected" : "";
        $optionHtml .= "<option value='{$row['id_dg_user_organization']}' {$selected}>" .
                       htmlspecialchars($row['organization_name'], ENT_QUOTES, 'UTF-8') .
                       "</option>";
    }
}
?>

<div style="display:flex; justify-content:center;">
    <select id="organizationSelect"
            name="organizationSelect"
            class="form-control form-control-sm"
            style="width:220px; text-align:center; text-align-last:center;">
        <?= $optionHtml ?>
    </select>
</div>
