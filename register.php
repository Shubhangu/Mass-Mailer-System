<?php    
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/header.php';
if(empty($_POST)=== false){
$required_fields= array('username','password','password_again','first_name','email');
	foreach ($_POST as $key => $value) {
		if(empty($value)&& in_array($key,$required_fields) ===true){
			$errors[]="Fields marked with an asterisk are required";
			break;
		}
	}
        if(empty($errors) ===true){
            if (user_exists($_POST['username']) ===TRUE) {
                $errors[] = 'Sorry, the username \''.$_POST['username'].'\' is already taken';
           }
            if (preg_match("/\\s/", $_POST['username']) == TRUE) {
                $errors[] ='Your username must not contain any spaces';     
           }
            if (strlen($_POST['password']) <6) {
                $errors[] ='Your password must be atleast 6 characters.';
           } 
            if ($_POST['password']!== $_POST['password_again']) {
                $errors[]='Your passwords do not match.';        
           }
           if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === FALSE){
           $errors[]= "A valid email address is required";
           }
           if(email_exists($_POST['email']) === TRUE){
           $errors[] = 'Sorry, the email \''.$_POST['email'].'\' is already in use';   
           }
    }     
}    
?>
<h1><center>Register</center></h1>
<br /> <center><img src="pics/flat-faces-icons-circle-6-min.png" height="200" width="200" /></center>
<?php
//if the url shows get success
if(isset($_GET['success']) && empty($_GET['success'])){
	echo "You have been registered successfully!, Please check your email to activate your account.";
} else {
if (empty($_POST)===FALSE && empty($errors) ===true) {
    //if the form is submitted and there are no errors then register the user
    $register_data = array(
       'username'   =>$_POST['username'],
       'password'   =>$_POST['password'],
       'first_name' =>$_POST['first_name'],
       'last_name'  =>$_POST['last_name'],
       'email'      =>$_POST['email'],
       'email_code' =>md5($_POST['username'] + microtime())
		);	
                
		register_user($register_data);
            //redirect the user and exit    
		header('Location:register.php?success');
		exit(); 
}
 else if(empty($errors) === FALSE){
    //output the errors    
     echo output_errors($errors);
  }

?>
<form action="" method="post">
	<ul>
		<li>
			Username*:<br>
                        <input type="text" autocomplete="off"name="username" style="width:200px">
		</li>
		<li>
		    Password*:<br>
                    <input type="password" name="password">
		</li>
		<li>
		    Password again*:<br>
			<input type="password" name="password_again">
		</li>
		<li>
			First name*:<br>
                        <input type="text" autocomplete="off" name="first_name">
		</li>
		<li>
			Last name:<br>
                        <input type="text" autocomplete="off" name="last_name">
		</li>
		<li>
			Email*:<br>
                        <input type="text" autocomplete="off" name="email">
		</li>
		<li>
			<input type="submit" name="submit" value="Register">
		</li>
	</ul>
</form>   
 
<?php
}
include 'includes/overall/footer.php'; 
?> 