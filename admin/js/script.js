//functions
 function initMenu() {

	$('.menu ul').hide();
	$('.menu ul:first').show();
	$('.menu li').on('click','a',function() {
	  	var checkElement = $(this).next();
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			console.log("Is visible");
			return false;
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			console.log("Is not visible");
			$('.menu ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
			return false;
		}
	});

}


function noticeAlert(noticeBody){
	$("#notice").removeAttr("class").removeAttr("style");
	$("#notice").css("display","block").addClass("fadeInDown").addClass("animated");
	$("#notice p").html(noticeBody);
}

function hideNotice(){
	$("#notice").removeClass("fadeInDown").addClass("fadeOutUp");
}

function prettyCode(code){

	code = code.replace(/\n/g,' ');
	codeArray = code.split(' ');
	for(i = 0; i< codeArray.length; i++){
		codeArray[i] = codeArray[i].replace(/\s/g,'');
	}

	var keywords = new Array('select','from','join','on','where','desc','asc','limit','order','by','insert','values','into','set','update');

	var nlBreakers = new Array('select');
	var fnlBreakers = new Array('from','join','where','order','limit');

	var newCodeArray = new Array();

	for(i = 0;i<codeArray.length;i++){

		var part = codeArray[i].toLowerCase();

		if(keywords.indexOf(part) != -1){
			newCodeArray[i] = '<span style="color:#708;">'+codeArray[i]+'</span>';
		} else if($.isNumeric(part)){
			newCodeArray[i] = '<span style="color:#164;">'+codeArray[i]+'</span>';
		} else {
			newCodeArray[i] = '<span style="color:#05a;">'+codeArray[i]+'</span>';
		}

	}

	var code = '';

	code = newCodeArray.join(' ');

	return code;

}

/*function updSubject(response){
	$("#subject").empty();
	$("#subject").append(response);
}

function updPostTyp(response){
	$("#postTyp").empty();
	$("#postTyp").append(response);
}*/

function renderImg(data){
	$("#imgThumbContainer").append('<span class="imgThumb"><img src="'+data.thumbPath+'" alt="'+data.imgName+'" data-width="'+data.imgWidth+'" data-height="'+data.imgHeight+'" data-size="'+data.fileSize+'" data-imgPath="'+data.imgPath+'"/></span>');
}

function genImgDetail(imgName,width,height,size,imgPath,thumbPath){
	$("#imgDetail p").html('Name: '+imgName+'<br />Dimensions: '+width+' x '+height+'<br />Image Size: '+Math.ceil(size/1024)+' KB<br />Image Path:<input type="text" style="width:100%;padding:0.5em;" name="imgPath" value="'+imgPath+'"><br /><span class="anchor-btn delImg" data-imgLink="'+imgPath+'" data-thumbLink="'+thumbPath+'">Delete this Image?</span><br /><i><small>Copy above link and paste to get the image source</small></i>').fadeIn();
}

$(document).ready(function(){
	initMenu();
	//$(".query").niceScroll({ autohidemode: true })
	//$("#noteTxt").niceScroll({ autohidemode: true })

	$("#updates .cross").click(function(){
		$(this).parent().fadeOut();
	});
	
	$("#ok").click(function(){
		hideNotice();
		return false;
	});
	
	$(".tbl_container").on('click','.postPend',function(){
		var postId = $(this).attr("data-postId");
		$("tr[data-postId='"+postId+"'] td:last-child").prepend('<img src="../../assets/img/loading.gif" class="loading">');
				
		$.ajax({
			type: "POST",
			url: "publish.php",
			dataType : "json",
			data: { postId : postId},
		    success: function(data) {
				if(data.success){
					$("tr[data-postId='"+postId+"'] td:last-child").html('Posted').css("color","#008ED7");
					$("tr[data-postId='"+postId+"'] a.postPend").parent().prepend(data.preview);
					$("tr[data-postId='"+postId+"'] a.postPend").hide();
				} else {
					$(".loading").hide();
					alert(data.errorMsg);
				}
		    }
		});
	});
			
	$(".tbl_container").on('click','.postDel',function(){							
		var postId = $(this).attr("data-postId");
		var boolConfirm = confirm("Are you sure you want to delete this post?");

		if(boolConfirm == true){
			$("tr[data-postId='"+postId+"'] td:last-child").prepend('<img src="../../assets/img/loading.gif" class="loading">');
			$.ajax({
				type: "POST",
				url: "delete.php",
				dataType: "json",
				data: { postId : postId },
				success: function(data){
					if(data.success) {
						$("tr[data-postId='"+postId+"']").slideUp();
					} else {
						$(".loading").hide();
						alert(data.errorMsg);
					}
				}
			});
		}
	});

	$(".tbl_container").on('click','.restorePost',function(){
		var postId = $(this).attr("data-postId");
		$("tr[data-postId='"+postId+"'] td:last-child").prepend('<img src="../../assets/img/loading.gif" class="loading">');
				
		$.ajax({
			type: "POST",
			url: "restore.php",
			dataType : "json",
			data: { postId : postId },
		    success: function(data) {
		    	console.log(data);
				if(data.success){
					$("tr[data-postId='"+postId+"']").slideUp();
				} else {
					$(".loading").hide();
					alert(data.errorMsg);
				}
		    }
		});
		return false;
	});

	$(".tbl_container").on('click','.permanentDel',function(){							
		var postId = $(this).attr("data-postId");
		var boolConfirm = confirm("Are you sure you want to delete this post forever?");

		if(boolConfirm == true){
			$("tr[data-postId='"+postId+"'] td:last-child").prepend('<img src="../../assets/img/loading.gif" class="loading">');
			//window.location.assign(src);
			$.ajax({
				type: "POST",
				url: "delForever.php",
				dataType: "json",
				data: { postId : postId},
				success: function(data){
					if(data.success) {
						$("tr[data-postId='"+postId+"']").slideUp();
					} else {
						$(".loading").hide();
						alert(data.errorMsg);
					}
				}
			});
		}
		return false;
	});


	//hiding the elements
	/*
	$("#class").change(function(){
		var classId = $(this).val();
		if(classId != 0){
			$(".subject").hide();
			$(".postTyp").hide();
			$.ajax({
				type: "POST",
				url: "subject_list.php",
				data: {classId : classId},
				success: function(response){
					updSubject(response);
				}
			});
			$(".subject").show();
		} else {
			$(".subject").hide();
			$(".postTyp").hide();
			$("#submitPost").attr('disabled','disabled');
		}
	});
	
	$("#subject").change(function(){
		var subjectId = $(this).val();
		if(subjectId != 0){
			$(".postTyp").hide();
			$.ajax({
				type: "POST",
				url: "postTyp_list.php",
				data: {subjectId : subjectId},
				success: function(response){
					updPostTyp(response);
				}
			});
			$(".postTyp").show();
		} else {
			$(".postTyp").hide();
			$("#submitPost").attr('disabled','disabled');
		}
	});*/
	
	$("#postTyp").change(function(){
		if($(this).val() != 0){
			$("#submitPost").removeAttr('disabled');
		} else {
			$("#submitPost").attr('disabled','disabled');
		}
	});


	$("#submitPost").click(function(e){
		e.preventDefault();
		$(this).attr("disabled","disabled").val("Processing request...");
		var postTitle = $.trim($("input[name='postTitle']").val());
		//var postText = $.trim(tinyMCE.activeEditor.getContent());
		var postTypId = $("#postTyp").val();
		var postText = $.trim(CKEDITOR.instances.postText.getData());
		var subjectId = $("#subject").val();

		if(postTitle == '' || postText == ''){
			noticeAlert("All fields must be complete!");	
		} else {
			if($("input[name='imp']").is(":checked")){
				var imp = 1;
			} else {
				var imp = 0;
			}

			$.ajax({
				url: 'post.php',
				dataType: 'json',
				type: 'post',
				data: {
					postTitle: postTitle,
					postText: postText,
					postTypId: postTypId,
					subjectId: subjectId,
					imp: imp
				},
				success: function(data){
					$("#submitPost").removeAttr("disabled").val("Request to publish");
					if(data.success){
						noticeAlert("Post has been Succesfully submitted!");
						$("input[name='postTitle']").val('');
						$("#subject").val('0');
						$("#postTyp").val('0');
						CKEDITOR.instances.postText.setData('');
					} else {
						noticeAlert(data.errorMsg);
					}
				}
			});
		}

		return false;
	});

	$("#updatePost").click(function(e){
		e.preventDefault();
		$(this).attr("disabled","disabled").val("Updating...");
		var postTitle = $.trim($("input[name='postTitle']").val());
		//var postText = $.trim(tinyMCE.activeEditor.getContent());
		var postText = $.trim(CKEDITOR.instances.postText.getData());
		var id = $("input[name='id']").val();

		if(postTitle == '' || postText == ''){
			noticeAlert("All fields must be complete!");	
		} else {
			if($("input[name='imp']").is(":checked")){
				var imp = 1;
			} else {
				var imp = 0;
			}

			$.ajax({
				url: 'update.php',
				dataType: 'json',
				type: 'post',
				data: {
					id:  id,
					postTitle: postTitle,
					postText: postText,
					imp: imp
				},
				success: function(data){

					$("#updatePost").removeAttr("disabled").val("Update");
					if(data.success){
						noticeAlert("Post has been Succesfully updated!");
					} else {
						noticeAlert(data.errorMsg);
					}
				}
			});
		}
		return false;
	});

	$("#publishBtn").click(function(){
		$(this).attr("disabled","disabled").val('Publishing...');
		var postId = $("input[name='id']").val();
		var postTypId = $("input[name='postTypId']").val();
		
		$.ajax({
			type: "POST",
			url: "publish.php",
			dataType : "json",
			data: { postId : postId, postTypId : postTypId },
		    success: function(data) {
		    	console.log(data);
				if(data.success){
					$("#publishBtn").fadeOut();
					$(".postStatus").text("Posted");
					noticeAlert("This post has been successfully published.");
				} else {
					alert(data.errorMsg);
					$("#publishBtn").removeAttr("disabled").val('Publish');
				}
		    }
		});
	});

	$("#updateAdmin").click(function(){
		$(this).attr("disabled","disabled").attr("value","Updating...");
		var firstName = $.trim($("#updateAdminForm input[name='firstName']").val());
		var lastName = $.trim($("#updateAdminForm input[name='lastName']").val());
		var email = $.trim($("#updateAdminForm input[name='email']").val());
		var phone = $.trim($("#updateAdminForm input[name='phone']").val());
		var username = $.trim($("#updateAdminForm input[name='username']").val());
		var password = $.trim($("#updateAdminForm input[name='password']").val());
		var repassword = $.trim($("#updateAdminForm input[name='re-password']").val());
		var adminId = $("#updateAdminForm input[name='adminId']").val();

		$.ajax({
			type: "POST",
			url: 'update.php',
			data: {
				adminId : adminId,
				firstName : firstName,
				lastName : lastName,
				email : email,
				phone : phone,
				username : username,
				password : password,
				repassword : repassword
			},
			success: function(data){
				if(data == 'empty'){
					noticeAlert("Fill Empty Fields");
				} else if(data == 'unmatch'){
					noticeAlert("Passwords donot match.");
					$("#updateAdmin input[name='password']").val('');
					$("#updateAdmin input[name='re-password']").val('');
				} else if(data == 'error'){
					noticeAlert("Opps! Something went wrong. Try again later");
				} else if(data == 'alreadyAdded'){
					noticeAlert("Username is already used. Please user another username");
					$("#updateAdminForm input[name='username']").focus();
				} else if(data == 'success'){
					noticeAlert("Admin has been successfully updated");
					$("#updateAdminForm input[name='password']").val('');
					$("#updateAdminForm input[name='re-password']").val('');
				}
				$("#updateAdmin").removeAttr("disabled").attr("value","Update");
			}
		});
		return false;
	});

	$("#addAdmin").click(function(){
		$(this).attr("disabled","disabled").attr("value","Adding...");
		var firstName = $.trim($("#addAdminForm input[name='firstName']").val());
		var lastName = $.trim($("#addAdminForm input[name='lastName']").val());
		var email = $.trim($("#addAdminForm input[name='email']").val());
		var phone = $.trim($("#addAdminForm input[name='phone']").val());
		var username = $.trim($("#addAdminForm input[name='username']").val());
		var password = $.trim($("#addAdminForm input[name='password']").val());
		var repassword = $.trim($("#addAdminForm input[name='re-password']").val());
		var roleId = $("#addAdminForm select[name='role']").val();

		$.ajax({
			type: "POST",
			url: 'addAdmin.php',
			data: {
				firstName : firstName,
				lastName : lastName,
				email : email,
				phone : phone,
				username : username,
				password : password,
				repassword : repassword,
				roleId : roleId
			},
			success: function(data){
				if(data == 'empty'){
					noticeAlert("Fill Empty Fields");
				} else if(data == 'unmatch'){
					noticeAlert("Passwords donot match.");
					$("#addAdminForm input[name='password']").val('');
					$("#addAdminForm input[name='re-password']").val('');
				} else if(data == 'error'){
					noticeAlert("Opps! Something went wrong. Try again later");
				} else if(data == 'alreadyAdded'){
					noticeAlert("Username or email is already used. Please user another username");
					$("#addAdminForm input[name='username']").focus();
				} else if(data == 'success'){
					noticeAlert("Admin has been successfully Added. Its account details will be sent to its email.");
					$("#addAdminForm input[name='firstName']").val('');
					$("#addAdminForm input[name='lastName']").val('');
					$("#addAdminForm input[name='email']").val('');
					$("#addAdminForm input[name='phone']").val('');
					$("#addAdminForm input[name='username']").val('');
					$("#addAdminForm input[name='password']").val('');
					$("#addAdminForm input[name='re-password']").val('');
				}
				$("#addAdmin").removeAttr("disabled").attr("value","Add");
			}
		});
		return false;
	});

	$(".delAdmin").click(function(){
		$(this).css("opacity","0.5");
		var boolConfirm = confirm("Are you sure you want to delete this admin?");

		if(boolConfirm == true){
			var adminId = $(this).attr('data-adminId');
			$.ajax({
				type: "post",
				url: "del.php",
				data: {
					adminId : adminId
				},
				success: function(data){
					$(this).css("opacity","1");
					if(data == 'error'){
						noticeAlert('Opps! Something went wrong. Try again later');
					} else {
						noticeAlert('Admin of id ' + adminId + ' has been successfully deleted.');
						$("tr#"+adminId).slideUp('slow');
					}
				}
			});
		} else {
			$(this).css("opacity","1");
		}

		return false;
	});

	/*$(".menu_link").click(function(){
		if(parseInt($("#sidebar").css("left")) == 0){
			$("#sidebar").css("left","-155px");
		} else {
			$("#sidebar").css("left","0");
		}
		
		return false;
	});*/

	var pathname = window.location.pathname.substring(window.location.pathname.lastIndexOf("/") + 1);
	if(pathname != 'login.php' && pathname != 'forgot.php' && pathname != 'reset.php'){
		var jPM = $.jPanelMenu({
		    menu: '#navigation',
		    trigger: '.menu_link',
		    openPosition: '200px',
		    excludedPanelContent: "#header"
		});

		if($(window).width() < 800){
			jPM.on();
			initMenu();
		}
	}

	$(window).resize(function(){
		if($(window).width() < 800){
			if(!$('html').hasClass('jPanelMenu') && (pathname != 'login.php' && pathname != 'forgot.php' && pathname != 'reset.php')){
				jPM.on();
				initMenu();
			}
		} else {
			if($('html').hasClass('jPanelMenu')){
				jPM.off();
			}
		}
	});

	$("#forgotPromptBtn").click(function(){
		$(".loginResp").attr("id","loginAuth").html("Processing for reseting password...").fadeIn();
		var email = $.trim($("#forgotForm input.logintxt").val());
		if(email == ''){
			$(".loginResp").attr("id","loginError").html("Enter valid email!");
		} else {
			$.ajax({
				type: "post",
				url: "forgot_test.php",
				dataType: "json",
				data: {email: email},
				success: function(data){
					if(data.success){
						$(".loginResp").attr("id","loginSuccess").html("Your Account Details has been sent to your email.");
					} else {
						$(".loginResp").attr("id","loginError").html(data.errorMsg);
					}
				}
			});
		}
		return false;
	});

	$("#passResetBtn").click(function(){
		$(".loginResp").attr("id","loginAuth").html("Processing for reseting password...").fadeIn();
		var email = $.trim($("#resetForm input[name='email']").val());
		var password = $.trim($("#resetForm input[name='password']").val());
		var repassword = $.trim($("#resetForm input[name='repassword']").val());
		var token = $("#resetForm input[name='token']").val();

		if(email == '' || password == '' || repassword == ''){
			$(".loginResp").attr("id","loginError").html("Fill All Fields!");
		} else {
			$.ajax({
				type: "post",
				url: "reset_test.php",
				dataType: "json",
				data: {
					email : email,
					password : password,
					repassword : repassword,
					token : token
				},
				success: function(data){
					if(data.success){
						$(".loginResp").attr("id","loginSuccess").html("Your Account password has been reset.");
					} else {
						$(".loginResp").attr("id","loginError").html(data.errorMsg);
						if(data.error == 3){
							$("#resetForm input[name='password']").val('');
							$("#resetForm input[name='repassword']").val('');
						}
					}
				}
			});
		}
		return false;
	});

	$("input[name='query']").click(function(){
		$("#returnQuery").hide();
		$("#returnTbl").hide();

		var query = $.trim($("textarea[name='queryString']").val());

		$(this).attr("disabled","disabled").val("QUERYING...");

		$.ajax({
			type: "post",
			url: "query.php",
			dataType: "json",
			data: { query : query },
			success: function(data){
				console.log(data);
				$("input[name='query']").removeAttr("disabled").val("QUERY");
				if(data.success){
					if(data.returnTbl){
						$("#returnQuery").fadeIn();
						$("#returnTbl").fadeIn();
						$("#returnQuery").html("<p>" + data.numresult + " rows returned.</p><b>From Query:</b><br />"+prettyCode(query));
						$("#returnTbl").html(data.respData);
					} else {
						noticeAlert('<b> '+query+'</b> :Succesfully Executed.');
					}
					$("textarea[name='queryString']").val('');
				} else {
					noticeAlert(data.errorMsg);
				}
			}
		});
		return false;
	});

	$("#imgExp").click(function(){
		/*$("#notice").removeAttr("class").removeAttr("style");
		$("#notice").css("display","block").addClass("fadeInDown").addClass("animated");*/
		$("#imgListDialog").removeAttr("style").removeAttr("class").css("display","block").addClass("fadeInDown").addClass("animated");
		if($("#imgThumbContainer").html() == ''){
			$.ajax({
				dataType: 'json',
				url: "getImgList.php",
				success:function(data){
					$("#imgThumbContainer").css("background","none");
					if(data == 'Generating Thumbnails'){
						console.log("Generating Thumbnails");
					}
					for(i = 0;i < data.length;i++){
						renderImg(data[i]);
					}
				},error:function(a,b,c){
					console.log(a);
					console.log(b);
					console.log(c);
				}
			});
		}
	});

	$("#imgListDialog .cross").click(function(){
		$("#imgListDialog").removeClass("fadeInDown").addClass("fadeOutUp");
		$("#imgThumbContainer .active").removeClass("active");
		$("#imgDetail p").fadeOut();
	});

	$("#imgThumbContainer").on('mouseenter','.imgThumb',function(){
		var alt = $(this).children("img").attr("alt");
		var pos = $(this).children("img").position();
		xpos = pos.left;
		ypos = pos.top+115;

		$(this).after('<div class="custom-thumb-alt" style="position:fixed;left:'+xpos+'px;top:'+ypos+'px;">'+alt+'</div>').fadeIn();
	});

	$("#imgThumbContainer").on('mouseleave','.imgThumb',function(){
		$(".custom-thumb-alt").fadeOut();
	});

	$("#imgThumbContainer").on('click','.imgThumb',function(){
		var imgName = $(this).children("img").attr("alt");
		var width = $(this).children("img").attr("data-width");
		var height = $(this).children("img").attr("data-height");
		var size = $(this).children("img").attr("data-size");
		var imgPath = $(this).children("img").attr("data-imgPath");
		var thumbPath = $(this).children("img").attr("src");
		genImgDetail(imgName,width,height,size,imgPath,thumbPath);
		$(".imgThumb").removeClass("active");
		$(this).addClass("active");
	});

	$("#imgDetail p").on('click',".delImg",function(){
		var imgLink = $(this).attr("data-imgLink");
		var thumbLink = $(this).attr("data-thumbLink");
		$.ajax({
			url: "delImg.php",
			type: "post",
			dataType: "json",
			data: {imgLink: imgLink, thumbLink: thumbLink},
			success:function(data){
				console.log(data);
				if(data.success){
					$('.imgThumb img[src="'+data.thumbLink+'"]').parent().fadeOut();
					$("#imgDetail p").fadeOut();
				} else{
					alert("Opps! Something Went Wrong! Please Try Again Later");
				}
			}
		});
	});

	$("#refreshPostList").click(function(){
		$(".tbl_container").html('<center><img src="../../assets/img/loading.gif" class="loading"> Loading Posts...</center>');
		$(".tbl_container").load("renderPostList.php");
		return false;
	});

});