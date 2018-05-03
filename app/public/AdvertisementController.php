<?php
	require("../includes/config.php");

	/*
	** 
	** Required functionality for displaying and managing Ads.
	**
	*/

	class AdvertisementController
	{
		public static function update_and_redirect()
		{
			$ad_id = $_GET['id'];
			$redirectTo = rawurldecode($_GET['redirectTo']);

			query("UPDATE `stats.ads` SET `clicks` = `clicks` + 1 WHERE `ad_id` = ?", $ad_id);

			redirect($redirectTo);
		}

		public static function get_ad()
		{
			// somehow knows which ad to return. probably based on keywords sent by JS Ajax request.
			$ad = query("SELECT * FROM `ads` WHERE `id` = 1")[0];
			query("UPDATE `stats.ads` SET `views` = `views` + 1 WHERE `ad_id` = ?", $ad["id"]);

			return $ad;
		}
	}

	/* Now Handle requests */
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST["getAd"]))
		{
			echo  json_encode(AdvertisementController::get_ad());
		}
	}
	elseif ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (isset($_GET["id"]) && isset($_GET["redirectTo"]))
		{
			AdvertisementController::update_and_redirect();
		}
	}

?>