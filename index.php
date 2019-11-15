<?
	session_start();
	$usrext=(isset($_SESSION['id'])===true)?true:false;

	$con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>The Regnant</title>
		<meta name="content-type" content="text/html:charset=utf-8" />
		<meta name="description" content="The Regnant home page" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<link href="favicon.png" rel="icon" type="image/x-icon" />
		<style>
			@font-face{font-family:montserrat;src:url('fonts/Montserrat-Regular.ttf');}
			@font-face{font-family:playfair;src:url('fonts/PlayfairDisplay-Regular.ttf');}
			@font-face{font-family:playfairBold;src:url('fonts/PlayfairDisplay-Bold.ttf');}
			@font-face{font-family:roboto;src:url('g-signin/roboto/Roboto-Medium.ttf');}
			@font-face{font-family:bahnschrift;src:url('fonts/bahnschrift.ttf');}
			body{font-family:montserrat;margin:0;padding:0;font-size:14px;text-transform:uppercase;}
			a:link,a:visited{text-decoration:none;color:#caa92b;}
			.container{width:100%;overflow:hidden;}
			.titleBar{width:100%;display:table;padding-bottom:10px;}
				.titleBlock{float:left;height:100%;display:table-cell;margin-left:30px;margin-top:30px;}
					.titleBlock a:link,.titleBlock a:visited{
						font-family:playfair;color:#caa92b;font-size:25px;text-transform:uppercase;
					}
					.titleBlock img{width:50px;margin-right:10px;}
				.optionsBlock{float:right;color:#caa92b;height:100%;display:table-cell;padding-top:20px;font-size:12px;margin-right:30px;margin-top:30px;}
					.optionsBlock img{width:20px;margin-right:5px;}
			.gallery{width:100%;height:400px;}
				.gallery .overlay{position:relative;padding-top:130px;padding-bottom:130px;}
					.gallery .overlay .title,.gallery .overlay .para,.gallery .overlay .link{margin-top:20px;color:#caa92b;margin-bottom:10px;margin-left:50px;}
					.gallery .overlay .title{margin-top:0;font-family:playfairBold;text-transform:uppercase;font-size:30px;}
					.para{width:300px;font-size:12px;text-align:left;text-transform:none;display:inline-block;}
					.gallery a:link,.gallery a:visited{font-size:12px;color:#fff;}
					.gallery .banner{display:inline-block;width:100%;height:100%;background-size:auto 100%;}
					.bannerSlide{width:33%;}
			
			.galleryNav{padding:10px;position:relative;top:-60px;display:none;}
			.galleryNav .cursor,.galleryNav .active_cursor{height:10px;width:10px;border-radius:10px;background:#fff;float:left;margin-right:5px;border:1px solid transparent;}
			.galleryNav .active_cursor{background:none;border:1px solid #fff;}

			#banner_2{background-image:url('images/home.jpg');background-size:auto 120%;}
			#banner_1{background-image:url('images/Banner.jpg');background-size:auto 100%;background-position:0% 100%;}
			#banner_3{background:#1a1a1a;}

			.comps{margin-top:-10px;}
				.comps a:link,.comps a:visited,.form input[type=submit],.writeReview button{border:0;text-transform:uppercase;font-family:montserrat;cursor:pointer;padding:15px;padding-left:40px;padding-right:40px;background:#caa92b;color:#fff;box-shadow:5px 5px 10px rgba(0,0,0,0.5);}
			.icons,.footer{padding-top:50px;background:#e9e9e9;width:100%;padding-bottom:20px;}
			.icons{margin-top:-20px;padding-bottom:50px;color:#7a7a7a;}
				.icons .title,.icons .regnantexperience span{margin-top:20px;width:400px;font-family:playfair;text-transform:none;font-size:23px;color:#caa92b;}
				.icons .iconsPlatter{display:inline-block;margin-top:20px;margin-bottom:20px;}
				.icons ul{list-style:none;list-type:none;padding:0;margin:0;width:70%;}
				.icons ul li{float:left;text-align:center;padding:0;margin:0;width:16%;font-size:12px;}
				.icons ul li img{width:100%;}
				.icons .readmore{margin-top:10px;margin-bottom:40px;font-size:13px;font-weight:bold;}
				.icons .regnantexperience p{width:500px;font-size:14px;text-transform:none;}

			.thumbs{padding-bottom:0px;width:100%;}
			.thumbnail{width:33%;font-size:12px;color:#fff;background-size:auto 100%;}
			.thumbnail .overlay{opacity:0;background:rgba(0,0,0,0.7);height:100%;vertical-align:middle;}
			.thumbnail .overlay{padding-top:150px;padding-bottom:150px;}
			#pool{background-size:100% auto;}
			#pool .overlay{padding-top:300px;padding-bottom:320px;}

			.shortGallery{width:100%;display:none;margin-top:15px;}
			.shortGallery .picture{background-size:100% auto;background-position:0% 20%;width:10%;box-shadow:2px 2px 10px rgba(0,0,0,0.8);margin:5px;float:left;}
			.shortGallery .rack{width:600%;}
			.shortGallery .picture .info{text-align:left;text-transform:none;background:rgba(0,0,0,0.5);color:#fff;padding:10px;}
			.shortGallery .picture .info .title{font-weight:bold;font-size:18px;}
			.shortGallery .picture .info .description{font-size:12px;}

			.reviews{display:none;width:100%;padding-top:50px;padding-bottom:50px;background-image:url('images/reviewBack.jpg');background-size:100% auto;}
			.revContainer{width:550px;color:#fff;display:inline-block;}
			.revContainer .img{float:left;height:100%;display:inline-block;}
			.revContainer .img img{background:#eee;height:auto;width:120px;border-radius:300px;border:5px solid #caa92b;}
			.revContainer .content{float:right;height:100%;display:inline-block;text-align:left;}
			.revContainer .content p{width:375px;text-align:left;font-size:14px;text-transform:none;}
			.revContainer .name,.revContainer .location{color:#caa92b;text-transform:none;}

			.navigator{width:95%;display:none;}
			.navigator div{font-size:80px;font-family:bahnschrift;}
			.navigator .left{float:left;}
			.navigator .right{float:right;}

			.writeReview button{border-radius:30px;margin-top:10px;margin-bottom:20px;}

			.footer{padding-bottom:50px;}
				.footer img{width:25px;border:2px solid #caa92b;padding:4px;margin-left:10px;margin-right:10px;}
				.footer span{font-size:12px;text-transform:none;}
				.footer .form{margin-bottom:50px;}
				.footer .title{color:#caa92b;font-weight:bold;}
				.footer .fields{width:800px;margin-top:20px;}
				.footer input[type=text],.footer textarea{font-size:12px;font-family:montserrat;}
				.footer input[type=text]{box-shadow:0px 0px 10px rgba(0,0,0,0.4);border:0;width:40%;margin:1%;padding:1.25%;}
				.footer textarea{width:85%;padding:1.25%;margin:1.25%;box-shadow:0px 0px 10px rgba(0,0,0,0.4);border:0;}

			.viewer{width:100%;height:100%;position:fixed;top:0;left:0;background:linear-gradient(90deg,#1a1a1a,#4a4a4a);display:none;}
				.viewer .left,.viewer .canvas,.viewer .right{display:table-cell;height:100%;vertical-align:middle;}
				.viewer .left,.viewer .right{width:8%;font-size:30px;font-weight:bold;}
				.viewer .canvas{width:84%;}
				.viewer .canvas img{max-height:95%;max-width:100%;}
				.viewer .left img,.viewer .right img{height:30%;opacity:0.5;}
				.viewer .closer{position:fixed;top:0px;right:0px;padding:20px;font-size:15px;font-weight:bold;}
				.closer a:link,.closer a:visited{color:#2a2a2a;}
				.closer img{width:50px;}
				.contactContainer .closer div,.writeReviewInput .closer input[type=submit],.signin .closer div{padding:15px;border-radius:30px;background:#9a9a9a;}
				.viewer .notice{position:fixed;bottom:0;left:0;width:100%;background:#caa92b;color:#fff;font-size:10px;}
				.viewer .loader{height:100%;width:100%;vertical-align:middle;display:none;}

			.contactContainer,.signin,.alerter,.writeReviewInput{position:fixed;height:100%;width:100%;top:0;left:0;background:url('icon_files/back.png');display:none;}
				.contactContainer .dailogBox,.signin .dailogBox,.alerter .dailogBox,.writeReviewInput .dailogBox{padding:20px;background:#fff;box-shadow:5px 5px 10px rgba(0,0,0,0.5);width:300px;}
				.contactContainer .closer div,.signin .closer div,.alerter .closer div,.writeReviewInput .closer div{width:100px;}
				.contactContainer .closer a:link,.contactContainer .closer a:visited,.signin .closer a:link,.signin .closer a:visited,.alerter a:link,.alerter a:visited,.writeReviewInput a:link,.writeReviewInput a:visited,.writeReviewInput input[type=submit]{color:#fff;}
				.contactContainer .title,.signin .title,.alerter .title,.writeReviewInput .title{font-family:playfairBold;font-size:20px;color:#caa92b;}
				.contactContainer table{margin-top:20px;margin-bottom:20px;font-size:12px;}
				.contactContainer .cleft,.signin .cleft,.alerter .cleft{font-weight:bold;}
				.signin .closer,.alerter .closer,.writeReviewInput .closer{margin-top:20px;}
				.writeReviewInput .closer input[type=submit]{border:0;text-transform:uppercase;font-family:montserrat;font-size:14px;margin-right:10px;width:130px;cursor:pointer;}
				.writeReviewInput input[type=submit],.writeReviewInput .closer div{float:left;}
				.writeReviewInput .closer{display:inline-block;}
				.writeReviewInput textarea{border:1px solid #d1d1d1;padding:5px;font-family:montserrat;width:200px;height:100px;}

			#google-signin{border:0;padding:10px;background:#fff;font-family:roboto;font-size:16px;width:254px;color:rgba(0,0,0,0.54);border-radius:5px;box-shadow:1px 1px 2px rgba(0,0,0,0.54);cursor:pointer;}
			#google-signin img,#fb-signin img{height:20px;margin-right:10px;}
			#fb-signin{background:#4267B2;padding:10px;border-radius:5px;border:0;color:#fff;font-size:16px;width:254px;box-shadow:1px 1px 2px rgba(0,0,0,0.54);cursor:pointer;}
			#google-signin,#fb-signin{margin:5px;}

			.l1,.l2{overflow:hidden;}
			.l1{display:block;}
			.l2{display:none;}
			.gallery .overlay .aligner{padding:0;margin:0;text-align:left;}

			.loaderDIV{width:100%;height:100%;position:fixed;top:0;left:0;opacity:1;background:#fff;font-size:40px;font-family:playfairBold;color:#caa92b;}

			@media only screen and (max-width: 632px){
				.reviews{background-size:auto 150%;background-position:50% 0%;}
				.revContainer{display:block;width:70%;}
				.revContainer img{width:50px;height:auto;}
				.revContainer .img{display:table;width:100%;height:auto;}
				.revContainer .content{display:table;width:100%;height:auto;text-align:center;}
				.revContainer .content p{text-align:center;width:100%;}

				.gallery .overlay .aligner{text-align:center;}
				.titleBlock{width:100%;margin-left:0;margin-right:0;margin-bottom:-15px;}
				.titleBlock img{margin-right:0px;}
				.optionsBlock{width:100%;margin-left:0;margin-right:0;margin-bottom:10px;}
				.gallery .overlay{padding-top:50px;padding-bottom:50px;}
				.gallery .overlay .title,.gallery .overlay .para,.gallery .overlay .link{margin:10px;text-align:center;}
				.gallery .overlay .title{font-size:20px;}
				.viewer .left,.viewer .right{top:33%;width:20%;opacity:0;position:fixed;}
				.viewer .left{left:0;height:100%;}
				.viewer .right{right:0;}
				.viewer .canvas{width:100%;}
				.viewer .canvas img{width:100%;}
				.footer{padding-top:60px;padding-bottom:30px;}
				.l1, .l2{width:100%;}
				.icons .title{width:80%;}
				.icons ul{width:70%;}
				.icons ul li{width:33%;}
				.icons .regnantexperience p{width:80%;}
				.footer .fields {width:100%;}
				.fields input[type=text]{padding:10px;width:80%;}
				.fields textarea{width:80%;padding:10px;height:80px;}
				.thumbs{display:none;}
				.shortGallery{display:inline-block;}
			}

			@media only screen and (min-width:632px) and (max-width: 841px){
				.gallery .slideShow {background-size:auto 100%;}
				.icons ul{width:90%;}
				.thumbs{display:none;}
				.shortGallery{display:inline-block;}
				.reviews{background-size:100% auto;}
				.revContainer{width:70%;smargin:0;}
				.revContainer .img{width:40%;}
				.revContainer .content{width:55%;}
				.revContainer .img img{width:auto;height:170px;}
				.revContainer .content p{width:100%;}
				.footer .fields {width:100%;}
				.fields input[type=text]{padding:10px;width:80%;}
				.fields textarea{width:80%;padding:10px;height:80px;}
			}

		</style>
	</head>
	<body><center>
		<div class="container" align="center">
			
			<div class="titleBar" align="center">
				<div class="titleBlock" align="center">
					<a href="index.php"><img src="images/title2.png" valign="middle" /> The Regnant</a>
				</div>
				<div class="optionsBlock" align="center">
					<a href="#!"><img src="icon_files/search.png" valign="middle" /> Explore</a>&nbsp; | &nbsp;
					<a href="#!" onclick="togglePopup('viewer','table')">Gallery</a>&nbsp; | &nbsp;
					<a href="#!" onclick="togglePopup('contactContainer','block')">Contact us</a>&nbsp; | &nbsp;
					<? if($usrext){ ?>
					<a href="logout.php">Logout</a>
					<? }else{ ?>
					<a href="#!" onclick="togglePopup('signin','block')">Login</a>
					<? } ?>
				</div>
			</div>

			<div class="gallery" align="center" onmouseover="pauseGallery('over')" onmouseout="pauseGallery('out')">
				<table cellspacing="0" cellpadding="0" style="width:300%;height:100%;">
					<tr>
						<td class="bannerSlide" id="banner_td_1">
							<div class="banner" id="banner_1" align="center">
								<div class="overlay" align="left">
									<div class="l1" style="margin:0;padding:0">
										<div class="title" id="title_1" align="left">
											Enrobed in luxury<br />Coming soon
										</div>
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
								</div>
							</div>
						</td>
						<td class="bannerSlide" id="banner_td_2">
							<div class="banner" id="banner_2" align="center">
								<div class="overlay" align="left">
									<div class="l1" style="margin:0;padding:0">
										<div class="title" id="title_1" align="left">
											Enrobed in luxury. <br /> Coming Soon.
										</div>
										<div class="link" align="left">
											<a href="#!">Explore more &gt;</a>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td class="bannerSlide" id="banner_td_3">
							<div class="banner" id="banner_3" align="center">
								<div class="overlay" align="left">
									<div class="l1" style="margin:0;padding:0">
										<div class="title" id="title_1" align="left">
											Enrobed in luxury. <br /> Coming Soon.
										</div>
										<div class="link" align="left">
											<a href="#!">Explore more &gt;</a>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>

			<div class="galleryNav" align="center" onMouseOver="pauseGallery('over')">
				<a href="#!" onclick="bannerToggle(1)"><div class="active_cursor" id="cursor1"></div></a>
				<a href="#!" onclick="bannerToggle(2)"><div class="cursor" id="cursor2"></div></a>
				<a href="#!" onclick="bannerToggle(3)"><div class="cursor" id="cursor3"></div></a>
			</div>

			<div class="comps" align="center">
				<? if($usrext===false){ ?>
				<div class="trial" align="center">
					<a href="mailto:reservations@theregnant.in">Make an enquiry</a>
				</div>
				<? }else{ ?>
				<div class="reservations" align="center">
					
				</div>
				<? } ?>
			</div>

			<div class="icons" align="center">
				<div class="title" align="center">Discover a world of exquisite luxury and unparalleled comfort</div>
				<div class="iconsPlatter" align="center">
					<ul>
						<li><img src="icon_files/symbol gym.png" /><br />Gym</li>
						<li><img src="icon_files/symbol tea room.png" /><br />24/7 Tea Room</li>
						<li><img src="icon_files/symbol pool.png" /><br />Roof Top Pool</li>
						<li><img src="icon_files/symbol co working space.png" /><br />Co Working Space</li>
						<li><img src="icon_files/symbol dining.png" /><br />High Energy Dining Spaces</li>
						<li><img src="icon_files/symbol event area.png" /><br />Grand Event Spaces</li>
					</ul>
				</div>
				<div class="readmore" align="center"><a href="more.html">Read More &gt;</a></div>
				<div class="regnantexperience" align="center">
					<span>The Regnant Experience</span>
					<br /><br />
					<p>A tailor-made stay just for you. The hotel offers a wider choice of suites and residences than almost any other in the City of the Nawabs.</p>
				</div>
			</div>

			<center>
				<table class="thumbs" align="center" cellspacing="7" cellpadding="0">
				<tr>
					<td class="thumbnail" align="center" id="pool" rowspan="2">
						<div class="overlay" align="center">
							Rooftop Pool
							<!-- <div class="suboverlay" align="center">Swimming Pool</div> -->
						</div>
					</td>
					<td class="thumbnail" align="center" id="club">
						<div class="overlay" align="center">
							Club Rooms
							<!-- <div class="suboverlay" align="center">Club Rooms</div> -->
						</div>
					</td>
					<td class="thumbnail" align="center" id="meals">
						<div class="overlay" align="center">
							Complimentary Meals
							<!-- <div class="suboverlay" align="center">Complimentary Meals</div> -->
						</div>
					</td>
				</tr>
				<tr>
					<td class="thumbnail" align="center" id="banquet">
						<div class="overlay" align="center">
							Banquet
							<!-- <div class="suboverlay" align="center">Banquet</div> -->
						</div>
					</td>
					<td class="thumbnail" align="center" id="furnish">
						<div class="overlay" align="center">
							Executive Rooms
							<!-- <div class="suboverlay" align="center">Furnishing</div> -->
						</div>
					</td>
				</tr>
			</table>

				<div class="shortGallery" align="center">
					<div class="rack" align="center">
						<div class="picture" align="center">
							<div class="spacer"></div>
							<div class="info">
								<span class="title"></span>
								<span class="description"></span>
							</div>
						</div>
					</div>
				</div>
			</center>

			<div class="writeReview" align="center">
				<button onclick="writeReview()">Write a Review</button>
			</div>

			<div class="reviews" align="center">
				<table class="reviewLineup" cellspacing="0" cellpadding="0">
					<tr>
						<?
						$revQuery=mysqli_query($con,"select * from reviews where visible=1");
						$revnum=mysqli_num_rows($revQuery);
						for($i=0;$i<$revnum;$i++){
							$res=mysqli_fetch_assoc($revQuery);
							$uid=$res['uid'];
							$message=$res['message'];
							$location=$res['location'];

							$perRes=mysqli_fetch_row(mysqli_query($con,"select name,profilePic from users where id=".$uid));
							$name=$perRes[0];
							$picture=$perRes[1];
						?>
						<td valign="middle" align="center">
							<div class="revContainer">
								<div class="img" align="center"><img src="<? echo $picture; ?>" /></div>
								<div class="content">
									<p>"<? echo $message; ?>"</p>
									<span class="name"><? echo $name; ?></span><br />
									<span class="location"><? echo $location; ?></span>
								</div>
							</div>
						</td>
						<?
						}
						?>
					</tr>
				</table>
			</div>

			<div class="navigator">
				<div class="left" align="center"><a href="javascript:rev_prev()">&lt;</a></div>
				<div class="right" align="center"><a href="javascript:rev_next()">&gt;</a></div>
			</div>

			<div class="footer" align="center">
				<div class="form" align="center">
					<form action="forms.php?type=inforequest" method="post" onsubmit="return isValid(this)">
						<div class="title" align="center">Request more information</div>
						<div class="fields" align="center">
							<input type="text" name="fname" placeholder="First Name *">
							<input type="text" name="lname" placeholder="Last Name *">
							<input type="text" name="phone" placeholder="Phone">
							<input type="text" name="email" placeholder="Email *">
							<textarea placeholder="Message *" name="message"></textarea>
						</div>
						<div class="submit" align="center"><input type="submit" value="Submit" /></div>
					</form>
				</div>

				<a href="https://instagram.com/the.regnant?igshid=1dl93acvuhcp5"><img src="icon_files/insta.png" /></a>
				<a href="https://www.facebook.com/theregnant/"><img src="icon_files/fb.png" /></a>
				<a href="https://www.twitter.com/@TheRegnant"><img src="icon_files/twitter.png" /></a>
				<br /><div style="height:10px"></div>
				<span style="padding:7px;">Share your Regnant experience and get connected.</span>
			
			</div>

		</div>

		<!--POPUPS--->

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

			<!-- <div class="notice" align="center"><div style="margin:10px">The images shown are a virtual representation of the actual sites</div></div> -->

			<div class="closer" align="center"><a href="#!" onclick="togglePopup('viewer','table')"><div><img src="icon_files/closer.png" /></div></a></div>
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
					<button id="google-signin" onclick="location.href='google_lr.php'"><img src="g-signin/g-logo.png" valign="middle" /> Continue with Google</button><br />
					<button id="fb-signin" onclick="location.href='fb_lr.php'"><img src="fb-signin/f.jpg" valign="middle" /> Continue with Facebook</button>
				</div>
				<div class="closer" align="center">
					<a href="#!" onclick="togglePopup('signin','block')"><div>Cancel</div></a>
				</div>
			</div>
		</div>

		<div class="writeReviewInput" align="center">
			<div class="dailogBox" align="center">
				<div class="title" align="center">Write Review</div>
				<form action="forms.php?type=review" method="post" onsubmit="return isValid(this)">
					<div class="message" align="center" style="text-transform:none;margin-top:15px;">
						<textarea placeholder="Type here..." name="review"></textarea>
					</div>
					<div class="closer" align="center">
						<input type="submit" value="Submit" /> <a href="#!" onclick="togglePopup('writeReviewInput','block')"><div>Cancel</div></a>
					</div>
				</form>
			</div>
		</div>

		<div class="alerter" align="center">
			<div class="dailogBox" align="center">
				<div class="title" align="center">Message</div>
				<div class="message" align="center" style="text-transform:none;margin-top:15px;">

				</div>
				<div class="closer" align="center">
					<a href="#!" onclick="closeAlert()"><div>OK</div></a>
				</div>
			</div>
		</div>

		<div class="loaderDIV" align="center">
			<div style="opacity:0">Loading</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="anim_lib.js" type="text/javascript"></script>

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

			var start=0;
			var userinfo={};

			$(".loaderDIV").css("padding-top",$(window).height()/2-40+"px");
			$(".loaderDIV").find("div").animate({opacity:1});

			<? if($usrext===true){
			?>
			userinfo.name="<? echo $_SESSION['name']; ?>";
			userinfo.email="<? echo $_SESSION['email']; ?>";
			userinfo.pic="<? echo $_SESSION['profilePic']; ?>";
			userinfo.id=<? echo $_SESSION['id']; ?>;
			<?
				}
			?>

			function blink(ele,action){
				ele=$(ele);
				if(action=="over"){
					ele.animate({opacity:1},200);
				}
				else{
					ele.animate({opacity:0},200);
				}
			}

			nextalert= ()=>{};

			function alert(message,func=function(){}){
				$(".alerter").find(".message").html(message);
				nextalert=func;
				togglePopup("alerter","block");
			}

			function closeAlert(){
				togglePopup("alerter","block");
				nextalert();
			}

			var images=['pool','club','meals','banquet','furnish'];
			var titles=['Rooftop Pool','Club Rooms','Complimentary Meals','Banquet','Executive Rooms'];

			$(".canvas").on("click",function(e){vwfunc(e);});
			var wr=function(){
				winwid=$(".container").width();
				win=$(window).height();
				var title=$(".titleBar").outerHeight();
				var footer=$(".footer").outerHeight();
				var calc=(win-title-footer);
				var overlayEle=$("#banner_td_1").find(".overlay");
				var overlay=overlayEle.outerHeight();
				var owidth=overlayEle.outerWidth();
				var all=$(".gallery").find(".banner");
				var aspect=1.777;
				if(start==0){
					if((owidth/(overlay+156))<aspect){
						for(ii=0;ii<all.length;ii++){
							all.eq(ii).css("background-size","auto 130%");
						}
					}
					else{
						for(ii=0;ii<all.length;ii++){
							all.eq(ii).css("background-size","100% auto");
						}
					}

					var l_lim=owidth/overlay;
					var u_lim=owidth/(overlay+156);

					if(l_lim>aspect && u_lim<aspect){
						var newheight=l_lim/aspect*100;
						all.css("background-size","auto "+newheight+"%");
					}
				}

//				var final=(calc<overlay)?overlay:calc;
				final=overlay;
				if(animate){
					$(".gallery").animate({height:final+"px"},500);
					animate=false;
				}
				$(".gallery").css("height",final+"px");
				$(".slideCanvas").css("max-height",win+"px");
//				if(calc>overlay){
//					$(".overlay").css("margin-top",(calc-overlay)/2+"px");
//				}
//				else{
//					$(".overlay").css("margin-top","0px");
//				}

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

				var revnav=$(".navigator");
				revnav.css("margin-top",$(".reviews").outerHeight()*(-1)+"px");
				revnav.css("height",$(".reviews").outerHeight()+"px");
				revnav.find("div").css("padding-top",$(".reviews").outerHeight()/2-50+"px");

				var paras=$(".para");
				var newwidth=(winwid*0.8);
				for(i=0;i<paras.length;i++){
					paras.eq(i).css("width",((newwidth>300)?300:newwidth)+"px");
				}
				swich=true;

				var thumbs=$(".thumbnail");
				for(ti=0;ti<thumbs.length;ti++){
					var thumbnail=thumbs.eq(ti);
					var img="images/thumb_"+thumbnail.attr("id")+".jpg";
					thumbnail.css("background-image","url('"+img+"')");
//					thumbnail.find(".suboverlay")[0].onmouseover=function(){}
					thumbnail.find(".overlay")[0].setAttribute("onMouseOver","blink(this,'over')");
					thumbnail.find(".overlay")[0].setAttribute("onMouseOut","blink(this,'out')");

					thumbnail.find(".overlay").css("padding",thumbs.width()/3+"px");
					if(thumbnail.attr("id")=="pool"){thumbnail.find(".overlay").css("padding",thumbs.width()/1.5+10+"px");}
					thumbnail.find(".overlay").css("padding-left","0px");
					thumbnail.find(".overlay").css("padding-right","0px");
				}

				var rack=$(".rack");
				var picture=rack.find(".picture").eq(0).clone();
				rack.html("");
				for(i=0;i<images.length;i++){
					var thispic=picture.clone();
					thispic.css("background-image","url('images/thumb_"+images[i]+".jpg')");
					thispic.find(".title").html(titles[i]);
					thispic.attr("id","sub_"+images[i]);
					thispic.attr("onclick","toggleShortGallery(this.id)");
					rack.append(thispic);
					var constheight=$("#sub_"+images[i]).outerWidth()*(0.5);
					$("#sub_"+images[i]).css("padding-top",constheight+"px");

					if(i==0){
						var defaultWidth=(winwid-($("#"+"sub_"+images[i]).outerWidth()))/2;
						rack.css("margin-left",defaultWidth+"px");
					}
				}

				var tds=$(".reviewLineup").find("td");
				$(".reviewLineup").css("width",100*Number(tds.length)+"%");
				tds.css("width",100/tds.length+"%");

				var galLeft=$(".viewer").find(".left");
				var galRight=$(".viewer").find(".right");
				if(winwid<633){
					galLeft[0].setAttribute("onclick","prev()");
					galRight[0].setAttribute("onclick","next()");
					galLeft.find("a")[0].setAttribute("onclick","");
					galRight.find("a")[0].setAttribute("onclick","");
					galLeft.css("opacity","0");
					galRight.css("opacity","0");
				}
				else{
					galLeft[0].setAttribute("onclick","");
					galRight[0].setAttribute("onclick","");
					galLeft.find("a")[0].setAttribute("onclick","prev()");
					galRight.find("a")[0].setAttribute("onclick","next()");
					galLeft.css("opacity","1");
					galRight.css("opacity","1");
				}

				if(start==0){$(".loaderDIV").animate({opacity:0},200,function(){$(".loaderDIV").css("display","none");});}
				postload();
				start++;

			};
			$(window).on("load",wr);
			$(window).resize(wr);

			var list=[];
			var last=0;
			var xh=new XMLHttpRequest();
			var reqcounter=0;
			xh.onreadystatechange=function(){
				console.log(xh.readyState+"||"+xh.status);
				if(xh.readyState==4 && xh.status==200){
					var result=xh.responseText;
					list=result.split(/\n/g);
				}
				else{
					if(xh.readyState==4){
						if(reqcounter<4){
							reqcounter++;
							setTimeout(openrequest,200);
						}
						else{
							alert("Sorry! we were unable to load the gallery");
						}
					}
				}
			};
			var openrequest=()=>{
				xh.open("GET","gallery.txt",true);
				xh.send();
			};
			openrequest();

			function checkArrowFeedback(orient){
				pan=$(".viewer");
				if(pan.find(".left").css("opacity")=="0"){
					var target=pan.find("."+((orient=="left")?"left":"right"));
					console.log(target.outerWidth());
					target.animate({opacity:1},200,()=>{
						target.animate({opacity:0},200);
					});
				}
			}

			function prev(){
				if(last<=0){last=list.length-1;}
				else{last--;}
				checkArrowFeedback("left");
				render();
			}

			function next(){
				if(last>=(list.length-1)){last=0;}
				else{last++;}
				checkArrowFeedback("right");
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
						sc.attr("src","images/"+list[last]);
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
				var p1=$("#banner_1").find(".l1");
				var p2=$("#banner_1").find(".l2");
				var parent=$("#banner_1").find(".overlay");
				pad=Number(parent.css("padding").split("px")[0]);
				console.log(pad);
				if(p1.css("display")=="block"){
					pack(p1,function(){
						p2.css("margin-left","-800px");
						newh=p2.outerHeight()+(2*pad);
						console.log(newh);
						$("#banner_1").animate({height:newh});
						p2.css("display","block");
						animate=true;
						wr();
						unpack(p2,null);
						middle=true;
					},null);
				}
				else{
					pack(p2,function(){
						p1.css("margin-left","-800px");
						newh=p1.outerHeight()+(2*pad);
						console.log(newh);
						$("#banner_1").animate({height:newh});
						p1.css("display","block");
						animate=true;
						wr();
						unpack(p1,null);
					},null);
					console.log("Back to first!");
					middle=false;
				}
			}

			var cursor=1;
			var max=3;

			function bannerToggle(point=(((cursor+1)%max != 0)?(cursor+1)%max:3)) {
				cursor=point;
				$(".active_cursor").attr("class","cursor");
				$("#cursor"+cursor).attr("class","active_cursor");
				var table=$(".gallery").find("table");
				table.animate({marginLeft:((1-cursor)*100)+"%"});
			}

			var revcursor=1;
			var max=$(".reviewLineup").find("td").length;
			function rev_prev(){
				if(revcursor==1){revcursor=max;}
				else{revcursor--;}
				moveReview();
			}
			function rev_next(){
				if(revcursor==max){revcursor=1;}
				else{revcursor++;}
				moveReview();
			}
			function moveReview(){
				var rev=$(".reviewLineup");
				rev.animate({marginLeft:(1-revcursor)*100+"%"},500);
			}

			function toggleShortGallery(id){
				var picwidth=$("#"+id).outerWidth();
				var defaultWidth=(winwid-(picwidth))/2;
				id=id.split("sub_")[1];
				var paddingLeft=defaultWidth-((images.indexOf(id))*(picwidth+10));
				console.log(paddingLeft);
				$(".rack").animate({marginLeft:paddingLeft+"px"},200);
			}

			var func=function(){bannerToggle(((cursor)%3)+1);};
			var middle=false;

			function bannerMarquee(){
				try{if(!middle)func();}catch(err){}
				setTimeout(bannerMarquee,3000);
			}


			function pauseGallery(action){
				if(action=="over"){func=null;}
				else{func=function(){bannerToggle(((cursor)%3)+1);};}
			}

			// setTimeout(bannerMarquee,3000);

			function isValid(f){
				var def=false;
				var panel=$(f);
				var dets=panel.find("input");
				var text=panel.find("textarea");

				if(dets.val()=="" || text.val()==""){}
				else{def=true;}

				if(!def){alert("You left some details in the form");}

				return def;
			}

			function writeReview(){
				if(Object.entries(userinfo).length==0){
					alert("Please login to continue",function(){togglePopup('signin','block')});
				}
				else{
					togglePopup('writeReviewInput','block');
				}
			}

			function postload(){
				var loc=window.location.toString();
				loc=loc.split("?");
				loc.splice(0,1);
				codes=['inforequest=ok','inforequest=notok','reviewRequest=ok','reviewRequest=notok'];
				messages=[
					'Your request has been submitted. We will contact you in a while',
					'You request could not be processed. Fatal input detected',
					'Your review has been posted. Thank you very much!',
					'Your review could not be posted. An error occured'
				];
				counter=0;
				codes.map(function(e){
					if(loc.indexOf(e)!=-1){alert(messages[counter]);}
					counter++;
				});
			}
		</script>
		</center>
	</body>
</html>