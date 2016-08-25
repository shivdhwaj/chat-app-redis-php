<?php
	session_start();
if(isset($_POST['username']))
{   

	$username=$_POST['username'];
	$username=substr($username, 0, 10);
	$_SESSION['username']=$username;
}
else
{
	$username='';
}

if(isset($_SESSION['username']))
{
$username=$_SESSION['username'];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>REDIS CHAT APP</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.timeago.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery-linkify.min.js" ></script>
<script type="text/javascript">
function htmlEscape(str) {
    return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}

function ajax_data(typeMethod,url,dataString,success){
$.ajax({
type:typeMethod,
url:url,
data :dataString,
dataType:"json",
cache:false,
timeout:20000,
beforeSend :function(data) { },
success:function(data){
success.call(this, data);
},
error:function(data){
alert("Error In Connecting");
}
});
}

function Action(json)
{
$("ol#update").empty();
var b="";
for (var i = 0, len = json.length; i < len; i++) 
{  
var msg=htmlEscape(json[i][2]);
var time=htmlEscape(json[i][1]);
var name=htmlEscape(json[i][0]);           
b='<li><b>'+name+': </b>'+msg+' - <a href="#" class="timeago" title="'+time+'"></a></li>';  
$("ol#update").prepend(b);  

}	
$(".timeago").timeago(); 	
}

// Inserting records into chat table

$(document).ready(function()
{
	

	
	$("#update li").livequery(function() 
	{
		$(this).linkify({
		    target: "_blank"
		}); 
	});
/*	
	$(".timeago").livequery(function() 
	{
	$(this).timeago(); 
	});
	*/
	
var user='<?php echo $username;?>';
// Requesting to Database every 2 seconds
if(user.length>0)
{
var auto_refresh = setInterval(function () 
{ 

var dataString = 'user='+ user;
ajax_data("POST","chat_get.php",dataString, function(data) {
Action(data);
});
}, 2000);
}
   
$('#post').click(function()
{
var boxval = $("#content").val();

var dataString = 'user='+ user + '&content=' + boxval;
if(boxval.length > 0)
{
ajax_data("POST","chat.php",dataString, function(data) {
Action(data);
});
$("#chat").animate({"scrollTop": $('#chat')[0].scrollHeight}, "slow");
$('#content').val('');	
$('#content').focus();
}
return false;
});


});
</script>

<style>


body{ font-family:tahoma,verdana,arial,sans-serif;color:#333; font-size:16px}

*
{
margin:0px;
padding:0px;

}

ol#update
{
list-style:none;
position:absolute;
bottom : 0px;
}
#main
{
margin:0px 10px 0px 10px;
height:100%;
position:absolute;
width:100%;
}
.messageContainer{
	height :90%;
	vertical-align:bottom;
	position:relative;
}
.formContainer{
	height : 10%;
}

#content
{
	width:500px;
	height:46px; border:solid 1px #999999;z-index:90
}
.timeago
{
	font-size:11px;
	color:#666666;
	text-decoration:none;
}
b{color:#86c9ef}
.button {
	z-index:90;
font-weight: bold;
padding: 12px 15px;
background: #3f8abf;
color: #fff !important;
font-size: 14px;
font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
cursor: pointer;
text-decoration: none;
text-shadow: 0 1px 0px rgba(0,0,0,0.15);
border-width: 1px 1px 3px !important;
border-style: solid;
border-color: #326e99;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
display: -moz-inline-stack;
display: inline-block;
vertical-align: middle;
zoom: 1;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
-ms-border-radius: 5px;
-o-border-radius: 5px;
border-radius: 5px;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
-webkit-box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
-moz-box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
}
.button-primary {
background-color: #5fcf80 !important;
border-color: #3ac162 !important;
}
#header
{
	background-color:#f2f2f2;border-bottom:2px #999999 solid; font-size:19px; position:fixed;width:100%;padding:10px;z-index:90;
}
a{color:#006699; text-decoraton:none}
a:hover{color:#006699}
#post{background-color:#ffffff;border:solid 1px #666666}
</style>

</head>

<body>
	
<div id="header">
Redis Chat App (PHP,Redis)
</div>

<?php
echo $username;
if(strlen($username)>0)
{
?>
<div id="main">

<div id='chat' class="messageContainer">

<ol id="update" >


	
</ol>


	
</div>
<div id="flash"></div>
	
<div class="formContainer">

<form method="post" name="form1" action="">
	
<table>
		
<tr>
			
<td valign="top">

<input type="text" name="content" id="content" placeholder="Type Here..." autocomplete="off" maxlength="250"/></td>

<td valign="top">
<input type="submit" value="Post" id="post" class="post button button-primary"/></td>

</tr></table>
</form>
</div>


<div>
<?php } else { ?>
	
<div style="padding-top:100px">
	<form method="post" name="form12" action="">
<b>Username: </b><input type="text" name="username" id="username" maxlenght="10"/>	
<input type="submit" value="Submit" id="userpost" />
</form>
</div>	
<?php }?>	

</body>
</html>