$(document).ready(function(){

	var website = location.protocol + "//" + location.hostname + "/plus/";
	$(".slide").css('display','block');

	//functions
	function formWarning(warningText,element){
		var xpos = $("input[name *= "+ element +"]").offset().left;
		var ypos = $("input[name *= "+ element +"]").offset().top - 48;
		$(".formWarning").css("top",ypos).css("left",xpos).html(warningText).fadeIn();
	}

	function adjustMenu(){
		var ww = $("body").width();
		if(ww < 800){
			$("a.menu-link").css("background-position","0 0");
			$("#nav").css("display","none");
			$("ul.menu li").unbind("mouseenter mouseleave");
			$("ul.menu li").bind("click",function(){
				$(this).children("li.menu-hover").removeClass("menu-hover");
				$(this).prevAll("li.menu-hover").removeClass("menu-hover");
				$(this).nextAll("li.menu-hover").removeClass("menu-hover");
				$(this).prevAll().find("li.menu-hover").removeClass("menu-hover");
				$(this).nextAll().find("li.menu-hover").removeClass("menu-hover");
				$(this).addClass("menu-hover");
				var attr = $(this).children("a").first().attr("href");
				if(attr == "#"){
					return false;
				} else {
					window.location.assign(attr);
				}
				
			});
		} else {
			$("#nav").css("display","block");
			$("ul.menu").find("li.menu-hover").removeClass("menu-hover");
			$("ul.menu li").bind("mouseenter",function(){
				$(this).children("li.menu-hover").removeClass("menu-hover");
				$(this).prevAll("li.menu-hover").removeClass("menu-hover");
				$(this).nextAll("li.menu-hover").removeClass("menu-hover");
				$(this).prevAll().find("li.menu-hover").removeClass("menu-hover");
				$(this).nextAll().find("li.menu-hover").removeClass("menu-hover");
				$(this).addClass("menu-hover");
			});
			$("ul.menu li").bind("mouseleave",function(){
				$(this).parent().find("li.menu-hover").removeClass("menu-hover");
			});
		}
	}

	function adjustUserLeftCol(){
		var windowHeight = $(window).height();
		var bodyHeight = $("body").height();
		var headerHeight = $("#header").height();
		var footerHeight = $("#footer").height();

		if($(window).width() > 640){
			if(bodyHeight < windowHeight){
				var difference = windowHeight -bodyHeight  + footerHeight;
				var userLeftColHeight = $("#user-left-col").height() + difference;
				$("#user-left-col").css("height",userLeftColHeight);
			}
		}
	}

	/*function reloadCaptcha(){
		$("#captcha").attr("src",website + 'securimage/securimage_show.php?' + Math.random());
	}*/
	
	function checkEmpty(object){
		var objectVal = $.trim(object.val());
		if(objectVal == ''){
			return true;
		} else {
			return objectVal;
		}
	}

	function showFormError(warningText,formObj,formObjId){
		formObj.before('<span class="error '+formObjId+'">'+warningText+'</span>');
	}

	function checkBeforeElement(formObj,formObjId){
		var numEl = formObj.parent().find('.'+formObjId).length;
		if (numEl > 0){
			return true;
		} else {
			return false;
		}
	}

	function removePrevError(formObjId){
		$("."+formObjId).hide();
	}

	adjustMenu();
	
	if($("body #user-left-col").length > 0){
		adjustUserLeftCol();
	}

	/*$("#captcha").load(function(){
		$("#loading").hide();
	});

	$("#captcha-change").click(function(){
		$("#loading").show();
		reloadCaptcha();
		return false;
	});	*/

	//header-login
	$(".header-login-dropdown").click(function(){
		$(this).parent().parent().parent().find(".header-account-dropdown-menu").fadeToggle();
	});	
	
	//instant search script
	$("#header-search-input").focusin(function(){
		var searchq = $(this).val();
		searchq = $.trim(searchq);
		if(searchq != ''){
			$("#header-search-feedback").fadeIn();
		}
	});
	
	$("#header-search-input").keyup(function(){
		var search = $("#header-search-input").val();
		search = $.trim(search);
		if(search != '' && search.length >= 3){
			$("#header-search-feedback").fadeIn();
			$.post(website + "search/ajax.php",{search:search},
			function(data){
				$("#header-search-feedback").html(data);
			});
		} else {
			$("#header-search-feedback").fadeOut();
		}
		
	});
	
	$("#header-search-input").blur(function(){
		$("#header-search-feedback").fadeOut();
		
	});

	//comment system
	$("#comment-button").click(function(){
		var userId = $("#userIdhidden").val();
		var postId = $("#postIdhidden").val();
		var commentText = $.trim($("#commentText").val());

		if(commentText != ''){
			$(".loading").css("display","inline-block");

			$.ajax({
				type: "POST",
				url: website + "posts/comment.php",
				data: {
					userId : userId,
					postId : postId,
					commentText : commentText
				},
				success: function(data){
					if(data == false){
						$(".loading").css("display","none");
						$("#comment-container").append('<li class="comment comment-error">Opps! Something went wrong while Commenting. Please Try Again Later <a href="javascript:void(0)" class="cross">X</a></li>');
						$("#commentText").val("");
					} else {
						$("#commentText").val("");
						$(".loading").css("display","none");
						$("#comment-container").append(data);
						$("#comments #comment-container .comment:last-child").hide().fadeIn();
					}
				}
			});
		}
		 		
	});

	$(document).on("click",".cross",function(){
		$(this).parent().slideUp();
	});
	
	$("#seeOlder").click(function(){
		var commentNum = $(this).attr("data-lastComment");
		var postId = $(this).attr("data-postId");
		$(".comment:first-child .loading").css("display","inline-block");
		$.ajax({
			type: "POST",
			url: website + "posts/seeOlder.php",
			data: {postId: postId,commentNum : commentNum},
			success: function(data){
				if(data != false){
					$(".comment:first-child .loading").css("display","none");
					$("#seeOlder").hide();
					$(".numComment").css("float","left");
					$("#comment-container .comment:first-child").next().after(data);
				} else {
					$(".comment:first-child .loading").css("display","none");
					$("#comment-container").prepend('<li class="comment comment-error">Opps! Something went wrong while getting more comments. Please Try Again Later <a href="javascript:void(0)" class="cross">X</a></li>');
				}
			}
		});
	});
	$(".slidewrap").carousel();
	$(".slidewrap").resizeControl();
	
	//Social Sites API control
	$("#ytplayer-container").html('<iframe id="ytplayer" type="text/html" width="640" height="360" ratio="0.5625" src="https://www.youtube.com/embed/VNJAs3d6riA" frameborder="0" style="background:#000;">');
	$("#ytplayer").resizeControl();
	
	$(window).resize(function(){
		$(".slidewrap").resizeControl();
		adjustMenu();
		if($("body #user-left-col").length > 0){
			adjustUserLeftCol();
		}
	});

	/*$("#register-form input[name *= 'firstName']").keyup(function(){
		var nameLen = $.trim($(this).val()).length;
		if(nameLen > 30){
			formWarning("Omg! Too long to be your First Name",$(this).attr("name"));
		} else {
			if($(".formWarning").css("display") != "none"){
				$(".formWarning").fadeOut();
			}
		}
	});

	$("#register-form input[name *= 'lastName']").keyup(function(){
		var nameLen = $.trim($(this).val()).length;
		if(nameLen > 30){
			formWarning("Omg! Too long to be your Last Name",$(this).attr("name"));
		} else {
			if($(".formWarning").css("display") != "none"){
				$(".formWarning").fadeOut();
			}
		}
	});

	$("#register-form input[name *= 'email'").keyup(function(){
		var email = $.trim($(this).val());
		var emailLen = email.length;
		if(emailLen > 50){
			formWarning("Omg! So long Email",$(this).attr("name"));
		} else {
			if($(".formWarning").css("display") != "none"){
				$(".formWarning").fadeOut();
			}
		}
	}).blur(function(){
		var email = $.trim($(this).val());
		if(email != ''){
			$.ajax({
				type: "POST",
				url: "check-email.php",
				data: {email : email},
				success: function(data){
					if(data == 1){
						formWarning("Opps! This email has already been used",$("#register-form input[name *= 'email'").attr("name"));
					} else if(data == 2){
						formWarning("Opps! You typed an invalid email",$("#register-form input[name *= 'email'").attr("name"));
					} else {
						formWarning("Opps! Something Went Wrong",$("#register-form input[name *= 'email'").attr("name"));
					}
				}
			});
		}
	});

	$("#register-form input[name *= 'password']").keyup(function(){
		var nameLen = $.trim($(this).val()).length;
		if(nameLen > 50){
			formWarning("Omg! Too long Password",$(this).attr("name"));
		} else {
			if($(".formWarning").css("display") != "none"){
				$(".formWarning").fadeOut();
			}
		}
	});*/

	$("#addInstitution").click(function(){
		$("#addInstitutionOptTrigger").hide();
		$("#addInstitutionOpt").fadeIn();
	});

	$("#addInstitutionOpt .anchor-btn").click(function(){
		var institutionName = $.trim($("#institutionName").val());
		if(institutionName.length != ''){
			$("#addInstitutionOpt").fadeOut();
			$("#addInstitutionOptFeedback").html("Regenerating List...").fadeIn();
			$.ajax({
				type: "POST",
				url: "addInstitution.php",
				data: { institutionName : institutionName },
				success: function(html){
					$("#institutionName").val('');
					$("#institutionList").empty();
					$("#institutionList").append(html);
					$("#addInstitutionOptFeedback").html("").hide();
					$("#addInstitutionOptTrigger").fadeIn();
				}
			});
		} else {
			formWarning("No name institution?",$("#institutionName").attr("name"));
		}
	});

	$("#institutionName").keyup(function(){
		var institutionName = $.trim($(this).val());
		if(institutionName != ''){
			$(".formWarning").fadeOut();
		}
	});

	$("#seeMorePr").click(function(){
		var prNum = $(".postReview").length;
		$.ajax({
			type: "POST",
			url: website + "seeMorePr.php",
			data: {prNum : prNum},
			success: function(data){
				if(data == false){
					alert("error");
				} else {
					$("#postReviewContainer").append(data);
				}
			}
		});
	});

	$(".menu-link").click(function(){
		if($("#nav").css("display") == 'none'){
			display = "block";
			$(this).css("background-position","-24px 0");
		} else {
			display = "none";
			$("ul.menu").find("li.menu-hover").removeClass("menu-hover");
			$(this).css("background-position","0 0");
		}
		$("#nav").css("display",display);
	});

	$(document).scroll(function(){
		var scroll_top = $(this).scrollTop();
		var header_height = $("#header").height();
		if(scroll_top > header_height + 50){
			var showFixedHeader = true;
		} else {
			var showFixedHeader = false;
		}

		if(showFixedHeader){
			$("#fixedHeader").slideDown();
		} else {
			$("#fixedHeader .header-account-dropdown-menu").css("display","none");
			$("#fixedHeader").slideUp();
		}
	});

	/*$("#like").click(function(){
		var postId = $(this).attr("data-postId");
		$.ajax({
			type: "POST",
			url: website + "posts/showpost/like.php",
			data: {postId : postId},
			success: function(data){
				if(data != false){
					if(data == "liked"){
						$(".likeUserActivity").html('<a href="'+ website +'account/profile/">You</a> and ');
						$("#like").text("Unlike");
					} else {
						$(".likeUserActivity").html('');
						$("#like").text("Like");
					}
				}
			}
		});
	});*/

});