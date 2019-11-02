<?
	session_start();

	require_once "fb_config.php";

	if(isset($_GET['accessToken'])){
		try{
			$accessToken=$_GET['accessToken'];
			$fbClient -> setDefaultAccessToken((string) $accessToken);
			$res=$fbClient -> get("/me/?locale=en_US&fields=name,email,picture.type(large)");
			$res=$res->getGraphUser();
			$email=$res -> getField("email");
			$userData=array(
				'name'  => $res -> getField("name"),
				'email' => $res -> getField("email"),
				'picture' => $res -> getField("picture")["url"]
			);
		}
		catch(Exception $exc){
			echo "An error occured";
		}
	}
	else{
		echo "No access token passed";
	}
?>