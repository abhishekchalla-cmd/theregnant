<?
	require_once "google-api/vendor/autoload.php";
	include("location.php");

	$gClient = new Google_Client();
	$gClient -> setClientId("435629484672-apu166vqv9g6sfd8gk0l8sp3mbiksdni.apps.googleusercontent.com");
	$gClient -> setClientSecret("wydIblM8y1o3PgXGRZCQS-NW");
	$gClient -> setApplicationName("The Regnant");
	$gClient -> setRedirectUri($location . "authenticate.php");
	$gClient -> addScope("https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email");
?>