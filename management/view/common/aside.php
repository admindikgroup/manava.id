<!-- Modal Join Organisasi -->
<div class="modal fade" id="joinOrgzModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Request Join Organisasi</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="joinOrgzForm" method="POST" action="controller/conn_request_ogz.php">
        <div class="modal-body">
          <div class="form-group">
            <label for="slug">Masukkan Slug Organisasi</label>
            <input type="text" class="form-control" name="organization_slug" id="organization_slug" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Kirim Request</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-update-password">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Ubah Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="controller/conn_update_password.php" method="post">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="usernameBaru" class="col-sm-12 col-form-label">Username</label>
                        <div class="col-sm-12">
                            <input type="text" id="usernameBaru" name="usernameBaru" class="form-control" value="<?php echo $username; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordLama" class="col-sm-12 col-form-label">Password Lama</label>
                        <div class="col-sm-12">
                            <input type="password" id="passwordLama" name="passwordLama" class="form-control" autocomplete="off" value="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordBaru" class="col-sm-12 col-form-label">Password Baru</label>
                        <div class="col-sm-12">
                            <input type="password" id="passwordBaru" name="passwordBaru" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Jenis_Warna1" class="col-sm-12 col-form-label">Konfirmasi Password Baru
                            (Ulangi):</label>
                        <div class="col-sm-12">
                            <input type="password" id="passwordBaruK" name="passwordBaruK" class="form-control"
                                required>
                        </div>
                    </div>


                    <input type="hidden" name="username" value="<?php echo $username;?>">
                    <input class="aktif1" type="hidden" name="link" value="<?php echo $first_part;?>">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal-profile">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Harap melengkapi Profile anda !!!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal-update-password2">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Ubah Password</h4>

            </div>
            <form action="controller/conn_update_password.php" method="post">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="usernameBaru" class="col-sm-12 col-form-label">Username</label>
                        <div class="col-sm-12">
                            <input type="text" id="usernameBaru" name="usernameBaru" class="form-control" value="<?php echo $username; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordLama" class="col-sm-12 col-form-label">Password Lama</label>
                        <div class="col-sm-12">
                            <input type="password" id="passwordLama" name="passwordLama" class="form-control" autocomplete="off" value="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordBaru" class="col-sm-12 col-form-label">Password Baru</label>
                        <div class="col-sm-12">
                            <input type="password" id="passwordBaru" name="passwordBaru" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Jenis_Warna1" class="col-sm-12 col-form-label">Konfirmasi Password Baru
                            (Ulangi):</label>
                        <div class="col-sm-12">
                            <input type="password" id="passwordBaruK" name="passwordBaruK" class="form-control"
                                required>
                        </div>
                    </div>


                    <input type="hidden" name="username" value="<?php echo $username;?>">
                    <input class="aktif1" type="hidden" name="link" value="<?php echo $first_part;?>">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<style>
    /* Custom scrollbar styling */
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        background-color:rgb(100, 100, 100);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    .nav-treeview::-webkit-scrollbar {
        width: 5px;
    }

    .nav-treeview::-webkit-scrollbar-track {
        background-color:rgb(100, 100, 100);
    }

    .nav-treeview::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
    }

    .nav-treeview::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    
        ::-webkit-scrollbar {
            width: 10px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background-color:rgb(100, 100, 100);
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        body{
            overflow-x: hidden;
        }

        .img-circle{
            object-fit: cover;
        }
  #organizationSelect {
    
    width: 200px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    background-color: #f9f9f9;
    color: #333;
    transition: border-color 0.3s ease;
  }

  #organizationSelect:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0,123,255,0.5);
  }

  #organizationSelect option {
    padding: 10px;
  }
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="profile.php" class="brand-link" style="margin: auto; text-align: center;">
        <img class="img-circle elevation-2" src="img/profile/<?php if($photo_user!=""){echo $photo_user;}else{echo "t0.jpg";} ?>" style="margin: auto; width: 50px; height: 50px; padding: 5px; ">
        <span class="brand-text font-weight-light">Hi, <?php echo $nama_user; ?></span>
        
    </a>
    <?php include 'select_orgz.php'; ?>

<script>
const userOrgId = "<?php echo $userOrgId; ?>"; // dari PHP

fetch('controller/conn_get_orgz.php')
  .then(response => response.json())
  .then(data => {
    const select = document.getElementById("organizationSelect");
    select.innerHTML = "";

    if (data.length > 0) {
      // user sudah punya orgz → tampilkan semua orgz yang dimilikinya
      data.forEach(org => {
        const option = document.createElement('option');
        option.value = org.id_dg_user_organization;
        option.textContent = org.organization_name;

        if (org.id_dg_user_organization == userOrgId) {
          option.selected = true;
        }

        select.appendChild(option);
      });
    } else {
      // user belum join orgz
      const noOrgOption = document.createElement('option');
      noOrgOption.textContent = "Belum join organisasi";
      noOrgOption.disabled = true;  // biar gak bisa dipilih
      noOrgOption.selected = true;  // default tampil
      select.appendChild(noOrgOption);
    }

    // Tambahkan opsi join & tambah (selalu muncul)
    const joinOption = document.createElement('option');
    joinOption.value = "join_request";
    joinOption.textContent = "+ Join Organisasi dengan Slug";
    select.appendChild(joinOption);

    const addOption = document.createElement('option');
    addOption.value = "add_new";
    addOption.textContent = "+ Tambah Organisasi Baru";
    select.appendChild(addOption);
  });

// Event listener untuk opsi khusus
document.getElementById("organizationSelect").addEventListener("change", function () {
  if (this.value === "join_request") {
    $("#joinOrgzModal").modal("show");
    this.value = ""; // reset biar gak ke-lock
  } 
  else if (this.value === "add_new") {
    window.location.href = "orgz_add.php";
  }
});
</script>




    <!-- Sidebar -->
    <div class="sidebar" style="direction:rtl;">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3" style="direction:ltr;">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2" style="font-size: 15px; margin-bottom: 100px; direction:ltr;">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!--<li class="nav-header">Master Data</li>-->
                <li class="nav-item">
                    <a href="index.php"
                        class="nav-link <?php if ($first_part=="index.php" || $first_part=="") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="mng_ai.php"
                        class="nav-link <?php if ($first_part=="mng_ai.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fab fa-rocketchat"></i>
                        <p>
                            MNG AI
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="task_management.php"
                        class="nav-link <?php if ($first_part=="task_management.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Task Management
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="calendar.php"
                        class="nav-link <?php if ($first_part=="calendar.php" || $first_part=="calendar_event_detail.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Calendar
                        </p>
                    </a>
                </li>

                <hr>

                <?php if($status_user<=4){?>
                <li class="nav-item">
                    <a 
                        class="nav-link <?php if ( $first_part=="kanban.php" || $first_part=="kanban.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fa fa-users-cog"></i>
                        <p>
                            Teamspaces
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="max-height: 200px; overflow-x: auto;">
                        <?php 

                            if($status_user == 1){
                                $result_head = mysqli_query($db2,"SELECT * from `dg_client_project` dcp
                                INNER JOIN dg_client dc
                                ON dcp.id_dg_client = dc.id_dg_client
                                where dcp.deleted_by is null 
                                AND dcp.is_active = 1
                                order by dcp.id_dg_client_project desc");
                            }else{
                                $result_head = mysqli_query($db2,"SELECT dc.nama_client, dcp.id_dg_client_project, dcp.nama_project
                                FROM dg_client_project dcp
                                INNER JOIN dg_client_project_team dcpt
                                    ON dcp.id_dg_client_project = dcpt.id_dg_client_project
                                INNER JOIN dg_client dc
                                    ON dcp.id_dg_client = dc.id_dg_client
                                WHERE dcpt.id_dg_user = $id_user
                                AND dcp.is_active = 1
                                GROUP BY dcp.id_dg_client_project, dcp.nama_project;
                                ");
                            }

                            while($d_head = mysqli_fetch_array($result_head)){
                        ?>
                            <li class="nav-item">
                                <a href="kanban.php?id=<?php echo $d_head['id_dg_client_project']; ?>"
                                    class="nav-link d-flex align-items-center <?php echo ($first_part=="kanban.php" && $d_head['id_dg_client_project'] == $_GET['id']) ? "active" : "noactive"; ?>"
                                    style="gap: 5px;">
                                    
                                    <i class="far fa-circle nav-icon"></i>

                                    <div style="overflow-x: auto; white-space: nowrap;">
                                        <?php echo $d_head['nama_client']; ?> | <?php echo $d_head['nama_project']; ?>
                                    </div>
                                </a>
                            </li>


                        <?php } ?>

                    </ul>
                </li>
                <?php } ?>

                <?php if($status_user<=2){?>
                <li class="nav-item">
                    <a 
                        class="nav-link <?php if ( $first_part=="list_project.php" || $first_part=="jenis_type.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fa fa-sliders-h"></i>
                        <p>
                            Project Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="max-height: 200px; overflow-x: auto;">
                        <li class="nav-item">
                            <a href="list_project.php"
                                class="nav-link <?php if ($first_part=="list_project.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Project</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="jenis_type.php"
                                class="nav-link <?php if ($first_part=="jenis_type.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tamplate Jenis & Type</p>
                            </a>
                        </li>



                    </ul>
                </li>
                <?php } ?>

                
                <?php if($status_user<=4){?>
                <li class="nav-item">
                    <a 
                        class="nav-link <?php if ($first_part=="absensi_report.php" || $first_part=="fee_absensi.php" || $first_part=="calendar_event.php" || $first_part=="calendar_hari_libur.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>
                            Event Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if($status_user<=3){?>
                        <li class="nav-item">
                            <a href="calendar_event.php"
                                class="nav-link <?php if ($first_part=="calendar_event.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Event</p>
                            </a>
                        </li>
                        <?php } if($status_user<=1){?>
                        <li class="nav-item">
                            <a href="calendar_hari_libur.php"
                                class="nav-link <?php if ($first_part=="calendar_hari_libur.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Hari Libur</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="absensi_report.php"
                                class="nav-link <?php if ($first_part=="absensi_report.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Report Absensi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="fee_absensi.php"
                                class="nav-link <?php if ($first_part=="fee_absensi.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fee Absensi Tambahan</p>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
               
                <?php if($status_user<=2){?>

                <li class="nav-item">
                    <a 
                        class="nav-link <?php if ( $first_part=="memo.php" || $first_part=="rab.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Financial Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="max-height: 200px; overflow-x: auto;">
                        <li class="nav-item">
                            <a href="memo.php"
                                class="nav-link <?php if ($first_part=="memo.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Memo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="rab.php"
                                class="nav-link <?php if ($first_part=="rab.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rencana Anggaran Biaya</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <hr>
                <?php } ?>

              

                <?php if($status_user==1){?>
                <li class="nav-item">
                    <a 
                        class="nav-link <?php if ($first_part=="user.php" || $first_part=="user_group.php" || $first_part=="user_vendor.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="max-height: 200px; overflow-x: auto;">
                        
                        <li class="nav-item">
                            <a href="user.php"
                                class="nav-link <?php if ($first_part=="user.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="user_group.php"
                                class="nav-link <?php if ($first_part=="user_group.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Group</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="user_vendor.php"
                                class="nav-link <?php if ($first_part=="user_vendor.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vendor</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="job.php"
                        class="nav-link <?php if ($first_part=="job.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Jobs Management
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="division.php"
                        class="nav-link <?php if ($first_part=="division.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-binoculars"></i>
                        <p>
                            Division Management
                        </p>
                    </a>
                </li>
                <?php } ?>
                <?php if($status_user<=2){?>
                <li class="nav-item">
                    <a href="client.php"
                        class="nav-link <?php if (strpos($first_part, 'client') !== false) {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Client Management
                        </p>
                    </a>
                </li>
                <?php } ?>
                

                <hr>

                <?php if($status_user<=4){?>
                <li class="nav-item">
                    <a 
                        class="nav-link <?php if (strpos($first_part, 'article') !== false) {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fa fa-newspaper"></i>
                        <p>
                            Article Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="article.php"
                                class="nav-link <?php if ($first_part=="article.php" || $first_part=="article_add.php" || $first_part=="article_edit.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Article</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="article_category.php"
                                class="nav-link <?php if ($first_part=="article_category.php") {echo "active"; } else  {echo "noactive";}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category & Tags</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <?php } ?>


                <hr>
                <?php if($status_user==1){?>
                <li class="nav-item">
                    <a href="organization.php"
                        class="nav-link <?php if ($first_part=="organization.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Organization Profile
                        </p>
                    </a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="profile.php"
                        class="nav-link <?php if ($first_part=="profile.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            My Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a  data-toggle="modal" data-target="#modal-update-password" data-backdrop="static"
                        data-keyboard="false"
                        class="nav-link <?php if ($first_part=="ubah_password.php") {echo "active"; } else  {echo "noactive";}?>">
                        <i class="nav-icon fa fa-key"></i>
                        <p>
                            Ubah Password
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="controller/conn_logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php 
    if ($first_part!="mng_ai.php") {
        include "./view/common/chat_ai.php";
    }
?>