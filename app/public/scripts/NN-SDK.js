/*
 * NotesNetwork JavaScript SDK. Copyright, NotesNetwork 2017-2018. All rights reserved.
 *
 * This software comes with the login functionality provided by NotesNetwork, and is open source.
 * It may be modified for any purposes.
 */

var NN = {
	clientID: null,
	redirectURI: null,
	child: null,
	callback: null,
	scope: null,
	SID: null,

	init: function (initData) {
		this.clientID = initData.client_id;
		this.redirectURI = initData.redirect_uri;
		this.scope = initData.scope;
		this.SID = initData.SID;
	},
	login: function (callback) {
		var base_url = 'http://localhost/accounts';

		window.location = base_url + '/ServiceLogin/' + this.clientID + '?next=' + encodeURIComponent(window.location) + '&sess_id=' + this.SID;
	},
	loggedIn: function (access_token) {
		this.child.close();

		$.ajax({
			type: "POST",
			url: base_url + "/api/user" + this.scope,
			data: {
				"access_token": access_token
			},
			success: function (responseText) {
				this.callback(info);
			}
		});
	}
}

// $(".login-btn").click(function () {
// 	NN.login(function (response) {
// 		$.ajax({
// 			type: "POST",
// 			url: "members.php/",
// 			data: {
// 				"user_id": response.id,
// 				"full_name": response.first_name + " " + response.last_name,
// 				"email": response.email,
// 				"profile_pic": "some url later replaced by info.profile_pic",
// 				"about": "The spirit indeed is willing, but the flesh is weak.",
// 				"access_token": response.access_token
// 			},
// 			success: function (responseText) {
// 				//console.log(responseText);
// 				if (responseText == "logged in" || responseText == "registered") {
// 					location.reload();
// 				}
// 			}
// 		});
// 	});
// });