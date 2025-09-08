<?php 
include 'conn.php';
session_start();
$_SESSION['status_up'] = "";

$link = $_POST['link'];
$passwordLama = mysqli_real_escape_string($db2,$_POST['passwordLama']);
$passwordBaru = mysqli_real_escape_string($db2,$_POST['passwordBaru']);
$passwordBaruK = mysqli_real_escape_string($db2,$_POST['passwordBaruK']);
$username = mysqli_real_escape_string($db2,$_POST['username']);
$usernameB = mysqli_real_escape_string($db2,$_POST['usernameBaru']);
$passwordBaru = md5($passwordBaru);
$passwordLama = md5($passwordLama);
$passwordBaruK = md5($passwordBaruK);
echo $passwordLama."<br>";
echo $username."<br>";
$login = mysqli_query($db2,"SELECT * FROM dg_user WHERE username='$username' and password_dg='$passwordLama'");
$cek = mysqli_num_rows($login);
while($d_acc = mysqli_fetch_array($login)){
    $id_user = $d_acc['id_dg_user'];
   }

if($cek > 0){
    if($passwordBaru==$passwordBaruK){


    $stmt1 = $db2->prepare("UPDATE `dg_user` set password_dg=?, username=?, status_login=? where username = ?");
    $stmt1->bind_param("ssss", $passwordBaru, $usernameB, $status, $username);

    $status =2;

    $stmt1->execute();
    $stmt1->close();

    $_SESSION['status'] = "login";
	$_SESSION['daftar'] = "xx";
	$_SESSION['id_user'] = $id_user;
	$_SESSION['username'] = $username;
    $_SESSION['statusX'] = "2";
    $_SESSION['status_up'] = "xx3";
    header("location:../$link");
    }else{
        $_SESSION['status_up'] = "xx2";
        header("location:../$link?pesan=error2");
    }
}else{
    $_SESSION['status_up'] = "xx1";
	header("location:../$link?pesan=error1");
}



?>