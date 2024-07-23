<!DOCTYPE HTML>
<html>
<?php // echo base_url('newBackend/images/user.png'); ?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>SC-eFM</title>
	<link rel="shortcut icon" href="<?php  echo base_url('newBackend/images/favicon.gif'); ?>">
	<link href="<?php  echo base_url('newBackend/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php  echo base_url('newBackend/css/font-awesome.min.css'); ?>" rel="stylesheet">
	<link href="<?php  echo base_url('newBackend/css/animate.css'); ?>" rel="stylesheet">
	<link href="<?php  echo base_url('newBackend/css/material.css'); ?>" rel="stylesheet" />
	<link href="<?php  echo base_url('newBackend/css/style.css'); ?>" rel="stylesheet">
	<!-- <style>
		@-webkit-keyframes line-scale {
			0% {
				-webkit-transform: scaley(1);
				transform: scaley(1);
			}

			50% {
				-webkit-transform: scaley(0.4);
				transform: scaley(0.4);
			}

			100% {
				-webkit-transform: scaley(1);
				transform: scaley(1);
			}
		}

		@keyframes line-scale {
			0% {
				-webkit-transform: scaley(1);
				transform: scaley(1);
			}

			50% {
				-webkit-transform: scaley(0.4);
				transform: scaley(0.4);
			}

			100% {
				-webkit-transform: scaley(1);
				transform: scaley(1);
			}
		}

		.line-scale>div:nth-child(1) {
			-webkit-animation: line-scale 1s -0.4s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
			animation: line-scale 1s -0.4s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		}

		.line-scale>div:nth-child(2) {
			-webkit-animation: line-scale 1s -0.3s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
			animation: line-scale 1s -0.3s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		}

		.line-scale>div:nth-child(3) {
			-webkit-animation: line-scale 1s -0.2s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
			animation: line-scale 1s -0.2s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		}

		.line-scale>div:nth-child(4) {
			-webkit-animation: line-scale 1s -0.1s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
			animation: line-scale 1s -0.1s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		}

		.line-scale>div:nth-child(5) {
			-webkit-animation: line-scale 1s 0s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
			animation: line-scale 1s 0s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08);
		}

		.line-scale>div {
			background-color: #0d48be;
			width: 4px;
			height: 35px;
			border-radius: 2px;
			margin: 2px;
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both;
			display: inline-block;
		}
		.loader {
    right: 0;
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    z-index: 999;
    background: #f5f5f6c7;
}

.loader .line-scale {
    width: fit-content;
    margin: 0 auto;
    position: relative;
    top: 44%;
}
	</style> -->
</head>

<body>


	
			<!-- <div class="loader">
				<div class="line-scale">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
	 -->



	<div class="wrapper">
		<!--header section-->
		<div class="mngmntHeader">
			<div class="menu-sec">
				<div class="mngmntLogoSection">
					<!-- Menu - Button Start  -->
					<div class="togglemenuSection">
						<button type="button" class="btn btn-sm togglebtn" id="topnav-hamburger-icon">
							<span class="hamburger-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>
					</div>
					<!-- Menu - Button Start  -->
					<div class="brand-logo-sec">
						<div class="logo"><a href="#"><img src="<?php  echo base_url('newBackend/images/logo.png'); ?>" alt="  " title=" "></a></div>
						<div class="logoSubtitle">
							<div class="brand-text">
								<h4>भारत का सर्वोच्च न्यायालय
									<span> Supreme Court of India </span>
									<span class="logo-sm-txt">|| यतो धर्मस्ततो जय: ||</span>
								</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="mngmntUserSection">
					<div class="top-right-nav">
						<ul>
							<li><a href="javascript:void(0)" class="hide skiptomain">Skip To Main Content</a></li>
							<li><a class="hide" href="javascript:void(0)">Screen Reader Access</a></li>
							<li class="text-size">
								<a href="javascript:void(0)"><img src="<?php  echo base_url('newBackend/images/text-ixon.png'); ?>" alt=""
										class="txt-icon"></a>
							</li>
							<li>
								<a href="javascript:void(0)" class="toph-icon"><i class="fas fa-sitemap"></i></a>
							</li>
							<li class="theme-color">
								<a href="javascript:void(0)" class="whitebg">A</a>
								<a href="javascript:void(0)" class="blackbg">A</a>
							</li>
							<li>
								<select name="" id="" class="select-lang">
									<option value="">English</option>
									<option value="">Hindi</option>
								</select>
							</li>
						</ul>
					</div>
					<div class="account-details">
						<div class="userInformation">
							<!--userDetail-->
							<div class="userDetail" id="usr-action-btn">
								<div class="userName"> User Login <i class="fas fa-chevron-down"></i>
									<!-- <span class="division">Customer</span> -->
								</div>
								<div class="user-action-sec">
									<ul>
										<li>
											<a href="javascript:void(0)">Prfile</a>
										</li>
										<li>
											<a href="javascript:void(0)">Log Out</a>
										</li>
									</ul>
								</div>
							</div>
							<!--userDetail-->

							<!--userImg-->
							<div class="userImgWrap">
								<div class="userImg">
									<a href="#"><img src="<?php  echo base_url('newBackend/images/user.jpg'); ?>" alt="Admin" title="admin" width="56"
											height="56"></a>
								</div>
							</div>
							<!--userImg-->
						</div>
						<div class="userInfo">
							<!-- <a href="#"><span class="fa fa-envelope-o icon-animated-vertical"></span></a> -->
							<!-- <a href="#"><span class="fa fa-question animated bounceInDown"></span></a>  -->
							<a href="#" class="bell"><span class="fa fa-bell ringing"></span><span
									class="count">5</span></a>
							<!-- <a	href="login.html" class="signOut"><span class="fa fa-sign-out"></span></a> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--header sec   end-->

		<div class="content">