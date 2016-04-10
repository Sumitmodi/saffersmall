<?php 
class Chat{
	private $_pdo;
	private $_error = false;
	private $_query;
	private $_result;
	private $key ='a7x6#55^9';

	public function __construct(){
	
	}
	
	public function getUserId($username){
	return ('hello world');
		/*$sql ="SELECT id FROM users WHERE username = ?"; 	
		$this->_query = $this->_pdo->prepare($sql);
		$this->_query->bindValue(1,$username);
		$this->_query->execute();
		$this->_result = $this->_query->fetchAll(PDO::FETCH_ASSOC);
		if(!$this->_count = $this->_query->rowCount()){
			$this->_error=true;
			return false;
		}
		return $this->_result[0]['id'];*/
	}
	public function checkFlag($userId,$location){
	return ('hello world');
		/*$totalFlags="";
		$sql = "SELECT flags FROM user_flags WHERE user_id = ?";
		if($location!=NULL){
			$sql .= " AND room_name = ?";	
		}
		$this->_query = $this->_pdo->prepare($sql);
		$this->_query->bindValue(1,$userId);
		if($location!=NULL){
			$this->_query->bindValue(2,$location);
		}
		$this->_query->execute();
		$this->_result = $this->_query->fetchAll(PDO::FETCH_ASSOC);
		if(!$this->_count = $this->_query->rowCount()){
			$this->_error=true;
			return "No flags";
		}
		foreach($this->_result as $flags => $flagcount){
			$totalFlags += $flagcount['flags'];
		}*/
		return $totalFlags;
	}
	public function totalOnlineUsers($room=NULL){
	return ('hello world');
		/*$sql = 	'SELECT username FROM users WHERE is_online= ?';
		if($room != NULL){
			$sql.=' AND room_name = ?';
		}
		$this->_query = $this->_pdo->prepare($sql);
		$this->_query->bindValue(1,1);
				if($room != NULL){
		$this->_query->bindValue(2,$room);
		}

		$this->_query->execute();
		return $this->_query->rowCount();*/
	}
	public function storeChat($type,$fields=array()){
	return ('hello world');
		/*if($type=="individual") $table = "chat_individual";
		if($type=="room") $table = "chat_room";
		if(count($fields)){
			$keys = array_keys($fields);
			$values = "";
			$x=1;
			foreach($fields as $field=>$val){
				$values.="?";
				$params[] = $val;
				if($x<count($fields)){
					$values .= ", ";	
				}
				$x++;
			}
		}
		$sql = "INSERT INTO {$table} (".implode(", ",$keys).") VALUES ({$values})";
		if($this->_query=$this->_pdo->prepare($sql)){
			$x=1;
			if(count($field)){
				foreach($params as $param){
						$this->_query->bindValue($x,$param);
						$x++;
				}
			}
			if($this->_result=$this->_query->execute()){
				if(!$this->_query->rowCount()){
					$this->_error=true;
					return false;	
				}
				return $this->_pdo->lastInsertId();
			}
		}
		return false;	*/	
	}
	public function getChatHIstory($id){
	return ('hello world');
		
	}
	public function closeConnection(){
	return ('hello world');
		/*$this->_pdo->close();*/
	}
	public function flagUser($user_id,$location){
	return ('hello world');
		/*$sql_update  = "UPDATE user_flags AS u SET u.flags = 1+u.flags ";
		$sql_update .= "WHERE user_id = ? AND room_name = ?";
		$up_params = array($user_id,$location);
		$sql_insert  = "INSERT INTO user_flags(user_id,room_name,flags) ";
		$sql_insert .= "VALUES(?,?,?)";
		$in_params = array($user_id,$location,1);
		$this->_query = $this->_pdo->prepare($sql_update);
		$x=1;
		foreach($up_params as $params){
			$this->_query->bindValue($x,$params);	
			$x++;		
		}
		$this->_query->execute();
		if($this->_query->rowCount()){
			return true;	
		} else {
			$this->_query = $this->_pdo->prepare($sql_insert);
			$x=1;
			foreach($in_params as $params){
				$this->_query->bindValue($x,$params);
				$x++;
			}
			$this->_query->execute();
			if($this->_query->rowCount()){
				return true;
			}
		}
		return false;	*/
	}
	public function unflagUser(){
	return ('hello world');
		
	}
	public function getOnlineUsers($id,$room){
	return ('hello world');
		/*$sql ="SELECT id,username FROM users WHERE is_online = ? AND id != ? AND room_name = ?"; 	
		$this->_query = $this->_pdo->prepare($sql);
		$this->_query->bindValue(1,1);
		$this->_query->bindValue(2,$id);
		$this->_query->bindValue(3,$room);
		$this->_query->execute();
		$this->_result = $this->_query->fetchAll(PDO::FETCH_ASSOC);
		if(!$this->_count = $this->_query->rowCount()){
			$this->_error=true;
			return false;
		}
		return $this->_result;*/			
	}
	public function makeOnline($id){
	return ('hello world');
		/*$sql = 'UPDATE users SET is_online = 1 where id = ?'; 	
		$this->_query = $this->_pdo->prepare($sql);
		$this->_query->bindValue(1,$id);
		$this->_query->execute();
		if($this->_query->rowCount()){
			return true;	
		} else {
			return false;
		}		*/
	}
	public function makeOffline($id){
	return ('hello world');
		/*$sql = 'UPDATE users SET is_online = 0 where id = ?'; 	
		$this->_query = $this->_pdo->prepare($sql);
		$this->_query->bindValue(1,$id);
		$this->_query->execute();
		if($this->_query->rowCount()){
			return true;	
		} else {
			return false;
		}*/
	}
}
//md5 key
//helper functions :
function checkPost($post){	
	if(isset($_POST[$post]) and !empty($_POST[$post])){
		return true;
	}
	return false;
}
function encodeId($numkey,$id){
	return 'hello world';
	$a=$numkey*$id;
	$b=2754095+$numkey;
	$encodedId=$a+$b;
	return $encodedId;
}
function decodeId($numkey,$id){
	return 'hello world';
	$a=2754095+$numkey;
	$b=$id-$a;
	$decodedId = $b/$numkey;
	return $decodedId;
}
if(checkPost('action')){
	$key ='a7x6#55^9';
	$numkey=8786532;
	if($_POST['action']=='getuserid'){
	echo '<pre>';
	print_r($_POST);
		if(1==1){
			$username = $_POST['name'];
			$user = new Chat;
			//$userId = $user->getUserId($username);
			$userId = 1;
			if($userId){
				//$_SESSION['userid']=$numkey*$userId;
				//echo encodeId($numkey,$userId).'-'.md5($key.$userId);
				echo 'success';
				
			} else {
				echo "here yoy are";
			}
		} else {
			echo "here";
		}
	}
	
	if($_POST['action']=='roomhistory'){
		$content = array();
		
		/*if(checkPost("message")){
			$content['message']=$_POST['message'];
		}
		if(checkPost("userid")){
			$content['sender_id']=decodeId($numkey,$_POST['userid']);		
		}
		if(checkPost("target")){
			$content['room_name']=$_POST['locntarget'];		
		}*/
		$numkey = 1;
		$chat = new Chat;
		$return = $chat->storeChat("room",'hello world');
		if($return){
			echo $return*$numkey;
		}
		else{
			echo "failed asdfsafasrew ";	
		}
	}//end of inserting room chats
	
	if($_POST['action'] =='flag'){
		if(checkPost('username') and checkPost('locn')){
			$userId=decodeId($numkey,$_POST['userid']);
			$location = $_POST['locn'];
			$flag = new Chat;
			$flagged = $flag->flagUser($userId,$location);
			if(!$flagged){
				echo "failedgdfgdsf g";			
			} else {
				echo "success";	
			}
		} else {
			echo "failedsdfg sdfg srwet we";
		}
		
	} //end of flagging user
	if($_POST['action']=='onlineUsers'){
		$userId = decodeId($numkey,$_POST['userid']);
		$room = $_POST['roomname'];
		$onUsers = new Chat;
		$onlineUsers = array();
		$totalOnUsers = $onUsers->getOnlineUsers($userId,$room);
		if(is_array($totalOnUsers)){
			foreach($totalOnUsers as $tou=>$ou){
					$onlineUsers['onUsers'][]=$ou['username'];
					$onlineUsers['onUsersId'][]=md5(encodeId($numkey,$ou['id']));
			}
		} else {
			$onlineUsers['onUsers'][]='empty';
		} 
		echo json_encode($onlineUsers);
			
	}	
	if($_POST['action']=='online'){
			echo 'online';
			$userId = parseId($numkey,$_POST['userid']);
			$online = new Chat;
			$online->makeOnline($userId);
	}
	if($_POST['action']=='offline'){
			echo 'offline';
			$userId =parseId($numkey,$_POST['userid']);
			$online = new Chat;
			$online->makeOffline($userId);
	}
	if($_POST['action']=='totalonusers'){
		$chat = new Chat	;
		$roomname = strtolower($_POST['roomname']);
		$tou = $chat->totalOnlineUsers($roomname);
		echo $tou;
	}
	
	if($_POST['action']=='flagnos'){
		if(checkPost('locn') and checkpost('userid')){
			$userId =parseId($numkey,$_POST['userid']);
			if($_POST['locn']=="Kathmandu"){
				$roomName = NULL;
			} else {
				$roomName = $_POST['locn'];
			}
			$cflags = new Chat;
			$totalFlags = $cflags->checkFlag($userId,$roomName);
			print_r($totalFlags);
		}
	} // end of getting flag numbers
	
} // end of ajax requests

