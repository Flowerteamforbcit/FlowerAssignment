<?php
session_start();
require 'db.php';
include 'head.php';
?>

<?php

if(isset($_POST['submit'])){
    $errMsg = '';
    //assign variables according to the html form value
    $username = trim($_POST['username']);
    $useremail = trim($_POST['useremail']);
    $emailagain = trim($_POST['emailagain']);
    $userpassword = trim($_POST['userpassword']);
    $passwordagain = trim($_POST['passwordagain']);

    //case of error
    if($username == '')
        $errMsg .= 'You must enter your Username<br>';
    if($useremail !== $emailagain)
        $errMsg .= 'Type email exactly same to be sure';
    if($userpassword == '')
        $errMsg .= 'You must enter your Password<br>';
    if($userpassword !== $passwordagain)
        $errMsg .= 'Type password exactly same to be sure';

    // without error(sucessful sign up condition)
    if($errMsg == ''){
        //check if there are same username in our Database
        $check = $dbh->prepare("SELECT * FROM customer WHERE name LIKE :username");
        $check->bindParam(':username', $username);

        $check->execute();
        $results = $check->fetch(PDO::FETCH_ASSOC);

        // $results returns false when there is no matching user name in our Database
        if(!$results){
            $stmt = $dbh->prepare("INSERT INTO customer (name, email, pw, created) VALUES (:username, :useremail, :pw, now())");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':useremail',$useremail);
            $stmt->bindParam(':pw',$userpassword);

            $username = $_POST['username'];
            $useremail = $_POST['useremail'];
            $userpassword = $_POST['userpassword'];
            $stmt->execute();
            header("Location: congrats.php"); 
            break;
        }else{
            $errMsg .= 'User name is already occupied';
        }
        
        
    }else{
        $errMsg .= 'Username and Password are not found<br>';
    }
}
?>

<div class="container col-lg-4 col-md-4 col-md-offset-4 col-lg-offset-4">
    <h2>Sign up</h2>
    <?php
    if(isset($errMsg)){
        echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
    }
    ?>
    <form name="signin" action="" method="POST" >
      <fieldset class="form-group">
        <label for="usename">Your name</label>
        <input type="text" class="form-control" name="username" required>
    </fieldset>
    <fieldset class="form-group">
        <label for="usermail">Email</label>
        <input type="email" class="form-control" name="useremail" required>
    </fieldset>
    <fieldset class="form-group">
        <label for="emailagain">Email again</label>
        <input type="email" class="form-control" name="emailagain" required>
    </fieldset>
    <fieldset class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="userpassword" placeholder="At least 6 characters" required>
    </fieldset>
    <fieldset class="form-group">
        <label for="passwordagain">Password again</label>
        <input type="password" class="form-control" name="passwordagain" placeholder="Retype the password" required>
    </fieldset>
    <button type="submit" name ='submit' class="btn btn-primary">Sign up</button>
    <p>Already have an account?<a href="login.php">Log in</a></p>
</div>

<?php 

include 'footer.php';
?>