<?

	//* STRING OBJECT TO PHP OBJECT CONVERTER STARTS *//

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

	//* STRING OBJECT TO PHP OBJECT CONVERTER ENDS *//

	//* CODE SANITIZER STARTS *//

	function sanitize($txt){
		$txt=str_split($txt);
		for($i=0;$i<count($txt);$i++){
			$char=$txt[$i];
			if($char=='"'){$txt[$i]='&#34;';}
			elseif($char=="'"){$txt[$i]='&#39;';}
			elseif($char=='='){$txt[$i]='&#61;';}
			elseif($char=='`'){$txt[$i]='&#96;';}
			else{}
		}
		$txt=join("",$txt);
		return $txt;
	}

	//* CODE SANITIZER ENDS *//

?>