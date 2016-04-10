<?php 
@session_start();
$_SESSION['username'] = 'santosh';
$_SESSION['usertype'] = 'page_owner';
$_SESSION['location'] = 'baneshwor';
$_SESSION['userid']='';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chat UI</title>
<script type="text/javascript" src="jquery.js"></script>
<style>
@import url('newui.css');
</style>
</head>
<body>
<header>
	
</header>
<section id="chatRoom">
	<div id="crHead">
    	<span>KTM197 CHAT</span><div id="crClose"><a href="#">&times;</a></div>
    </div>
    <div id="crBody">
    	<ul></ul>
    </div>
    <div id="crType">
    	<form method="post" action="#" id="message">
            <input id="typeWide" type="text" placeholder="Type here..." name="typeWide" autocomplete="off" />
            <input type="submit" value="" name="submit" hidden  />
        </form>
    </div>
    <div id="crBase">
    
    </div>
</section>
</section>
<div id="startChat"><a href="#" class="block">Turn on Chat</a></div>
<div id="cPanel">
	<div id="cHead">
    	<div id="cHeadMain"><a href="#" class="block">Chat</a></div>
    	<div id="status"><span></span>
        	<select>
            	<option disabled>Online</option>
            	<option>Busy</option>
            	<option selected>Offline</option>
            </select>
        </div>
    </div>
    <div class="cBodyMain" id="cBody">
    	<div class="infoBlock" id="roomChats">
        	<span><a href="#" class="block">Join Chatrooms</a></span>
            <ul><li class="notice">No chatrooms available now.</li></ul>
         </div>
    	<div class="infoBlock" id="allChats">
            <span><a href="#" class="block">Availible Chats</a></span>
            <ul><li class="notice">No chats available.</li></ul>
        </div>
    </div>
    <div class="cBodyMain" id="aBody">
    	<div class="infoBlock" id="friendChats">
            <span><a href="#" class="block">Address Book</a></span>
            <ul><li class="notice">Your address book is empty.</li></ul>
        </div>    
    </div>
    <div id="cBase">
    	<div id="crSelect" class="chatSelect active"><a href="#" class="block">Chat Rooms</a></div>
    	<div id="abSelect" class="chatSelect inactive"><a href="#" class="block">Address Book</a></div>
    </div>
</div>
<!--div class="chatActive"></div-->
<script>
	var username = "<?php echo isset($_SESSION['username'])?$_SESSION['username']:NULL?>"
	var usertype = "<?php echo isset($_SESSION['usertype'])?$_SESSION['usertype']:NULL?>"
	var curLocn = "<?php echo isset($_SESSION['location'])?$_SESSION['location']:NULL?>"
	var chatStarted = false;
</script>
<script type="text/javascript" src="chat.js"></script>
</body>
</html>