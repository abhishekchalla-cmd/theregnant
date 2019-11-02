<?
	$con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");

	session_start();

	function setsession($q){
		$_SESSION['id']=$q[0];
		$_SESSION['name']=$q[1];
		$_SESSION['email']=$q[2];
		$_SESSION['profilePic']=$q[3];
	}

	$err=true;

	if(isset($_GET['logout'])!==true){
		if(isset($_SESSION['id'])===false && isset($userData['email'])===true){
			$q=mysqli_query($con,"select id,name,email,profilePic from users where email='" . $userData['email'] . "' limit 1");
			if(mysqli_num_rows($q)>0){
				$r=mysqli_fetch_row($q);
				setsession($r);
				$err=false;
			}
			else{
				mysqli_query($con,"insert into users (name,email,profilePic) values ('" . $userData['name'] . "','" . $userData['email'] . "','" . $userData['picture'] . "')");
				setsession(mysqli_fetch_row(mysqli_query($con,"select id,name,email,profilePic from users where id=(select max(id) from users) limit 1")));
			}
		}
		header("Location: index.php");
	}
	else{
		session_destroy();
		header("Location: index.php");
	}
?>