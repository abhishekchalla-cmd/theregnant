<?
	session_start();

	require_once 'fb_config.php';

	$email="";
	$userData;
	try{
		$accessToken = $fbClient -> getRedirectLoginHelper() -> getAccessToken();
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
		echo $exc;
	}

	include("handleToken.php");
?>