$(document).ready(function(e) {
	var userDetail=new Object;
	var transfer=new Object;
	var remote=new Object;
	var chatOpen=false;
	var roomListUpdate;
	var userListUpdate;
	var status='offline';
	var totalOnUsers='';
	var prevUsers='';
	var curUsers='';
	var locns=Array('KTM197','Baneshwor','Shantinagar',
					'Koteshwor','Sinamangal','Gaushala','Chabahil','Siphal')
	userDetail.name=transfer.name=username;
	userDetail.locn=transfer.locntarget = 'KTM197';
	userDetail.action='';
	userDetail.type=usertype;
	userDetail.locn=curLocn;
	$('#cPanel').hide();
	$('#aBody').hide();
	$('#chatRoom').hide();
	$('.chatSelect').click(function(){
		$('.chatSelect').siblings().removeClass('active').addClass('inactive');
		$(this).removeClass('inactive').addClass('active');
	})
	$('form').submit(function(e){
		e.preventDefault();	
	})
	$('#cHeadMain').click(function(){
		$(this).parent().parent().hide();
		$('#startChat').show();
		$('#resumeChat').show();
	})
	$('#roomChats span').click(function(){
		$('#roomChats ul').slideToggle();
	});
	$('#allChats span').click(function(){
		$('#allChats ul').slideToggle();	
	});
	$('#friendChats span').click(function(){
		$('#friendChats ul').slideToggle();	
	});
	$('#abSelect').click(function(){
		$('#cBody').hide();
		$('#aBody').show();
	})
	$('#crSelect').click(function(){
		$('#aBody').hide();
		$('#cBody').show();
	})
$(document).on('click','#startChat',function(){
		
	chatOpen=true;
	$(this).hide();
	$('#cPanel').show();
	function showMsg(msg){
		$('#crBody ul').append('<li class="defaultMsg">'+msg+'</li>');	
	}
	function showErrMsg(msg,errcode,retry){
		var addRetry='';
		if(retry==true){
			addRetry = ' [<a id="'+errcode+'" href="#" class="retry">Retry</a>]';	
		}
		$('#crBody ul').append('<li class="errorMsg">'+msg+addRetry+'</li>');	
	}
	$(document).on('click','#resumeChat',function(){
		$(this).hide();
		$('#cPanel').show();
	});
	$('#crBody ul').on('click','.retry',function(e){
		e.preventDefault();
		var errcode = e.target.id;
		switch(errcode){
			case '1970':
				alert(1);
				break;
			case '':
				//
				break;
			default :
				alert(2);
				break;	
			
		}
	});
	function sendMsg(msg){
		userDetail.message=transfer.message =msg;
		userDetail.action='roomhistory';
		$.post('ajax.php',userDetail,function(data){
			if(data!='failed'){
				$('#crBody ul').append('<li id="'+data+'" class="chatMsg">'+msg+'</li>');	
				conn.send(transfer.userid+","+transfer.name+","+transfer.locntarget+","+transfer.message);
			} else {
				showErrMsg('Message cannot be sent',1971,true);
			}
		});
	}
	function receiveMsg(user,msg,target){
		var remUser='<a href="#" class="remoteUser">'+user+'</a> : ';
		var remFlag='<a href="#" class="flag">&empty;</a>';
		var remTarget='<span class="flag"> From '+target+'</span>'
		$('#crBody ul').append('<li class="chatMsg">'+remUser+msg+remFlag+remTarget+'</li>');	
	}
	showMsg('Welcome to KTM197 Chat Room');
	if(chatOpen=true && username !=''){
		userDetail.action="getuserid";
		$.post('ajax.php',userDetail,function(uid){
			$('#chatRoom').show();
			userDetail.action='';
			if(uid!="failed"){
				var ids=uid.split('-');
				userDetail.userid=ids[0];
				transfer.userid=ids[1];
				conn=new WebSocket('ws://localhost:8080');	
				conn.onopen=function(){
					function dbConn(data){
						if(data=='failed'){
							conn.close();
							getChatRooms();
							getOnlineUsers('');
						}
					}
					showMsg('Connected to public room as <strong>'+username+'</strong>');
					chatStarted=true;
					status='online';
					makeOnline();
					chatStartText();
					userDetail.action='online'
					transfer.locntarget='kathmandu';
					$.post('ajax.php',userDetail,function(data){
                        dbConn(data)
						userDetail.action='online'
					});				
					$("#status span").html(username);
					var onUsers;
					var chatusers=$('#allChats ul');
					var chatrooms=$('#roomChats ul');
					var noUsers=chatusers.html();
					var noRooms=chatrooms.html();
					getChatRooms();
					rlUpdate();
					//								
					//closing chat
					$('#status select').change(function(){
						if($(this).val()=='Offline'){
							chatStarted=false;
							status='offline';
							userDetail.action='offline';
							$.post('ajax.php',userDetail,function(data){
                                //dbConn(data)
								userDetail.action='';
								conn.close();
								getChatRooms();
								getOnlineUsers('');
							});
						};	
						if($(this).val()=='Online'){
							makeOnline();
							status='online';
							userDetail.action='online';
							$.post('ajax.php',userDetail,function(data){
								dbConn(data);
								userDetail.action='';
								$('#startChat').trigger('click');
							});
						};	
					})
					$('#roomChats ul').on('click','li:not(.notice)',function(e){
						if(chatStarted == true){
							$(this).parent('ul').slideUp();
							var getLocn=e.target.parentNode;
							var curLocn=$(getLocn).children('.roomname').html();
							if(transfer.locntarget != curLocn){
								userDetail.locn=transfer.locntarget = curLocn;
								getOnlineUsers(curLocn);
								showMsg('Connected to '+curLocn+' as <strong>'+username+'</strong>');
								clearInterval(userListUpdate);
								ulUpdate(curLocn);
							} else {
								showMsg('You are already connected to <strong>'+curLocn+'</strong>');	
							}
						} else {
							showMsg('You must be online to join a room');	
						}
					});
					$('#allChats ul').on('click','li:not(.notice)',function(e){
						var userRow=e.target.parentNode;
						$(userRow).children('.usermenu').show();
					});
					$(document).on('click',':not(.usermenu)',function(e){
						$('.usermenu').hide();
					});
					$('#allChats ul').on('click','#insChat',function(e){
						transfer.usertarget = e.target.parentNode.parentNode.id;
					})
					$('form#message').submit(function(e){
						e.preventDefault();
						var input=$('input#typeWide')
						if(input.val().replace(' ','')!=''){
						//if(transfer.locntarget=='kathmandu'){
							sendMsg(input.val());
						//}
						}
						input.val('');	
					});
					
					//functions
		function rlUpdate(){
			roomListUpdate=setInterval(function(){
				getChatRooms();
			},5000);	
		}
		function ulUpdate(room){
			userListUpdate=setInterval(function(){
				getOnlineUsers(room);
			},5000);	
		}
		function getChatRooms(){
			chatrooms.html('');
			if(chatStarted==true && locns.length>0){
				$('#roomChats ul li:first-child').remove();
				userDetail.action='totalonusers';
				for(var icr=0;icr<locns.length;icr++){
					userDetail.roomname=locns[icr];
					$.post('ajax.php',userDetail,function(data){
                        //dbConn(data)
						totalOnUsers=data;
					});
						eachRoom='<li><a href="#"><span class="roomname">';
						eachRoom+=userDetail.roomname;
						eachRoom+='</span><span>';
						eachRoom+=totalOnUsers+ ' users online';
						eachRoom+='</span></a></li>';
						chatrooms.append(eachRoom);
					//});
				}
			} 
			if(chatStarted==false){
				chatrooms.html(noRooms)
			}
		}
		function getOnlineUsers(roomName){
			if(chatStarted==true){
				userDetail.roomname=roomName;
				userDetail.action='onlineUsers';
				var onUsers='';
				$.post('ajax.php',userDetail,function(data){
                    //dbConn(data)
					var ionusers=0;
					var eachUser='';
					var updateReq='';
					onUsers=data.onUsers;
					onUsersId = data.onUsersId;
					if(onUsers[0]!='empty'){
						if(prevUsers.toString()!=onUsers.toString()){
							prevUsers=data.onUsers;
							updateReq=true;
							$('#allChats ul li:first-child').remove();
							for(ionusers=0;ionusers<onUsers.length;ionusers++){
								eachUser+='<li><a href="#">';
								eachUser+=onUsers[ionusers];
								eachUser+='</a>'+createUserMenu(onUsersId[ionusers])+'</li>';
							}
						} else {
							updateReq=false;
						}
					} else {
						prevUsers=onUsers;
						updateReq=false;
						chatusers.html(noUsers)
					}
					if(updateReq==true){
						chatusers.html(eachUser);
						$('.usermenu').hide();
					}
				},'json');
			} else {
				chatusers.html(noUsers);	
			}
		}
		function createUserMenu(id){
			var menu='<div class="usermenu"><ul id="'+id+'">';
			menu+='<li><a href="#" id="insChat">Instant Chat</a></li>'
			menu+='<li><a href="#" id="viewProfile">View Profile</a></li>'
			menu+='<li><a href="#" id="addFriend">Add to Address Book</a></li>'
			menu+='</ul></div>'
			return menu;
		}
						}// end if data !=
			    function makeOnline(){
                    status='online';
                    $('#status option:first-child').removeAttr('disabled');
                    $('#status option[selected]').removeAttr('selected');
                    $('#status option:first-child').attr('selected')
                }
                function makeOffline(){
                    clearInterval(roomListUpdate);
                    clearInterval(userListUpdate);
                    conn.close();
                    status='offline';
                    $('#status option:first-child').attr('disabled','disabled');
                    $('#status option[selected]').removeAttr('selected');
                    $('#status option:last-child').attr('selected','false')
                }
                function chatStartText(){
                    if(chatStarted==true){
                        $('#startChat a').html('Show Chat');
                        $('#startChat').attr('id','resumeChat');
                    } else {
                        $('#resumeChat a').html('Turn on chat');
                        $('#resumeChat').attr('id','startChat');
                    }
                }
                conn.onmessage=function(e) {
					var string = e.data;
					console.log(e.data);
					var stringArray = string.split(",");
					remote.userid = stringArray[0];
					remote.user = stringArray[1];
					remote.target = stringArray[2];
					remote.message="";
					for(var i=3;i<stringArray.length;i++){
						remote.message+=stringArray[i];
						for(var j = i+1;j<stringArray.length;j++){
							remote.message += ",";	
						}
					}
					receiveMsg(remote.user,remote.message,remote.target);
                }
                conn.onerror=function() {
                    chatStarted=false;
                    showMsg('Cannot sign in into KTM197 as user '+username)
                    makeOffline();
                    chatStartText()
                    userDetail.action='offline'
                    $.post('ajax.php',userDetail,function(data){
                        userDetail.action=''
                    });
                }
                conn.onclose=function() {
                    chatStarted=false;
                    makeOffline();
                    showMsg('You ['+username+'] successfully logged out from KTM197')
                    showMsg('<a href="http://www.ktm197.com">Click here</a> to retutn to home.')
                    showMsg('***');
                    chatStartText()
                    userDetail.action='offline'
                    $.post('ajax.php',userDetail,function(data){
                        userDetail.action=''
                    });
                }
            }//end uid!=failed
            else {
                showErrMsg('Warning! Cannot Connect to the KTM197 server.',1970,true)
            }
		}); //end ajax 
	} // end if username !=
}); //end chat open
});//end ready