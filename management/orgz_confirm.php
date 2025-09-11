<?php
session_start();
include 'controller/conn.php';

// === Handle Confirm Submit ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_submit'])) {
    $idRequest = (int) $_POST['id_request'];
    $statusUser = (int) $_POST['status_user']; // 1-5

    // Update request jadi approved
    $stmt = $db2->prepare("UPDATE dg_user_orgz_request SET status='approved' WHERE id=?");
    $stmt->bind_param("i", $idRequest);
    if ($stmt->execute()) {
        // Update user: masukkan ke orgz & set status
        $stmt2 = $db2->prepare("
            UPDATE dg_user u
            JOIN dg_user_orgz_request r ON u.id_dg_user = r.id_dg_user
            SET u.id_dg_user_organization = r.id_dg_user_organization,
                u.status = ?
            WHERE r.id = ?
        ");
        $stmt2->bind_param("ii", $statusUser, $idRequest);
        $stmt2->execute();
        header("Location: ".$_SERVER['PHP_SELF']."?msg=approved");
        exit;
    }
}

// === Handle Reject ===
if (!empty($_GET['action']) && $_GET['action']==='reject' && !empty($_GET['id'])) {
    $idRequest = (int) $_GET['id'];
    $stmt = $db2->prepare("UPDATE dg_user_orgz_request SET status='rejected' WHERE id=?");
    $stmt->bind_param("i", $idRequest);
    if ($stmt->execute()) {
        header("Location: ".$_SERVER['PHP_SELF']."?msg=rejected");
        exit;
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
        WHERE r.id_dg_user_organization = ? 
          AND TRIM(LOWER(r.status)) = 'pending'
    ";
    $stmt = $db2->prepare($sql);
    $stmt->bind_param("i", $userOrgId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pendingRequests[] = $row;
    }
}
?>

<div class="card mt-4">
  <div class="card-header bg-dark text-white">Pending Join Requests</div>
  <div class="card-body">

    <?php if (!empty($_GET['msg'])): ?>
      <div class="alert alert-success">
        <?= $_GET['msg']==='approved' ? 'Request berhasil disetujui!' : 'Request ditolak.' ?>
      </div>
    <?php endif; ?>

    <?php if ($userOrgId > 0): ?>
      <?php if (count($pendingRequests)===0): ?>
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
              <button 
                class="btn btn-success btn-sm" 
                data-bs-toggle="modal" 
                data-bs-target="#confirmModal" 
                data-id="<?= $row['id'] ?>">
                Confirm
              </button>
              <a href="?action=reject&id=<?= $row['id'] ?>" 
                 class="btn btn-danger btn-sm">Reject</a>
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

<!-- === Modal Bootstrap === -->
<div class="modal fade" id="confirmModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Set Status User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_request" id="id_request">
        <div class="mb-3">
          <label class="form-label">Pilih Status</label>
          <select class="form-select" name="status_user" required>
            <option value="">--Pilih Status--</option>
                                                <option value="4">Staff (Read Task)</option>
                                                <option value="3">Project Manager (Task Management)</option>
                                                <option value="2">Head of Division (Task & Client Management)</option>
                                                
                                                <option value="1">Super Admin (All Management)</option>
                                                <option value="5">Pasive / Ex-Staff</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="confirm_submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
// Kirim id ke modal
const confirmModal = document.getElementById('confirmModal');
confirmModal.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const id = button.getAttribute('data-id');
  document.getElementById('id_request').value = id;
});
</script>
