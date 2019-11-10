<?
	session_start();

	function checkINP($inp,$ext){
		$tr=true;

		if($ext=="null" && $inp=="") $tr=false;

		$ref=array("=","'",'"',";");

		$inp=str_split($inp);
		for($i=0;$i<count($inp);$i++){
			if(in_array($inp[$i],$ref)) $tr=false;
		}
		return $tr;
	}

	$con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");

	if(isset($_GET['type'])){

		$type=$_GET['type'];

		if($type=="inforequest"){

			$email="";
			$firstname="";
			$lastname="";
			$message="";
			$phone="";

			try{
				$email=$_POST['email'];
				$firstname=$_POST['fname'];
				$lastname=$_POST['lname'];
				$message=$_POST['message'];
				$phone=$_POST['phone'];
			}
			catch(Exception $e){
				echo $e;
			}

			if(checkINP($email,"null") && checkINP($firstname,"null") && checkINP($lastname,"null") && checkINP($message,"null")){
				mysqli_query($con,"insert into queries (fname,lname,phone,email,message,_date,_time) values ('".$firstname."','".$lastname."','".$phone."','".$email."','".$message."','".date('y-m-d')."','".date('H:m:s')."')");
				header("Location: index.php?inforequest=ok");
			}
			else{
				header("Location: index.php?inforequest=notok");
			}
		}

		elseif($type=="review"){
			if(isset($_POST['review'])){
				$review=$_POST['review'];
				if(checkINP($review,"null") && isset($_SESSION['id'])){
					$id=$_SESSION['id'];
					$message=$review;
					$date=date('y-m-d');
					$time=date('H:m:s');
					$location="";
					mysqli_query($con,"insert into reviews (uid,message,_date,_time,location) values (".$id.",'".$message."','".$date."','".$time."','".$location."')");
					header("Location: index.php?reviewRequest=ok");
				}
				else{
					header("Location: index.php?reviewrequest=notok");
				}
			}
		}
	}
?>