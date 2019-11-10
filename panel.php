<?
	session_start();

	$con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");

	$str="";
	$error="";
	$i=1;
	function startCTO($inp){
		global $str;
		global $error;
		$str=str_split($inp);
		$out=convertToObject(1);
		return $out;
	}
	function convertToObject($index){
		//echo "----New Nest----\n";
		global $str;
		global $error;
		global $i;
		$obj=array();
		$var="";
		$val="";
		$vardone=0;
		$open=false;
		$opener="";
		$setdone=false;
		$isarray=false;
		$valarray=array();

		while($i<count($str)){
			$char=$str[$i];
			//echo $char . "||" . $i . "||" . "\n";
			if($vardone==0){
				if($char=="}"){break;}
				elseif($char=="'" || $char=='"'){
					$var=retrieveString();
				}
				elseif(!ctype_alnum($char) && $char!=":"){
					$error="1";break;
					//echo "Not an alphanumeric:" . $char . " \n";
				}
				else{
					if($char==":"){$vardone=1;}
					else{$var=$var . $char;}
					//echo "-> " . $var . "\n";
				}
			}
			else{
				//echo "--> " . $var . " : " . $val . "\n";
				//var_dump($valarray);
				if($setdone){
					//echo "Set Done \n";
					if($char==","){
						$obj[$var]=$val;
						$var="";
						$val="";
						$open=false;
						$vardone=0;
						$opener="";
						$setdone=false;
					}
					elseif($char=="}"){
						$obj[$var]=$val;
						break;
					}
					else{
						//echo "Did not end with a , or } : " . $char . " \n";
						$error="1";
						break;
					}
				}
				else{
					if($open){
						if($char!=$opener){
							$val=$val . $char;
						}
						elseif($char==$opener){
							if($isarray){
								array_push($valarray,$val);
								$val="";
								$open=false;
								$opener="";
							}
							else{
								$setdone=true;
							}
						}
					}
					else{
						if($val==""){
							if($char=="'" || $char=='"'){$open=true;$opener=$char;}
							elseif($char=="{"){
								$i=$i+1;
								$val=convertToObject($i);
								//var_dump($val);
								$setdone=true;
							}
							elseif($char=="["){
								$i=$i+1;
								$val=retrieveArray($i);
								$setdone=true;
							}
							elseif(is_numeric($char)){$val=$val . $char;}
							else{
								//echo "Invalid data type: " . $char . "\n";
								$error="1";break;
							}
						}
						else{
							if(is_numeric($char)){$val=$val . $char;}
							else{
								if($char=="," || $char=="}"){
									$i=$i-1;
									$setdone=true;
								}
								else{
									//echo "Invalid data: " . $char . "\n";
									$error="1";
									break;
								}
							}
						}
					}
				}
			}
			$i++;
		}

		// //echo "----Nest complete----\n";
		if($error!=""){$obj="";}
		return $obj;
	}

	function retrieveArray($ind){
		//echo "----Array Nest Start----\n";
		global $i;
		global $str;
		global $error;
		$obj=array();
		$val="";
		$open=false;
		$opener="";

		while($i<count($str)){
			$char=$str[$i];
			//echo $char . "\n";
			if($val==""){
				if($char=='"' || $char=="'"){$open=true;$opener=$char;}
				elseif($char=="{"){
					$i++;
					$val=convertToObject($i);
				}
				elseif($char=="["){
					$i++;
					$val=retrieveArray($i);
				}
				elseif($char=="]"){
					break;
				}
				elseif(is_numeric($char)){$val=$char;}
				else{
					if($open){$val=$val . $char;}
					else{
						//echo "Not starting with '," . '",{,[ or number' . "\n";
						$error="1";
						break;
					}
				}
			}
			else{
				if(!$open){
					if($char==","){
						array_push($obj,$val);
						$val="";
					}
					elseif($char=="]"){array_push($obj,$val);break;}
					elseif(is_numeric($char)){$val=$val . $char;}
					else{
						$error="1";
						break;
					}
				}
				else{
					if($open && $char==$opener){
						$open=false;
						$opener="";
					}
					else{
						$val=$val . $char;
					}
				}
			}
			$i++;
		}

		if($error!=""){$obj="";}
		//echo "----Array nest complete---- \n";
		return $obj;
	}

	function retrieveString(){
		global $i;
		global $str;
		global $error;
		$val="";
		$open=false;
		$opener="";
		while($i<count($str)){
			$char=$str[$i];
			if($open){
				if($char==$opener){
					break;
				}
				else{
					$val = $val . $char;
				}
			}
			else{
				if($char=="'" || $char=='"'){$open=true;$opener=$char;}
				else{
					$error="1";
					break;
				}
			}

			$i++;
		}
		return $val;
	}

	$allowed=false;
	if(isset($_SESSION['id'])){
		if(mysqli_num_rows(mysqli_query($con,"select * from whitelist where email='" . $_SESSION['email'] . "'"))>0){
			$allowed=true;
		}
	}

	if($allowed){
		if(isset($_GET['data'])){
			$data=$_GET['data'];
			$data=startCTO($data);
			if(isset($data['review_visible'])){
				$rev=$data['review_visible'];
				$done="";
				for($i=0;$i<count($rev);$i++){
					$cur=$rev[$i];
					if(is_numeric($cur[0]) && is_numeric($cur[1])){
						$r=mysqli_query($con,"update reviews set visible=" . $cur[1] . " where uid=" . $cur[0]);
						if(!$r){$done=$done . "," . $cur[0];}
					}
				}
				if($done==""){$done="review=success";}
				else{$done="review=fail&ids=" . $done;}
				header("Location: panel.php?" . $done);
			}
		}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><? echo $_SESSION['name']; ?> - The Regnant: Panel</title>
		<meta name="content-type" content="text/html:charset=utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<style>
			@font-face{font-family:montserrat;src:url('fonts/Montserrat-Regular.ttf');}
			@font-face{font-family:playfair;src:url('fonts/PlayfairDisplay-Regular.ttf');}
			@font-face{font-family:playfairBold;src:url('fonts/PlayfairDisplay-Bold.ttf');}
			@font-face{font-family:roboto;src:url('g-signin/roboto/Roboto-Medium.ttf');}
			@font-face{font-family:bahnschrift;src:url('fonts/bahnschrift.ttf');}
			body{margin:0;padding:0;font-family:montserrat;}

			input[type=submit],button{border:0;background:#caa92b;color:#fff;padding:10px;font-family:montserrat;font-size:14px;cursor:pointer;text-transform:uppercase;width:200px;border-radius:10px;}

			.container{width:100%;}
			.title{padding:20px;font-family:playfairBold;font-size:30px;text-transform:uppercase;background:#e1e1e1;color:#caa92b;}
			.content{width:100%;}
			.content table{width:100%;margin-bottom:50px;border:1px solid #c1c1c1;border-bottom:0;border-right:0;}
			.content td{padding:20px;color:#7a7a7a;border-right:1px solid #c1c1c1;border-bottom:1px solid #c1c1c1;}
			tr.head td{font-weight:bold;color:#3a3a3a;}
			.content img{width:150px;margin:20px;border-radius:150px;}
			.submitDiv{padding-bottom:50px;}
		</style>
	</head>
	<body>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script>
			var tosend={
				"review_visible":[]
			};
			function setVisibility(arr,ele){
				var found=false;
				tosend.review_visible.map((e) => {
					if(e[0]==arr[0]){e[1]=arr[1];found=true;}
					return e;
				});
				if(!found) tosend.review_visible.push(arr);

				ele=$(ele);
				if(arr[1]=="1"){
					ele.html("Make invisible");
				}
				else{
					ele.html("Make visible");
				}

				ele.attr("onclick","setVisibility(["+arr[0]+","+((arr[1]+1)%2)+"],this)");
			}

			function submitForm(){
				$(".data").val(JSON.stringify(tosend));
				return true;
			}
		</script>
		<div class="container" align="center">
			<div class="title" align="center">The Regnant - Panel</div>
			<div class="content" align="center">
				<table cellspacing="0" cellpadding="0">
					<tr class="head">
						<td align="left">Picture/Name</td>
						<td align="left">Review</td>
						<td align="left">Date & Time</td>
						<td align="left">Location</td>
						<td align="left">Visibility</td>
					</tr>
					<?
						$req=mysqli_query($con,"select * from reviews");
						for($i=0;$i<mysqli_num_rows($req);$i++){
							$row=mysqli_fetch_assoc($req);
							$uid=$row['uid'];
							$message=$row['message'];
							$date=$row['_date'];
							$time=$row['_time'];
							$location=$row['location'];
							$visible=$row['visible'];
							$perReq=mysqli_fetch_row(mysqli_query($con,"select name,profilePic from users where id=" . $uid));
							$name=$perReq[0];
							$picture=$perReq[1];
					?>
					<tr>
						<td align="middle" valign="middle">
							<img src="<? echo $picture; ?>" class="dp" /><br />
							<? echo $name; ?>
						</td>
						<td align="left" valign="middle"><? echo $message; ?></td>
						<td align="left" valign="middle"><? echo $date . " @ " . $time; ?></td>
						<td align="left" valign="middle"><? echo $location; ?></td>
						<td align="left" valign="middle">
							<button onclick='setVisibility([<? echo $uid; ?>,<? echo ($visible=="1")?"0":"1"; ?>],this)'><? echo ($visible=="1")?"Make invisible":"Make visible"; ?></button>
						</td>
					</tr>
					<?
						}
					?>
				</table>
				<div class="submitDiv" align="center">
					<form action="panel.php" method="get" class="form" onsubmit="submitForm()">
						<input type="hidden" name="data" class="data" />
						<button onclick="location.href='panel.php'">Reset changes</button> <input type="submit" value="Save Changes" />
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?
	}
	else{
		echo "<h1>500: Access denied!</h1>";
	}
?>