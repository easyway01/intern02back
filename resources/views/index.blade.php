<html lang="en">
<head>
	<title>My HTML Lesson</title>
	<meta charset="utf-8">	
	<style>

	ul.topnav {
		list-style-type: none;
		margin: 0;
		padding: 0;
		overflow: hidden;
		background-color: #333;
	}

	ul.topnav li {float: left;}
	ul.topnav li a:hover{background-color:darkslateblue;}
	ul.topnav li a {
		display: block;
		color: white;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
	}	

	.logo-container {
        display: flex;
        justify-content: center;
        gap: 30px; /* 图片之间的间距 */
        flex-wrap: wrap;
    }
    .logo img {
        height: 200px;
    }
    .desc {
        font-size: 18px;
        margin: 0 10%;
    }
	</style>
	<link href="main.css" rel="stylesheet">
</head>
<body>
	<header>
		<ul class="topnav">
			<li><a href="index.html">Home</a></li>
			<li><a href="myWeb.html">HTML</a></li>
			<li><a href="contact.html">Contact Us</a></li>
		</ul>
	</header>
	<!-- <nav style="margin-bottom:20px">
		<a href="index.html" style="text-decoration:none;background-color:greenyellow;margin-left:15px;">Home</a>
		<a href="myWeb.html" style="text-decoration:none;background-color:greenyellow;margin-left:15px;">HTML Lesson</a>
		<a href="contact.html" style="text-decoration:none;background-color:greenyellow;margin-left:15px;">Contact Us</a>
	</nav> -->
	<main>
		<div style="width:100%;height:300px;margin-top: 5%;text-align: center">
			<div class="logo">
				<img src="{{ asset('images/html.png')}}" alt="html logo" height="300">
			</div>
			<div class="logo">
                <img src="{{ asset('images/css.png')}}" alt="css logo" height="300">
            </div>
            <div class="logo">
                <img src="{{ asset('images/js.png')}}" alt="JavaScript logo" height="300">
            </div>
		</div>
		<div style="width:100%;height:300px;margin-top: 4%;text-align: center">
			<p class="desc">Our step-by-step guide teaches you the basics of HTML and how to build your first website. That means how to layout an HTML page, how to add text and images, how to add headings and text formatting, and how to use tables.</p>
		</div>

	</main>
	<footer>
		<a href="https://www.facebook.com/">FACEBOOK</a>
	</footer>
	
	
	
</body>


</html>