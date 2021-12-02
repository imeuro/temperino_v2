<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="theme-color" content="#4c75b7"/>
  <link rel="canonical" href="https://weather-pwa-sample.firebaseapp.com/final/">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Temperino v2</title>
	<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c:300,400,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="css/swiper.min.css">

  <!-- TODO add manifest here -->
  <link rel="manifest" href="manifest.json">
  <!-- Add to home screen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Temperino v2">
  <link rel="apple-touch-icon" href="images/icons/icon-152x152.png">
  <meta name="msapplication-TileImage" content="images/icons/icon-144x144.png">
  <meta name="msapplication-TileColor" content="#2F3BA2">
</head>
<body>
	<div class="app-container">


	  <header class="header">
			<button id="butMenu" class="headerButton" aria-label="menu"></button>
	    <h1 class="header__title">Temperino v2</h1>
	    <button id="butRefresh" class="headerButton" aria-label="Refresh"></button>
	  </header>


		<nav id="main-menu">
			<ul>
				<li><a href="#slide1" class="current">Status (inside)</a></li>
				<!-- <li><a href="#slide2">Status (outside)</a></li> -->
				<li><a href="#slide3">Set Program</a></li>
				<li><a href="#slide4">Info</a></li>
			</ul>
		</nav>

	  <main class="main">

			<!-- Slider main container -->
			<div class="swiper-Temperino">
			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper">
			        <!-- Slides -->
			        <div class="swiper-slide" data-hash="slide1" data-content="status_in"></div>
			        <!-- <div class="swiper-slide" data-hash="slide2" data-content="status_out"></div> -->
			        <div class="swiper-slide" data-hash="slide3" data-content="set_prog"></div>
			        <div class="swiper-slide" data-hash="slide4" data-content="sys_info"></div>
			    </div>
			    <!-- If we need pagination -->
			    <div class="swiper-pagination"></div>
			</div>

	  </main>

		<div id="notice" class="hidden"></div>


	  <div class="loader">
	    <svg viewBox="0 0 32 32" width="32" height="32">
	      <circle id="spinner" cx="16" cy="16" r="14" fill="none"></circle>
	    </svg>
	  </div>


	</div>
  <!-- Uncomment the line below when ready to test with fake data -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js"></script>
	<script src="js/swiper.min.js" async></script>
	<script src="js/gauge.min.js" async></script>
  <script src="js/app.js" async></script>

</body>
</html>
