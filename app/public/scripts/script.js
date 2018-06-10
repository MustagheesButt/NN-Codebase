$(document).ready(function () {
	$(".menu-btn i.fa-bars").click(function () {
		$("ul.nav-menu").toggleClass("active");
	});
	
	$(".accordion").accordion({
		heightStyle: "content"
	});
	$( ".accordion-closed" ).accordion({
		heightStyle: "content", collapsible: true, active: false
	});
	
	$("#tabs").tabs();

	if (document.querySelector(".sidebar"))
	{
		getDisplayQuote();
		getAd();
	}

	// IMPORTANT HIGHLIGHTER
	$(".imp-highlighter").click(function () {
		$(this).toggleClass("active");
		$(".important").toggleClass("highlighted");
	});
	
	// FILTER_TEXT - QA
	var array_to_filter_QA = $(".question .statement");
	var filter_input = $(".filter-text");
	
	filter_input.on("input", function () {
		var filter_val = $(this).val().toLowerCase();
		var unfiltered_list = [];
		
		array_to_filter_QA.each(function (index, value) {
			if ( value.innerHTML.toLowerCase().indexOf(filter_val) == -1 ) {
				unfiltered_list.push(array_to_filter_QA[index]);
			}
		});
		
		// update questions with the only filtered list visible
		$(".filtered-out-2").removeClass("filtered-out-2");
		unfiltered_list.forEach(function (item, index) {
			item.parentNode.className += " filtered-out-2";
		});
	});
	
	// FILTER_TEXT - TABLE
	var array_to_filter_TABLE = $(".has-filter tr td:nth-child(2)");
	var filter_input = $(".filter-text");
	
	filter_input.on("input", function () {
		var filter_val = $(this).val().toLowerCase();
		var unfiltered_list = [];
		
		array_to_filter_TABLE.each(function (index, value) {
			if ( value.innerHTML.toLowerCase().indexOf(filter_val) == -1 ) {
				unfiltered_list.push(array_to_filter_TABLE[index]);
			}
		});
		
		// update table with the only filtered list visible
		$(".filtered-out-1").removeClass("filtered-out-1");
		unfiltered_list.forEach(function (item, index) {
			item.parentNode.className += " filtered-out-1";
		});
	});
	
	// FILTER_ALPHABET - TABLE
	var array_to_filter = $(".has-filter tr td:nth-child(2)");
	var filter_input = $(".filter-alphabet");
	
	filter_input.on("input change", function () {
		var filter_val = $(this).val();
		var unfiltered_list = [];
		
		if (filter_val != "All") {
			array_to_filter.each(function (index, value) {
				if ( value.innerHTML.indexOf(filter_val) != 0 ) {
					unfiltered_list.push(array_to_filter[index]);
				}
			});
		}
		
		// update table with the only filtered list visible
		$(".filtered-out-2").removeClass("filtered-out-2");
		unfiltered_list.forEach(function (item, index) {
			item.parentNode.className += " filtered-out-2";
		});
	});

	// Arrange Past papers categorically
	if ($("h2.type").html() == "Past Papers") {
		var table = {
			"Lahore Board": ".lahore-board",
			"Gujranwala Board": ".gujranwala-board",
			"Unknown Board": ".unknown-board"
		};
		$(".scanned-img").each(function (index) {
			var alt = $(this).attr("alt");
			$(table[alt]).append($(this));
		});
		// remove the ones with nothing in 'em
		$.each(table, function (index, item) {
			if($(item).children().length <= 0) {
				$(item)[0].previousSibling.outerHTML = "";
				$(item).remove();
			}
		});
	}

	/**
	 ** GOOGLE ANALYTICS
	 ** EVENT TRACKING - only enable in production
	**/
	/*var imp_click_counter = 0;
	$(".imp-highlighter").click(function () {
		if (imp_click_counter % 2 == 0) {
			ga('send', 'event', 'Tools', 'Highlight', 'Highlighted Important Stuff');
		}
		imp_click_counter++;
	});*/

	/** LOGIN HANDLERS **/
	NN.init({
		client_id: 1,
		scope: "id.first_name.last_name.email",

		loginCallback: function (response) {
			$.ajax({
				type: "POST",
				url: "members.php/",
				data: {
					"user_id": response.id,
					"full_name": response.first_name + " " + response.last_name,
					"email": response.email,
					"about": "Hi! I'm a student.",
					"access_token": NN.access_token
				},
				success: function (responseText) {
					//console.log(responseText);
					if (responseText == "logged in" || responseText == "registered")
						location.reload(); // refresh page
				}
			});
		}
	});

	$(".login-btn").click(function (e) {
		e.preventDefault();
		NN.login();
	});

	$(".logout-btn").click(function () {
		$.ajax({
			type: "POST",
			url: "members.php",
			data: {"logout": true},
			success: function (responseText) {
				location.reload();
			}
		});
	});
	/** LOGIN HANDLERS END **/
});

function getDisplayQuote() {
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			allQuotes = JSON.parse(xhr.responseText);
			x = Math.round(Math.random() * allQuotes.length)
			document.querySelector("#random-quote > blockquote").innerHTML = allQuotes[x].quote;
			document.querySelector("#random-quote > cite").innerHTML = "&mdash; " + allQuotes[x].name;
		}
	};
	xhr.open("GET", "data/quotes.json", true);
	xhr.send();
}

function getAd() {

	$.ajax({
		type: "POST",
		url: "AdvertisementController.php/",
		data: {
			"getAd": true
		},
		success: function (responseText) {
			console.log(responseText);
			var ad = JSON.parse(responseText);

			document.querySelector("#ad-container > a > img").src = "./images/ads/" + ad.image;
			document.querySelector("#ad-container > a").href = "./adsense/" + ad.id + "/" + window.encodeURIComponent(ad.url).replace(/%2F/g, "%252F") + "/";
		}
	});
}