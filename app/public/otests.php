<?php
	
	require("../includes/functions.php");
	
	global $test;
	$Model = [
		"NET" => [
			"title" => "NET (NUST Entry Test) Mockup Exam",
			"desc" => "Online mockup examination of NET (NUST Entry Test).",
			"path_home" => "online_tests/NET/home",
			"path_test" => "online_tests/NET/test",
			"test_data" => ["subjects" => $_POST["subjects"], "timed" => $timed] // whatever is to be passed while rendering test template
		],
		"SAT" => [
			"title" => "SAT (Scholastic Aptitude Test)",
			"desc" => "Online mockup examination of SAT (Scholastic Aptitude Test) in co-operation with Khanacademy.",
			"path_home" => "online_tests/SAT/home",
			"path_test" => "online_tests/SAT/test",
			"test_data" => []
		],
		"general_knowledge" => [
			"title" => "General Knowledge",
			"desc" => "Test you general knowledge with our specially crafted quiz to benchmark your knowledge and memory.",
			"path_home" => "online_tests/Generic/home",
			"path_test" => "online_tests/Generic/test",
			"test_data" => ["test" => "general_knowledge", "test_title" => "General Knowledge", "path_data" => "./data/otests/general_knowledge.json"]
		],
		"computer_science" => [
			"title" => "Computer Science Quiz",
			"desc" => "Test you Computer Science knowledge with our specially crafted quiz to benchmark your knowledge and memory.",
			"path_home" => "online_tests/Generic/home",
			"path_test" => "online_tests/Generic/test",
			"test_data" => ["test" => "computer_science", "test_title" => "Computer Science", "path_data" => "./data/otests/computer_science.json"]
		]
	];

	/**
	 ** GET REQUEST
	 **/
	if ( !empty($_GET["test"]) ) {
		$test = $_GET["test"];
		render("header", ["title" => $Model[$test]["title"] . " | Online Tests",
								"desc" => $Model[$test]["desc"]]);
	}
	else {
		render("header", ["title" => "Online Tests",
								"desc" => "Online mockup examination of most popular entry tests, including NET, FAST Entry Test, NAT/NTS, PUCIT."]);
	}
	
?>

    <main>
		
		<?php
			/**
			 ** GET REQUEST
			 **/
			// Test Handler
			if ( isset($test) ) {
				render($Model[$test]["path_home"], $Model[$test]["test_data"]);
			}
			// Result Handler - Result page also does not requires a description(meta tag)
			elseif ( isset($_GET["result"]) ) {
				render("online_tests/result", ["marks" => $_GET["marks"],
												"percentage" => $_GET["perc"],
												"time_taken" => $_GET["tt"]]);
			}
			/**
			 ** POST REQUEST
			 **/
			elseif ( !empty($_POST) ) {
				$name = $_POST["name"];
				( !empty($_POST["timed"]) ) ? $timed = true : $timed = false;
				
				render($Model[$name]["path_test"], $Model[$name]["test_data"]);
			}
			/**
			 ** DEFAULT
			 **/
			else {
				render("online_tests/otests_default");
			}
			
		?>
		
	</main>

<?php render("footer"); ?>