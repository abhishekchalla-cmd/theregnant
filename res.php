<?
	$con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");

	if(isset($_GET['login']) && isset($_GET['app'])){
		$err=true;
		$id=$_GET['login'];$app=$_GET['app'];
		if(is_numeric($id) && ($app=="google" || $app=="fb")){
			$column=($app=="google")?"gid":"fbid";
			$q=mysqli_query($con,"select * from users where " . $column . "='" . $id . "' limit 1");
			if(mysqli_num_rows($q)!=0){
				$result=mysqli_fetch_row($q);
				$err=false;
				echo $result[0];
			}
			else{
				$err=false;
				echo "initSignUp";
			}
		}
		if($err===true){echo "err";}
	}

	elseif(isset($_GET['signup']) && isset($_GET['app'])){
		$app=$_GET['app'];
		$err=true;
		if($app=="google" || $app=="fb"){
			$id = isset($_GET['id']);
			$name = isset($_GET['name']);
			$email = isset($_GET['email']);
			$img = isset($_GET['img']);
			if(($id && $name && $email && $img)===true){
				$id=$_GET['id'];
				$name=$_GET['name'];
				$email=$_GET['email'];
				$img=$_GET['img'];
				
				$err=false;
				echo $id . "," . $name . "," . $email . "," . $img;
			}
		}
		if($err===true){echo "err";}
	}
?>