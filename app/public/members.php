<?php
	
	require("../includes/config.php");
	
	/**
	 ** Handle Login/Register/Logout + Data Update POST requests
	 **/
	if ($_SERVER["REQUEST_METHOD"] == "POST") { // if user reached via form submission, Ajax etc
		/** Data Update Request **/
		if (!empty($_POST["new_pic_url"])) { // since $_POST is always set, we can't use isset()
			query("UPDATE `accounts.users` SET `profile_pic` = ? WHERE `user_id` = ?", $_POST["new_pic_url"], $_SESSION["user_id"]);
			die("pic updated");
		}
		if (!empty($_POST["new_fullname"])) {
			query("UPDATE `accounts.users` SET `full_name` = ? WHERE `user_id` = ?", $_POST["new_fullname"], $_SESSION["user_id"]);
			die("fullname updated");
		}
		if (!empty($_POST["new_about_info"])) {
			query("UPDATE `accounts.users` SET `about_me` = ? WHERE `user_id` = ?", $_POST["new_about_info"], $_SESSION["user_id"]);
			die("about_info updated");
		}
		if (isset($_POST["public"])) {
			$rows = query("SELECT * FROM `users.tests` WHERE `user_id` = ?", $_SESSION["user_id"]);
			$_POST["public"] = array_map("intval", explode(",", $_POST["public"])); // not needed if form not submitted via JS
			
			foreach ($rows as $key => $value) {
				if (in_array($value["counter"], $_POST["public"]) && $value["public"] == 0)
					query("UPDATE `users.tests` SET `public` = 1 WHERE `counter` = ? AND `user_id` = ?", $value["counter"], $_SESSION["user_id"]);
				elseif (!in_array($value["counter"], $_POST["public"]) && $value["public"] == 1)
					query("UPDATE `users.tests` SET `public` = 0 WHERE `counter` = ? AND `user_id` = ?", $value["counter"], $_SESSION["user_id"]);
			}
			die("tests privacy updated");
		}

		/** Logout Request **/
		if (isset($_POST["logout"])) {
			logout();
			die("logged out");
		}

		/** Login/Register **/
		$data_to_submit = [
			"email" => $_POST['email'],
			"user_id" => $_POST['user_id'],
			"full_name" => $_POST['full_name'],
			"profile_pic" => $_POST['profile_pic'],
			"about" => $_POST['about'],
		];
		
		login_or_register($data_to_submit);
		
	} elseif ($_SERVER["REQUEST_METHOD"] == "GET") { // if user reached via clicking a link etc
		$mode = "default";
		$Profile;
		$Test;

		if ( isset($_GET["profile"]) && isset($_GET["test"]) ) {
			$mode = "test";
		} elseif ( isset($_GET["profile"]) ) {
			$mode = "profile";
		} elseif ( isset($_GET["login"]) ) {
			$mode = "login";
		}
		
		if ($mode == "test") {
			$member = query("SELECT * FROM `accounts.users` WHERE `user_id` = ?", $_GET["profile"]);
			$Profile = $member[0];
			
			render("header", ["title" => $Profile["full_name"] . "'s Test Details on NotesNetwork", "desc" => "View the public test details of " . $Profile["full_name"] . " on NotesNetwork.",
				"injection" => ["<meta property=\"og:image\" content=\"" . $Profile["profile_pic"] . "\" />",
				"<script type=\"text/javascript\" src=\"//platform-api.sharethis.com/js/sharethis.js#property=59202e17baf27a00129fc5cb&product=inline-share-buttons\" async></script>"]]);
		} elseif ($mode == "profile") {
			$member = query("SELECT * FROM `accounts.users` WHERE `user_id` = ?", $_GET["profile"]);
			$Profile = $member[0];

			render("header", ["title" => $Profile["full_name"] . " on NotesNetwork", "desc" => "View the public profile of " . $Profile["full_name"] . " on NotesNetwork.",
				"injection" => ["<meta property=\"og:image\" content=\"" . $Profile["profile_pic"] . "\" />",
				"<script type=\"text/javascript\" src=\"//platform-api.sharethis.com/js/sharethis.js#property=59202e17baf27a00129fc5cb&product=inline-share-buttons\" async></script>",
				"<script type=\"text/javascript\" src=\"https://www.gstatic.com/charts/loader.js\"></script><script type=\"text/javascript\">google.charts.load('current', {packages: ['corechart']});// callback is defined in the template</script>"]]);
		} elseif ($mode == "login") {
			render("header", ["title" => "Login/Sign-up", "desc" => "Login to NotesNetwork to save the results of your tests, see analytics and much more. Don't have an account? Create one now!"]);
		} else {
			$member = query("SELECT * FROM `accounts.users` WHERE user_id = ?", $_SESSION["user_id"]);
			$Profile = $member[0];
			render("header", ["title" => "My Account", "desc" => "Change your account settings here. Add more information about yourself or update existing information."]);
		}

	?>
		
	    <main class="<?php if ($mode == 'login') echo 'sided'; ?> dark-links">
				
				<?php
					
					// being a good citizen
					if ($mode == "test")
					{
						render("/../templates/members/test_details", ["Data" => $Profile, "Model" => $TestsModel]);
						echo '<section><div class="sharethis-inline-share-buttons"></div></section>';
					}
					elseif ($mode == "profile")
					{
						if ( file_exists(__DIR__ . "/../templates/members/profile.php") )
						{
							$User_tests = query("SELECT * FROM `users.tests` WHERE `user_id` = ? AND `public` = 1", $Profile["user_id"]);
							render("/../templates/members/profile", ["Data" => ["Profile" => $Profile, "User_tests" => $User_tests], "Model" => $TestsModel]);
							echo '<section><div class="sharethis-inline-share-buttons"></div></section>';
						}
						else
						{
							echo "<h2>The File does not exists! The path provided probably does not exists.</h2>"; // 404
							echo __DIR__ . "/../templates/members/profile.php";
						}
					}
					elseif ($mode == "login")
					{
						render("/../templates/members/login");
					}
					else
					{
						$User_tests = query("SELECT * FROM `users.tests` WHERE `user_id` = ?", $Profile["user_id"]);
						render("/../templates/members/account", ["Data" => ["Profile" => $Profile, "User_tests" => $User_tests], "Model" => $TestsModel]);
					}
					
				?>
			
		</main>
		
	<?php
		if ($mode == "test")
			render("components/MathJax");
		if ($mode == "login")
			render("components/sidebar");
		
		render("footer");
	}
?>