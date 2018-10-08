<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php
       $setting= \Illuminate\Support\Facades\DB::table('screen_settings')->get();
    ?>

    <title>Enterprise World 2018 Expo</title>

    <!-- Scripts -->


    <!-- Tyepkit -->
    <script src="https://use.typekit.net/oae8zyf.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

    <!-- CSS -->
    <link rel="stylesheet" href="/socialwall/css/styles.css" />

</head>

<body class="mainLeaderboard">

<!-- Fixed Header -->
<header><img src="/socialwall/img/ew-games-logo.png" alt="The EW Games" /></header>


<!-- Carousel -->
<div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-slides="> div" data-cycle-pager=".pager">


   
    <!-- Social Wall -->
    
    <div id="socialWall" class="cycle-slide" data-cycle-timeout="17000">



                <div id="socialWallContainer">



                </div>




    </div>
   

   
</div><!-- End overall carousel container -->

<!-- Pager -->
<div class="pager"></div>



</body>

<script src="/socialwall/js/jquery-3.2.1.min.js"></script>
<script src="/socialwall/js/isotope.pkgd.min.js"></script>
<script src="/socialwall/js/packery-mode.pkgd.js"></script>
<script src="/socialwall/js/jquery.cycle2.min.js"></script>
<script src="/socialwall/js/scoreboard.js"></script>
<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script src="/socialwall/js/pusher.js"></script>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="/socialwall/js/functions.js"></script>

<script>
	
	window.setInterval(function() {
		
	    $('#socialWallContainer').isotope('destroy');
        $('#socialWallContainer').empty();
		getPosts();
		
	}, 30000);
	
</script>
<html>
