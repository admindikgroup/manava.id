<?php 
    include '../../controller/conn.php';
    session_start();

    $result_head = mysqli_query($db2,"SELECT * FROM `dg_user` WHERE deleted_at IS NULL AND status < 6");
    while($d_head = mysqli_fetch_array($result_head)){
?>
    <tr>
        <td></td>
        <td><img class="shadow" style="width: 100px; border: 1px solid black;"
            src="img/profile/<?php echo ($d_head['photo'] != "") ? $d_head['photo'] : 't0.jpg'; ?>" /></td>
        <td style="text-transform: uppercase;">DIK<?php if($d_head['id_dg_user']<10){echo 0;} ?><?php echo $d_head['id_dg_user']; ?>-<?php 
            $words = explode(" ", $d_head['nama']); $acronym = "";
            foreach ($words as $w) { $acronym .= $w[0]; }
            echo $acronym;
        ?></td>
        <td><?php echo $d_head['nama']; ?></td>
        <td><?php echo ($d_head['jenis_kelamin'] == "L") ? "Laki-Laki" : (($d_head['jenis_kelamin'] == "P") ? "Perempuan" : "-"); ?></td>
        <td><?php echo $d_head['nama_panggilan']; ?></td>
        <td><?php echo $d_head['username']; ?></td>
        <td>
            <p style="display:none;"><?php echo date_format(date_create($d_head['ulang_tahun']),"Y-m-d"); ?></p>
            <?php echo ($d_head['ulang_tahun']) ? date_format(date_create($d_head['ulang_tahun']),"d F Y") : "-"; ?>
        </td>
        <td><?php echo $d_head['email']; ?></td>
        <td><?php echo $d_head['email_dg']; ?></td>
        <td><?php echo $d_head['nomor_hp']; ?></td>
        <td><?php echo $d_head['jabatan']; ?></td>
        <td><?php echo $d_head['mbti']; ?></td>
        <td><?php echo $d_head['nomor_rekening']; ?></td>
        <td><?php echo $d_head['bank']; ?></td>
        <td><?php echo $d_head['alamat']; ?></td>
        <td><?php echo $d_head['quotes']; ?></td>
        <td>
            <?php
            $statusList = [1 => "Super Admin", 2 => "Head of Division", 3 => "Project Manager", 4 => "Staff", 5 => "Pasive / Ex-Staff"];
            echo $statusList[$d_head['status']] ?? "-";
            ?>
        </td>
        <td>
            <?php
            if ($d_head['photo'] == "" || $d_head['nama'] == "" || $d_head['jenis_kelamin'] == "" ||
                $d_head['ulang_tahun'] == "" || $d_head['email'] == "" || $d_head['nomor_hp'] == "" ||
                $d_head['jabatan'] == "" || $d_head['nomor_rekening'] == "" || $d_head['bank'] == "" ||
                $d_head['alamat'] == "" || $d_head['status'] == "" || $d_head['username'] == "" ||
                $d_head['nama_panggilan'] == "" || $d_head['mbti'] == "" || $d_head['quotes'] == "") {
                echo "<b style='color:red;'>Tidak Lengkap</b>";
            } else {
                echo "Lengkap";
            }
            ?>
        </td>
        <td>
            <?php
            if ($d_head['password_dg'] == "f213094f59b8ef4da15817086ca6e6c2") {
                echo "<b style='color:red;'>Default</b>";
            } else {
                echo "Change";
            }
            ?>
        </td>
        <td style="text-align: center;">

            <button class="btn btn-success btn-sm" data-backdrop="static"
                style="margin-right: 15px;" <?php if($_SESSION['priv']!=1){ echo "disabled";} ?>
                data-keyboard="false" title="Login Profile" 
                onclick="redirectToProfile(<?php echo $d_head['id_dg_user']; ?>)">
                <i class="fas fa-unlock">
                </i>
            </button>
            
            <button class="btn btn-info btn-sm" name="id_ev"
                style="margin-right: 15px;"
                data-a="<?php echo $d_head['id_dg_user']; ?>"
                data-b="<?php echo $d_head['photo']; ?>"
                data-c="<?php echo $d_head['nama']; ?>"
                data-d="<?php echo $d_head['ulang_tahun']; ?>"
                data-e="<?php echo $d_head['email']; ?>"
                data-f="<?php echo $d_head['nomor_hp']; ?>"
                data-g="<?php echo $d_head['jabatan']; ?>"
                data-h="<?php echo $d_head['nomor_rekening']; ?>" 
                data-i="<?php echo $d_head['bank']; ?>" 
                data-j="<?php echo $d_head['alamat']; ?>" 
                data-k="<?php echo $d_head['status']; ?>" 
                data-l="<?php echo $d_head['username']; ?>"

                data-m="<?php echo $d_head['nama_panggilan']; ?>"
                data-n="<?php echo $d_head['mbti']; ?>"
                data-o="<?php echo $d_head['quotes']; ?>"
                data-p="<?php echo $d_head['jenis_kelamin']; ?>"

                data-q="<?php echo $d_head['email_dg']; ?>"
                
                data-toggle="modal"
                data-target="#modal-edit-header" data-backdrop="static"
                data-keyboard="false">
                <i class="fas fa-pencil-alt">
                </i>
            </button>

            <button class="btn btn-warning btn-sm" data-backdrop="static"
                style="margin-right: 15px;"
                data-keyboard="false" title="Reset Password"
                data-c="<?php echo $d_head['id_dg_user']; ?>"
                data-v="<?php echo $d_head['nama']; ?>"
                data-toggle="modal" data-target="#modal-reset">
                <i class="fas fa-key">
                </i>
            </button>
                                        
            <button class="btn btn-danger btn-sm" data-backdrop="static"
            <?php 
            $cek2=0;
            $owner_task = $d_head['id_dg_user'];
            $client_row = mysqli_query($db2,"SELECT * FROM dg_task
            WHERE owner_task = $owner_task");
            $cek2 = mysqli_num_rows($client_row);
            if($cek2!=0){ echo "disabled";}
            ?>
                data-keyboard="false" title="Delete User"
                data-c="<?php echo $d_head['id_dg_user']; ?>"
                data-v="<?php echo $d_head['nama']; ?>"
                data-toggle="modal" data-target="#modal-cancel">
                <i class="fas fa-trash">
                </i>
            </button>
            
        </td>
    </tr>
<?php } ?>
