<?
	session_start();

	$success=false;
	$userData="";
	$con="";
	$web=false;

	function createNewToken($id){
		$num=rand($id*10000000000000000,($id+1)*10000000000000000);
		return $num;
	}

	//* RETRIEVING DATA FROM VENDORS *//

	if(isset($_GET['mobileClient']) && isset($_GET['accessToken'])){
		$client=$_GET['mobileClient'];
		$accessToken=$_GET['accessToken'];

		if($client=="google"){
			try{
				require_once "g_config.php";
				$gClient->setAccessToken($accessToken);
				$oAuth = new Google_Service_Oauth2($gClient);
				$userData = $oAuth->userinfo->get();
				if($userData!=""){$success=true;}
			}
			catch(Google_Service_Exception $e){}
		}
		else{
			try{
				require_once "fb_config.php";
				$fbClient -> setDefaultAccessToken((string) $accessToken);
				$res=$fbClient -> get("/me/?locale=en_US&fields=name,email,picture.type(large)");
				$res=$res->getGraphUser();
				$userData=array(
					'name'  => $res -> getField("name"),
					'email' => $res -> getField("email"),
					'picture' => $res -> getField("picture")["url"]
				);
				if($userData!=""){$success=true;}
			}
			catch(Exception $e){}
		}
	}
	else{
		$web=true;
		if(isset($_COOKIE['logintype'])){
			if($_COOKIE['logintype']=="google"){
				if(isset($_GET['code'])){
					require_once "g_config.php";
					try{
						$token=$gClient -> fetchAccessTokenWithAuthCode($_GET['code']);
						$oAuth=new Google_Service_Oauth2($gClient);
						$userData=$oAuth->userinfo->get();
						if($userData!=""){$success=true;}
					}
					catch(Google_Service_Exception $e){}
				}
			}
			else{
				try{
					require_once "fb_config.php";
					$aToken = $fbClient -> getRedirectLoginHelper() -> getAccessToken();
					$fbClient -> setDefaultAccessToken((string) $aToken);
					$res=$fbClient -> get("/me/?locale=en_US&fields=name,email,picture.type(large)");
					$res=$res->getGraphUser();
					$userData=array(
						'name'  => $res -> getField("name"),
						'email' => $res -> getField("email"),
						'picture' => $res -> getField("picture")["url"]
					);
					if($userData!=""){$success=true;}
				}
				catch(Exception $exc){}
			}
		}
		else{
			echo "An error occured. Enable cookies on this site and try loggin in again.";
		}
	}

	// * POST SUCCESSFUL RETRIEVAL OF DATA *//

	if($success===false){
		echo "Error occured";
	}
	else{
		$con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");

		$email=$userData['email'];
		$name=$userData['name'];
		$profilePic=$userData['picture'];
		$id=0;

		$draw_req=mysqli_query($con,"select name,email,profilePic,id from users where email='" . $email . "' limit 1");
		if(mysqli_num_rows($draw_req)>0){
			$draw_req=mysqli_fetch_row($draw_req);
			$name=$draw_req[0];
			$email=$draw_req[1];
			$profilePic=$draw_req[2];
			$id=$draw_req[3];
		}
		else{
			mysqli_query($con,"insert into users (name,email,profilePic) values ('" . $name . "','" . $email . "','" . $profilePic . "')");
			$id=mysqli_fetch_row(mysqli_query($con,"select max(id) from users"))[0];
		}

		$userData=array(
			'name' => $name,
			'email' => $email,
			'profilePic' => $profilePic,
			'id' => $id
		);

		if($web){
			$_SESSION['name']=$userData['name'];
			$_SESSION['id']=$userData['id'];
			$_SESSION['email']=$userData['email'];
			$_SESSION['profilePic']=$userData['profilePic'];
			header("Location: index.php");
		}
		else{
			$tokenQ=mysqli_query($con,"select * from tokens where uid=" . $userData['id']);
			
			if(mysqli_num_rows($tokenQ)>=5){

				$time=time();$id=0;
				for($i=0;$i<mysqli_num_rows($tokenQ);$i++){
					$row=mysqli_fetch_assoc($tokenQ);
					if($row['time']<$time){$time=$row['time'];$id=$row['id'];}
				}
				mysqli_query($con,"delete from tokens where id=" . $id);

			}

			$randToken=createNewToken($userData['id']);
			mysqli_query($con,"insert into tokens (uid,token,time) values (" . $userData['id'] . ",'" . $randToken . "','" . time() . "')");
			echo $randToken . "<>" . $userData['name'] . "<>" . $userData['profilePic'] . "<>" . $userData['email'];
		}
	}
?>