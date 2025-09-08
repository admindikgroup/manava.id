<?php
include 'controller/conn.php';


// === Handle Confirm / Reject langsung di halaman ini ===
if (!empty($_GET['action']) && !empty($_GET['id'])) {
    $idRequest = (int) $_GET['id'];
    $action    = $_GET['action'];

    if ($action === 'confirm') {
        $update = $db2->query("UPDATE dg_user_orgz_request SET status='approved' WHERE id=$idRequest");
        if ($update) {
            // update juga user biar masuk organisasi (misalnya update id_dg_user_organization di tabel user)
            $db2->query("
                UPDATE dg_user u
                JOIN dg_user_orgz_request r ON u.id_dg_user = r.id_dg_user
                SET u.id_dg_user_organization = r.id_dg_user_organization
                WHERE r.id = $idRequest
            ");
            echo "<p class='text-success'>Request #$idRequest berhasil di-accept.</p>";
        }
    } elseif ($action === 'reject') {
        $update = $db2->query("UPDATE dg_user_orgz_request SET status='rejected' WHERE id=$idRequest");
        if ($update) {
            echo "<p class='text-danger'>Request #$idRequest ditolak.</p>";
        }
    }
}

// === Ambil ID organisasi ===
$userOrgId = 0;
if (!empty($_SESSION['id_dg_user_organization'])) {
    $userOrgId = (int) $_SESSION['id_dg_user_organization'];
} elseif (!empty($_COOKIE['id_dg_user_organization'])) {
    $userOrgId = (int) $_COOKIE['id_dg_user_organization'];
} elseif (!empty($_GET['org_id'])) {
    $userOrgId = (int) $_GET['org_id'];
}


$pendingRequests = [];
if ($userOrgId > 0) {
    $sql = "
        SELECT 
            r.id, 
            u.id_dg_user AS id_user, 
            u.nama AS user_name, 
            u.email, 
            r.status
        FROM dg_user_orgz_request r
        JOIN dg_user u ON r.id_dg_user = u.id_dg_user
        WHERE r.id_dg_user_organization = $userOrgId
        AND TRIM(LOWER(r.status)) = 'pending'
    ";
    $result = $db2->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $pendingRequests[] = $row;
        }
    }
}
?>

<!-- HTML -->
<div class="card mt-4">
    <div class="card-header bg-dark text-white">Pending Join Requests</div>
    <div class="card-body">
        <?php if ($userOrgId > 0): ?>
            <?php if (count($pendingRequests) == 0): ?>
                <p class="text-muted">Tidak ada request join pending.</p>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Request</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingRequests as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['user_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td>
                                    <a href="?action=confirm&id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Confirm</a>
                                    <a href="?action=reject&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-danger">Organization ID tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</div>
