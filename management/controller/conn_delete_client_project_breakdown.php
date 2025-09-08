<?php 
include 'conn.php';
session_start();
   

    $id_dg_client_project_breakdown = mysqli_real_escape_string($db2,$_POST['id_dg_client_project_breakdown']);

    $result_head = mysqli_query($db2,"select * from `dg_client_project_breakdown_rab` where id_dg_client_project_breakdown = $id_dg_client_project_breakdown");
    while($d_head = mysqli_fetch_array($result_head)){

        $id_dg_rab_detail = $d_head['id_dg_rab_detail'];
        
        $query1 = "DELETE FROM dg_rab_detail WHERE id_dg_rab_detail = $id_dg_rab_detail";
        $result1 = mysqli_query($db2, $query1);
                    
                    
        // Cek apakah ID tersedia atau tidak
        if ($result1) {
            echo 'Berhasil';
        } else {
            echo 'Error: ' . mysqli_error($db2);
        }
            
     }

     $query2 = "DELETE FROM dg_client_project_breakdown_rab WHERE id_dg_client_project_breakdown = $id_dg_client_project_breakdown";
     $result2 = mysqli_query($db2, $query2);
                 
                 
     // Cek apakah ID tersedia atau tidak
     if ($result2) {
         echo 'Berhasil';
     } else {
         echo 'Error: ' . mysqli_error($db2);
     }

     $query3 = "DELETE FROM dg_client_project_breakdown WHERE id_dg_client_project_breakdown = $id_dg_client_project_breakdown";
     $result3 = mysqli_query($db2, $query3);
                 
                 
     // Cek apakah ID tersedia atau tidak
     if ($result3) {
         echo 'Berhasil';
     } else {
         echo 'Error: ' . mysqli_error($db2);
     }



    // Tutup koneksi ke database
    mysqli_close($db2);

	



?>