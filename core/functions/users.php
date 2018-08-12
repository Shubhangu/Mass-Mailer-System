<?php
function mail_users($subject,$body){
  require 'core/database/connect.php';
  $query = mysqli_query($con, "SELECT `email`, `first_name` FROM `users`");
  while(($row = mysqli_fetch_assoc($query)) !== false){
    $body = $body;
    email($row['email'],$subject,$body);
  }
}
function activate($email, $email_code){
    require 'core/database/connect.php';
    $email      = mysqli_real_escape_string($con,$email);
    $email_code = mysqli_real_escape_string($con,$email_code);
    $query= mysqli_query($con,"SELECT `user_id` FROM `users` WHERE `email`='$email' AND `email_code` ='$email_code' AND `active` =0");
    $row= mysqli_fetch_assoc($query);
    mysqli_query($con,"UPDATE `users` SET `active` =1 WHERE `email` ='$email'");
    return(($row["user_id"]==0)?TRUE:FALSE);
    
}  
function change_password($user_id,$password){
    require 'core/database/connect.php'; 
    $user_id = (int)$user_id;
    $password = md5($password);    
    mysqli_query($con,"UPDATE `users` SET `password`='$password' WHERE `user_id`=$user_id");
}  
function register_user($register_data){
    require 'core/database/connect.php';
    //array_walk($register_data,'array_sanitize');
    $register_data['password'] = md5($register_data['password']);
    $data ='\''.implode('\',\'',$register_data).'\'';
    $fields ='`'.implode('`,`',array_keys($register_data)).'`';
    mysqli_query($con,"INSERT INTO `users` ($fields) VALUES($data)");
    email($register_data['email'],'Activate your account',"Hello ". $register_data['first_name'].",\n\nYou need to activate your account, so use the link below: \n\nhttp://localhost/lr/activate.php?email=". $register_data['email']."&email_code=".$register_data['email_code']." \n\n-EmailSystem.");
}   
function user_count(){  
	require 'core/database/connect.php';
	$row= mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(`user_id`) FROM `users` WHERE `active`=1")); 
    return $row;
}
function user_data($user_id ){
	require 'core/database/connect.php';
        $data = array();
        $user_id=(int)$user_id;
	$func_num_args=func_num_args();
	$func_get_args= func_get_args();
        if ($func_get_args >1){
            unset($func_get_args[0]);
            $fields='`'.implode('`,`',$func_get_args).'`';
            $result=mysqli_query($con,"SELECT $fields FROM `users` WHERE `user_id` = $user_id"); 
            $data=mysqli_fetch_assoc($result);
            return $data;
        }
}	
function logged_in(){
	require 'core/database/connect.php';
	return(isset($_SESSION['user_id']))?true:false;
}
function user_exists($username){
	require 'core/database/connect.php';
	$username = sanitize($username); 
	$query= mysqli_query($con,"SELECT `user_id` FROM `users` WHERE `username`='$username'");
        $row= mysqli_fetch_assoc($query);
	if($row["user_id"]==0) 
	 return false;
	else return true;
}
function email_exists($email){
	require 'core/database/connect.php';
	$email = sanitize($email); 
	$query= mysqli_query($con,"SELECT `user_id` FROM `users` WHERE `email`='$email'");
        $row= mysqli_fetch_assoc($query);
	if($row["user_id"]==0) 
	 return false;
	else return true;
} 
function user_active($username){
	 require 'core/database/connect.php';
	$username =sanitize($username);
	$query= mysqli_query($con,"SELECT `user_id` FROM `users` WHERE `username`='$username' AND `active` =1");
	$row= mysqli_fetch_assoc($query);
    return(($row["user_id"]==0)&&($row["active"]==0)?false:true);
}
function user_id_from_username($username){
	require 'core/database/connect.php';
	$username=sanitize($username);
	$query= mysqli_query($con,"SELECT `user_id` FROM `users` WHERE `username`='$username'");
	$row= mysqli_fetch_assoc($query);
    return($row['user_id']);
}
function login($username,$password){
    require 'core/database/connect.php';
    $user_id=user_id_from_username($username);
    $username=sanitize($username);
    $password=md5($password);
    $query=mysqli_query($con,"SELECT `user_id` FROM `users` WHERE `username`='$username' AND `password`='$password'");
    $row= mysqli_fetch_assoc($query);
    if($row["user_id"]==0)
    	return false;
    else return $row['user_id'];
 }
?>