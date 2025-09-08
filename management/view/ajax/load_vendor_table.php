<?php 
    include '../../controller/conn.php';
    session_start();

    $result_head = mysqli_query($db2,"select * from `dg_user` where deleted_at is null and status = 6");
    while($d_head = mysqli_fetch_array($result_head)){
?>
         <tr>
             <td></td>
             <td><img class="shadow" style="width: 100px; border: 1px solid black;"
                     src="img/profile/<?php if($d_head['photo']!=""){echo $d_head['photo'];}else{echo "t0.jpg";} ?>"
                     alt="your image" /></td>
             <td style="text-transform: uppercase;">V<?php if($d_head['id_dg_user']<10){echo 0;} ?><?php echo $d_head['id_dg_user']; ?>-<?php $words = explode(" ", $d_head['nama']); $acronym = "";
                 foreach ($words as $w) {
                 $acronym .= $w[0];
                 }
                 echo $acronym; ?>
             </td>
             
             <td><?php echo $d_head['nama']; ?></td>
             <td><?php echo $d_head['email']; ?></td>
             <td><?php echo $d_head['nomor_hp']; ?></td>
             <td><?php echo $d_head['nomor_rekening']; ?></td>
             <td><?php echo $d_head['bank']; ?></td>
             <td><?php echo $d_head['alamat']; ?></td>           

             <td style="text-align: center;">

             

                 <button class="btn btn-info btn-sm" name="id_ev"
                     style="margin-right: 15px;"
                     data-a="<?php echo $d_head['id_dg_user']; ?>"
                     data-b="<?php echo $d_head['photo']; ?>"
                     data-c="<?php echo $d_head['nama']; ?>"
                     data-e="<?php echo $d_head['email']; ?>"
                     data-f="<?php echo $d_head['nomor_hp']; ?>"
                     data-h="<?php echo $d_head['nomor_rekening']; ?>" 
                     data-i="<?php echo $d_head['bank']; ?>" 
                     data-j="<?php echo $d_head['alamat']; ?>" 
                     data-k="<?php echo $d_head['status']; ?>" 
                     data-l="<?php echo $d_head['username']; ?>"


                     data-toggle="modal"
                     data-target="#modal-edit-vendor" data-backdrop="static"
                     data-keyboard="false">
                     <i class="fas fa-pencil-alt">
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


