
/*
**************************
(C)2010-2014 urkeji.com
update: 2014-5-31 00:40:41
person: Feng
**************************
*/


$(function(){

	$(".input").focus(function(){
		$(this).attr("class","inputOn");
	}).blur(function(){
		$(this).attr("class","input");
	});
	
	$("#dbhost").focus();
})


function CheckForm()
{

	var format = /^[a-zA-Z0-9_-]+$/;

	if($("#dbhost").val() == "")
	{
		alert("请输入数据库服务器！");
		$("#dbhost").focus();
		return false;
	}

	if($("#dbname").val() == "")
	{
		alert("请输入数据库名！");
		$("#dbname").focus();
		return false;
	}

	if(!format.exec($("#dbname").val()))
	{
		alert("数据库名非法！请使用[a-zA-Z0-9_]内的字符！！");
		$("#dbname").focus();
		return false;
	}

	if($("#dbuser").val() == "")
	{
        alert("请输入数据库用户！");
       	$("#dbuser").focus();
        return false;
    }

	if($("#username").val() == "")
	{
		alert("请输入管理员账号！");
		$("#username").focus();
		return false;
	}
    if(!format.exec($("#username").val()))
    {
        alert("用户名非法！请使用[a-zA-Z0-9_]内的字符！！");
        $("#username").focus();
        return false;
    }

	if($("#username").val().length < 5 ||
	   $("#username").val().length > 20)
	{
		alert("用户名长度不得小于5位或大于20位！");
		$("#username").focus();
		return false;
	}

	if($("#password").val() == "")
	{
		alert("请输入管理员密码！");
		$("#password").focus();
		return false;
	}

    if(!format.exec($("#password").val()))
    {
        alert("密码非法！请使用[a-zA-Z0-9_]内的字符！！");
        $("#password").focus();
        return false;
    }
	if($("#password").val().length < 5 ||
	   $("#password").val().length > 16)
	{
		alert("密码由5-16个字符组成，区分大小写！");
		$("#password").focus();
		return false;
	}
	
	if($("#repassword").val() == "")
	{
        alert("请输入重复密码！");
       	$("#repassword").focus();
        return false;
    }

	if($("#password").val() != $("#repassword").val())
	{
        alert("两次密码不同！");
        $("#repassword").focus();
        return false;
    }

	if($("#cpwd").val() == "false")
	{
        var dbhost = $("#dbhost").val();
		var dbuser = $("#dbuser").val();
		var dbpwd  = $("#dbpwd").val();
	
		$.ajax({
			url      : '/yzmysql?'+'&dbhost='+dbhost+'&dbuser='+dbuser+'&dbpass='+dbpwd,
			type     : 'get',
			dataType : 'json',
			success  : function(data){
				if(data.status == 200){
					$('#cpwdTxt').html('<span class="correct">可用</span>');
					$('#cpwd').val("true");

					//验证没有问题，提交表单
					document.form.submit();
					return;
				}else{
					$('#cpwdTxt').html('<span class="error">不可用</span>');
					$("#dbpwd").focus();
					$('#cpwd').val("false");
					return false;
				}
			},
            error:function (data) {
                $('#cpwdTxt').html('<span class="error">不可用</span>');
                $("#dbpwd").focus();
                $('#cpwd').val("false");
                return false;
            }

		});
	}else{

		//验证没有问题，提交表单
		document.form.submit();
		return;
	}
}


function CheckPwd()
{
	var dbhost = $("#dbhost").val();
	var dbuser = $("#dbuser").val();
	var dbpwd  = $("#dbpwd").val();

	$.ajax({
		url        : '/yzmysql?'+'&dbhost='+dbhost+'&dbuser='+dbuser+'&dbpass='+dbpwd,
		type       : 'get',
        dataType : 'json',
        success  : function(data){
            if(data.status == 200){
				$('#cpwdTxt').html('<span class="correct">可用</span>');
				$('#cpwd').val("true");
			}else{
				$('#cpwdTxt').html('<span class="error">不可用</span>');
				$('#cpwd').val("false");
			}
		},
        error:function (data) {
            $('#cpwdTxt').html('<span class="error">不可用</span>');
            $('#cpwd').val("false");
            return false;
        }
	});
}