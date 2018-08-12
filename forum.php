 <?php 
include 'core/init.php';
protect_page();
include 'includes/overall/header.php';?>
 <h1>Email All Users</h1>
 <?php
 if(isset($_GET['success']) === true){
?>
  <p>Email has been sent.</p>
<?php
 }else{
 if (empty($_POST) === false) {
     if (empty($_POST['subject']) ===true) {
    	$errors[]='Subject is required.';
    }
    if (empty($_POST['body']) ===true) {
    	$errors[]='Body is required.';
    }
    if (empty($errors) === false) {
    	echo output_errors($errors);
    }else{
    	mail_users($_POST['subject'], $_POST['body']);
    	header('Location: forum.php?success');
    	exit();
    }
}    
 ?>
 <form action="" method="post">
     <ul>
     	<li>
     		Subject*:<br>
     		<input type="text" name="subject" autocomplete="off">
     	</li>
     	<li>
     		Body*:<br>
     		<textarea name="body" style="width: 400px; height: 150px;" autocomplete="off"></textarea>
     	</li>
     	<li>
     		<input type="submit" value="Send">
     	</li>
     </ul>
</form>

 <?php
}
include 'includes/overall/footer.php'; ?> 