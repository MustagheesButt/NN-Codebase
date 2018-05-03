<footer>
	
	<div class="ftr-top">
		<div>
			<h4>Sitemap</h4>
			<ul>
				<a href="/"><li>Home</li></a>
				<a href="notes/"><li>Notes</li></a>
				<a href="past-papers/"><li>Past Papers</li></a>
				<a href="articles/"><li>Articles</li></a>
				<a href="online-tests/"><li>Online Tests</li></a>
				<a href="contact/"><li>Contact</li></a>
			</ul>
		</div>
		
		<div>
			<h4>Grades</h4>
			<ul>
				<a href="notes/9th/"><li>9th (Matric)</li></a>
				<a href="notes/10th/"><li>10th (Matric)</li></a>
				<a href="notes/first-year/"><li>First Year (Intermediate)</li></a>
				<a href="notes/second-year/"><li>Second Year (Intermediate)</li></a>
			</ul>
		</div>
		
		<div>
			<h4>Contact</h4>
			<ul>
				<a href="contact/"><li>Contact</li></a>
				<a href="privacy-policy/"><li>Privacy Policy</li></a>
				<a href="about-us/"><li>About Us</li></a>
			</ul>
		</div>
	</div>
	
	<div class="ftr-bottom">
		<p>&copy; Copyright 2016 - 2018. All rights reserved. Made with <i class="fa fa-heart"></i> in Pakistan.</p>
	</div>
</footer>

<!-- EXTERNAL STYLESHEETS -->
<link href='https://fonts.googleapis.com/css?family=Roboto:100,200,400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">

<!-- EXTERNAL SCRIPTS -->
<?php
	if (isset($injection))
		foreach ($injection as $element)
			echo $element;
?>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="scripts/NN-SDK.js"></script>
<script type="text/javascript">
		NN.init({
			client_id: 1,
			redirect_uri: "http://127.0.0.1/app/public/callback.php",
			scope: "username.first_name.last_name.email.profile_pic",
			SID: non_standard_sess_id()
		});

	function non_standard_sess_id () {
		return document.cookie.substr(document.cookie.indexOf("PHPSESSID=") + 10, (document.cookie.indexOf(";") == -1) ? document.cookie.length : document.cookie.indexOf(";") - 10);
	}

	$(".login-btn").click(function () {
		NN.login();
	});

	$(".logout-btn").click(function () {
		$.ajax({
			type: "POST",
			url: "members.php",
			data: {"logout": true},
			success: function (responseText) {
				//console.log(responseText);
				location.reload();
			}
		});
	});
</script>
<script src="scripts/script.js"></script>

</body>
</html>