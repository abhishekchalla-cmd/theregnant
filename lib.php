<?
	session_start();
	$web=false;
	$con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");

	require_once "PHP_Library/PHP_LIB_1.php";

	function updateuserdetails($userinfo,$id){
		global $con;
		$status=false;
		if(count($userinfo)>0){
			$phone=(isset($userinfo['phone']) && is_numeric($userinfo['phone']))?", phone='" . $userinfo['phone'] . "'":"";
			$address=(isset($userinfo['address']))?", address='" . sanitize($userinfo['address']) . "'":"";

			if(mysqli_query($con,"update users set col=0" . $phone . $address . " where id=" . $id)){
				$status=true;
			}
		}
		return $status;
	}

	$id=0;
	$valid=false;
	$status=false;

	if(isset($_GET['token'])){
		$token=$_GET['token'];
		if(is_numeric($token) && isset($_GET['request'])){
			$request=$_GET['request'];
			$req=mysqli_query($con,"select * from tokens where token=" . $token);
			if(mysqli_num_rows($req)>0){
				$id=mysqli_fetch_assoc($req)['uid'];
				$valid=true;
			}
		}
	}
	else{
		$web=true;
		if(isset($_SESSION['id'])){
			$valid=true;
			$id=$_SESSION['id'];
		}
	}

	if(isset($_GET['request']) && $valid){
		$request=$_GET['request'];
		if($request=="update" && isset($_GET['userinfo'])){
			$userinfo=$_GET['userinfo'];
			$userinfo=startCTO($userinfo);
			$status=updateuserdetails($userinfo,$id);
		}
	}

	if(!$status){echo "error";}
?>