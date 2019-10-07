<?
	session_start();

	require_once "g_config.php";
	require_once "fb_config.php";

	$usrext=(isset($_SESSION['id'])===true)?true:false;

	$gLoginUrl=$gClient -> createAuthUrl();
	$fbLoginUrl=$fbClient -> getRedirectLoginHelper() -> getLoginUrl("http://localhost/fb-login-complete.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>The Regnant</title>
		<meta name="content-type" content="text/html:charset=utf-8" />
		<meta name="description" content="The Regnant home page" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<link href="icon.ico" rel="icon" type="image/x-icon" />
		<style>
			@font-face{font-family:montserrat;src:url('fonts/Montserrat-Regular.ttf');}
			@font-face{font-family:playfair;src:url('fonts/PlayfairDisplay-Regular.ttf');}
			@font-face{font-family:playfairBold;src:url('fonts/PlayfairDisplay-Bold.ttf');}
			@font-face{font-family:roboto;src:url('g-signin/roboto/Roboto-Medium.ttf');}
			body{font-family:montserrat;margin:0;padding:0;font-size:14px;text-transform:uppercase;}
			a:link,a:visited{text-decoration:none;color:#e6b624;}
			.container{width:100%;}
			.titleBar{width:100%;display:table;padding-bottom:10px;}
				.titleBlock{float:left;height:100%;display:table-cell;margin-left:30px;margin-top:30px;}
					.titleBlock a:link,.titleBlock a:visited{
						font-family:playfair;color:#e6b624;font-size:25px;text-transform:uppercase;
					}
					.titleBlock img{width:50px;margin-right:10px;}
				.optionsBlock{float:right;color:#e6b624;height:100%;display:table-cell;padding-top:20px;font-size:12px;margin-right:30px;margin-top:30px;}
					.optionsBlock img{width:20px;margin-right:5px;}
			.gallery{width:100%;height:280px;}
				.gallery .slideShow{height:100%;background:url('images/home.jpg');background-size:100% auto;background-position:45% 45%;}
				.gallery .overlay{position:relative;top:-100%;padding-top:50px;padding-bottom:50px;}
					.gallery .overlay .title,.gallery .overlay .para,.gallery .overlay .link{margin-top:20px;color:#e6b624;margin-bottom:10px;margin-left:50px;}
					.gallery .overlay .title{margin-top:0;font-family:playfairBold;text-transform:uppercase;font-size:30px;}
					.para{width:300px;font-size:12px;text-align:left;text-transform:none;display:inline-block;}
					.gallery a:link,.gallery a:visited{font-size:12px;color:#fff;}
			.comps{position:relative;top:-10px;}
				.comps a:link,.comps a:visited{padding:15px;padding-left:40px;padding-right:40px;background:#e6b624;color:#fff;box-shadow:5px 5px 10px rgba(0,0,0,0.5);}
			.footer{padding-top:50px;background:#e1e1e1;margin-top:-20px;width:100%;padding-bottom:20px;}
				.footer img{width:25px;border:2px solid #e6b624;padding:4px;margin-left:10px;margin-right:10px;}
				.footer span{font-size:12px;text-transform:none;}

			.viewer{width:100%;height:100%;position:fixed;top:0;left:0;background:linear-gradient(90deg,#1a1a1a,#4a4a4a);display:none;}
				.viewer .left,.viewer .canvas,.viewer .right{display:table-cell;height:100%;vertical-align:middle;}
				.viewer .left,.viewer .right{width:8%;font-size:30px;font-weight:bold;background:#fff;}
				.viewer .canvas{width:84%;}
				.viewer .canvas img{max-height:95%;max-width:100%;}
				.viewer .left img,.viewer .right img{height:30%;opacity:0.2;}
				.viewer .closer{position:fixed;top:20px;right:20px;padding:10px;font-size:15px;font-weight:bold;}
				.closer a:link,.closer a:visited{color:#2a2a2a;}
				.closer div,.contactContainer .closer div{padding:15px;border-radius:30px;background:#9a9a9a;}
				.viewer .notice{position:fixed;bottom:0;left:0;width:100%;background:#e6b624;color:#fff;font-size:10px;}
				.viewer .loader{height:100%;width:100%;vertical-align:middle;display:none;}

			.contactContainer,.signin{position:fixed;height:100%;width:100%;top:0;left:0;background:url('icon_files/back.png');display:none;}
				.contactContainer .dailogBox,.signin .dailogBox{padding:20px;background:#fff;box-shadow:5px 5px 10px rgba(0,0,0,0.5);width:300px;}
				.contactContainer .closer div,.signin .closer div{width:100px;}
				.contactContainer .closer a:link,.contactContainer .closer a:visited,.signin .closer a:link,.signin .closer a:visited{color:#fff;}
				.contactContainer .title,.signin .title{font-family:playfairBold;font-size:20px;color:#e6b624;}
				.contactContainer table{margin-top:20px;margin-bottom:20px;font-size:12px;}
				.contactContainer .cleft,.signin .cleft{font-weight:bold;}
				.signin .closer{margin-top:20px;}

			#google-signin{border:0;padding:10px;background:#fff;font-family:roboto;font-size:16px;width:254px;color:rgba(0,0,0,0.54);border-radius:5px;box-shadow:1px 1px 2px rgba(0,0,0,0.54);cursor:pointer;}
			#google-signin img{width:20px;margin-right:10px;}
			#google-signin,#fb-signin{margin:5px;}

			.l1,.l2{overflow:hidden;}
			.l1{display:block;}
			.l2{display:none;}
			.gallery .overlay .aligner{padding:0;margin:0;text-align:left;}

			@media screen and (max-width: 632px){
				.gallery .overlay .aligner{text-align:center;}
				.titleBlock{width:100%;margin-left:0;margin-right:0;margin-bottom:-15px;}
				.titleBlock img{margin-right:0px;}
				.optionsBlock{width:100%;margin-left:0;margin-right:0;margin-bottom:10px;}
				.gallery .overlay{padding-top:50px;padding-bottom:50px;}
				.gallery .overlay .title,.gallery .overlay .para,.gallery .overlay .link{margin:10px;text-align:center;}
				.gallery .overlay .title{font-size:20px;}
				.viewer .left,.viewer .right{width:15%;display:none;}
				.viewer .canvas{width:100%;}
				.viewer .canvas img{width:100%;}
				.footer{padding-top:60px;padding-bottom:30px;}
				.l1, .l2{width:100%;}
			}

			@media screen and (max-width: 841px){
				.gallery .slideShow {background-size:auto 100%;}
			}

		</style>
	</head>
	<body>
		<div class="container" align="center">
			
			<div class="titleBar" align="center">
				<div class="titleBlock" align="center">
					<a href="index.html"><img src="images/title2.png" valign="middle" /> The Regnant</a>
				</div>
				<div class="optionsBlock" align="center">
					<a href="#!"><img src="icon_files/search.png" valign="middle" /> Explore</a>&nbsp;&nbsp; | &nbsp;&nbsp;
					<a href="#!" onclick="togglePopup('viewer','table')">Gallery</a>&nbsp;&nbsp; | &nbsp;&nbsp;
					<a href="#!" onclick="togglePopup('contactContainer','block')">Contact us</a>&nbsp;&nbsp; | &nbsp;&nbsp;
					<? if($usrext){ ?>
					<a href="handleToken.php?logout=">Logout</a>
					<? }else{ ?>
					<a href="#!" onclick="togglePopup('signin','block')">Login</a>
					<? } ?>
				</div>
			</div>

			<div class="gallery" align="center">
				<div class="slideShow" align="center">
				</div>
				<div class="overlay" align="left">
					<div class="l1" style="margin:0;padding:0">
						<div class="title" align="left">
							<? if($usrext===false){ ?>Enrobed in Luxury.<br>Coming Soon<? }else{ ?>
							Welcome,<br> <? echo $_SESSION['name']; ?>!<? } ?>
						</div>
						<div class="aligner"><div class="para" align="left">
							Discover a world of exquisite luxury, unparalleled comfort, unforgettable experiences, grand spaces and personalised service! #MyRegnant
						</div></div>
						<div class="link" align="left">
							<a href="#!" onclick="exmore()">Explore more &gt;</a>
						</div>
					</div>
					<div class="l2" style="margin:0;padding:0">
						<div class="aligner">
							<div class="para" align="left">
								A tailor-made stay just for you. The hotel offers a wider choice of suites and residences than almost any other in the City of the Nawabs, providing guests with more space and flexibility to accommodate families, state delegations or top business executives. Our beautifully designed suites and residences feature expansive living areas to relax or work. Our acclaimed events team attend to all personal requirements, ensuring bespoke experiences are easily and effortlessly arranged. This admired address will play host to truly dazzling weddings, private events and parties and milestone celebrations.
							</div>
						</div>

						<div class="link" align="left">
							<a href="#!" onclick="exmore()">&lt; Show less</a>
						</div>
					</div>

					<div id="platform"></div>
				</div>
			</div>

			<div class="comps" align="center">
				<div class="trial" align="center">
					<a href="mailto:reservations@theregnant.in">Make an enquiry</a>
				</div>
			</div>

			<div class="footer" align="center">
				<a href="https://instagram.com/the.regnant?igshid=1dl93acvuhcp5"><img src="icon_files/insta.png" /></a>
				<a href="https://www.facebook.com/theregnant/"><img src="icon_files/fb.png" /></a>
				<a href="https://www.twitter.com/@TheRegnant"><img src="icon_files/twitter.png" /></a>
				<br /><div style="height:10px"></div>
				<span style="padding:7px;">Share your Regnant experience and get connected.</span>
			</div>
		</div>
		<div class="viewer" align="center">
			<div class="left" align="center"><a href="#!" onclick="prev()"><img src="icon_files/left.png" /></a></div>
			<div class="canvas" align="center">
				<div class="loader" align="center">
					<div class="loadGIF" align="center">
						<span style="color:#fff;font-family:playfair;font-size:23px;">LOADING</span>
					</div>
				</div>
				<img src="images/slide (1).jpg" class="slideCanvas" />
			</div>
			<div class="right" align="center"><a href="#!" onclick="next()"><img src="icon_files/right.png" /></a></div>

			<div class="notice" align="center"><div style="margin:10px">The images shown are a virtual representation of the actual sites</div></div>

			<div class="closer" align="center"><a href="#!" onclick="togglePopup('viewer','table')"><div>CLOSE</div></a></div>
		</div>

		<div class="contactContainer" align="center">
			<div class="dailogBox" align="center">
				<div class="title" align="center">Contact info</div>
				<div class="table" align="center">
					<table>
						<tr><td align="right" valign="top" class="cleft">Email ID:</td><td><a href="mailto:reservations@theregnant.in">reservations@theregnant.in</a></td></tr>
						<tr><td align="right" valign="top" class="cleft">Address:</td>
						<td>
							The Regnant<br />
							A-35, Nirala Nagar<br />
							Lucknow, Uttar Pradesh<br />
							India
						</td></tr>
					</table>
				</div>
				<div class="closer" align="center">
					<a href="#!" onclick="togglePopup('contactContainer','block')"><div>OK</div></a>
				</div>
			</div>
		</div>

		<div class="signin" align="center">
			<div class="dailogBox" align="center">
				<div class="btns" align="center">
					<button id="google-signin" onclick="location.href='<? echo $gLoginUrl; ?>'"><img src="g-signin/g-logo.png" valign="middle" /> Continue with Google</button><br />
					<button id="fb-signin" onclick="location.href='<? echo $fbLoginUrl; ?>'">Continue with Facebook</button>
				</div>
				<div class="closer" align="center">
					<a href="#!" onclick="togglePopup('signin','block')"><div>Cancel</div></a>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="lib1.js" type="text/javascript"></script>

		<script>

			var animate=false;
			var swich=false;
			var winwid;
			var win;
			var vwfunc=function(e){
				if(swich){
					if(e.clientX<=winwid/2){prev();}
					else{next();}
				}
			};
			$(".canvas").on("click",function(e){vwfunc(e);});
			var wr=function(){
				winwid=$(window).width();
				win=$(window).height();
				var title=$(".titleBar").outerHeight();
				var footer=$(".footer").outerHeight();
				var calc=(win-title-footer);
				var overlay=$(".overlay").outerHeight();
				var final=(calc<overlay)?overlay:calc;
				console.log(final);
				if(animate){
					$(".gallery").animate({height:final+"px"},500);
					animate=false;
				}
				$(".gallery").css("height",final+"px");
				$(".slideCanvas").css("max-height",win+"px");
				if(calc>overlay){
					$(".overlay").css("margin-top",(calc-overlay)/2+"px");
				}
				else{
					$(".overlay").css("margin-top","0px");
				}

				var cc=$(".contactContainer");
				if(cc.css("display")=="block"){
					var contact=$(".dailogBox");
					var calc2=(win-contact.outerHeight())/2;
					contact.css("margin-top",calc2+"px");
				}
				else{
					cc.css("visibility","hidden");
					cc.css("display","block");
					var contact=$(".dailogBox");
					var calc2=(win-contact.outerHeight())/2;
					contact.css("margin-top",calc2+"px");
					cc.css("display","none");
					cc.css("visibility","visible");
				}
				var paras=$(".para");
				var newwidth=(winwid*0.8);
				for(i=0;i<paras.length;i++){
					paras.eq(i).css("width",((newwidth>300)?300:newwidth)+"px");
				}
				swich=true;
			};
			$(window).on("load",wr);
			$(window).resize(wr);

			var last=1;
			var max=8;

			function prev(){
				if(last<=1){last=max;}
				else{last--;}
				render();
			}

			function next(){
				if(last>=max){last=1;}
				else{last++;}
				render();
			}

			var pressed=false;
			function render(){
				sc=$(".slideCanvas");
				lo=$(".loader");
				sc.animate({opacity:0},100,function(){
					sc.css("display","none");
					lo.css("opacity","0");
					lo.css("display","block");
					lo.find(".loadGIF").css("margin-top",(win-50)+"px");
					lo.find(".loadGIF").css("display","none");
					lo.animate({opacity:1},100,function(){
						setTimeout(function(){lo.find(".loadGIF").css("display","block")},200);
						sc.attr("src","images/slide ("+last+").jpg");
						if(!pressed){
							sc.on("load",function(){
								lo.animate({opacity:0},100,function(){
									lo.css("display","none");
									sc.css("display","block");
									sc.animate({opacity:1},100,function(){
										pressed=true;
									});
								});
							});
						}
					});
				});
			}

			function togglePopup(ele,display){
				ele=$("."+ele);
				state=ele.css("display");
				if(state==display){
					ele.animate({opacity:"0"},200,function(){
						ele.css("display","none");
					})
				}
				else{
					ele.css("display",display);
					ele.css("opacity","0");
					ele.animate({opacity:"1"},200);
				}
			}

			function pack(a,f){
				a.animate({opacity:0},500,function(){
					a.css("display","none");
					f();
				});
			}

			function unpack(a,f){
				a.animate({opacity:1,marginLeft:"0px"},1000,f);
			}

			function exmore(lin){
				var p1=$(".l1");
				var p2=$(".l2");
				if(p1.css("display")=="block"){
					pack(p1,function(){
						p2.css("margin-left","-800px");
						p2.css("display","block");
						console.log("HERE:"+$(".gallery").outerHeight());
						animate=true;
						wr();
						unpack(p2,null);
					});
					
				}
				else{
					pack(p2,function(){
						p1.css("margin-left","-800px");
						p1.css("display","block");
						animate=true;
						wr();
						unpack(p1);
					});
				}
			}
		</script>
	</body>
</html>