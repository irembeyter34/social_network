<?php
session_start();
$con = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno()){
    echo "Failed :". mysqli_connect_errno();
}
//Declaring variables to prevent errors
$fname="";
$lname="";
$em="";
$em2="";
$password="";
$password2="";
$date="";
$error_array=[];
if(isset($_POST['register_button'])){

    //Registration form values

    //FirstName
    $fname = strip_tags($_POST['reg_fname']);//remove html tags
    $fname = str_replace(' ','',$fname);//remove spaces
    $fname = ucfirst(strtolower($fname));//uppercase first letter
    $_SESSION['reg_fname'] = $fname;//stores first name into session variable
    //LastName
    $lname = strip_tags($_POST['reg_lname']);//remove html tags
    $lname = str_replace(' ','',$lname);//remove spaces
    $lname = ucfirst(strtolower($lname));//uppercase first letter
    $_SESSION['reg_lname'] = $lname;

    //email
    $em = strip_tags($_POST['reg_email']);//remove html tags
    $em = str_replace(' ','',$em);//remove spaces
    $em = ucfirst(strtolower($em));//uppercase first letter
    $_SESSION['reg_email'] = $em;

    
    //FirstName
    $em2 = strip_tags($_POST['reg_email2']);//remove html tags
    $em2 = str_replace(' ','',$em2);//remove spaces
    $em2 = ucfirst(strtolower($em2));//uppercase first letter
    $_SESSION['reg_email2'] = $em2;

    
    //Password
    $password = strip_tags($_POST['reg_password']);//remove html tags
    $password2 = strip_tags($_POST['reg_password2']);//remove html tags

    $date =date("Y-m-d");//current date

    if($em == $em2){
        if(filter_var($em,FILTER_VALIDATE_EMAIL)){
            $em = filter_var($em,FILTER_VALIDATE_EMAIL);
            //Check if email already exist
            $e_check = mysqli_query($con,"SELECT email FROM users WHERE email = '.$em.'");
            $num_rows = mysqli_num_rows($e_check);
            if($num_rows > 0){
                array_push($error_array,"Email already in use.<br>");
            }
        }else{
            array_push($error_array,"Invalid Format.<br>");
        }

    }else{
        array_push($error_array,"Emails don't match.<br>");
    }

    if(strlen($fname) > 25 || strlen($fname) < 2){
        array_push($error_array,"Your first name must be between 2 and 25 characters.<br>");
    }
    if(strlen($lname) > 25 || strlen($lname) < 2){
        array_push($error_array,"Your last name must be between 2 and 25 characters.<br>");
    }

    if($password != $password2){
        array_push($error_array,"Your password do not match.<br>");
    }else{
        if(preg_match('/[^A-Za-z0-9]/',$password)){
            array_push($error_array,"Your pasword can only contain english characters or numbers.<br>");
        }
    }
    if(strlen($password > 30 || strlen($password) < 5)){
        array_push($error_array,"Your password must be between 5 and 30 characters.<br>");
    }
    if(empty($error_array)){
        $password = md5($password);//encrypt password before sending to database

        //generate username by concatenaining first name and last name
        $username = strtolower($fname."_". $lname);
        $check_username_query = mysqli_query($con,"SELECT username FROM users WHERE username = '.$username.'");
        $i = 0;
        //if username exists add number to username
        while(mysqli_num_rows($check_username_query) != 0){
            $i++;
            $username = $username."_".$i;
            $check_username_query = mysqli_query($con,"SELECT username FROM users WHERE username = '.$username.'");



        }

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head> 
<body>
    <form action="register.php" method="POST">
        <input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])){
            echo $_SESSION['reg_fname'];
        } ?>"  required>
        <br>
        <?php if(in_array("Your first name must be between 2 and 25 characters.<br>",$error_array)) echo "Your first name must be between 2 and 25 characters.<br>" ;?>

        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])){
            echo $_SESSION['reg_lname'];
        } ?>" required>
        <br>
        <?php if(in_array("Your last name must be between 2 and 25 characters.<br>",$error_array)) echo "Your last name must be between 2 and 25 characters.<br>" ;?>

        <input type="email" name="reg_email" placeholder="Email" value="<?php if(isset($_SESSION['reg_email'])){
            echo $_SESSION['reg_email'];
        } ?>" required>
        <br>
        <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if(isset($_SESSION['reg_email2'])){
            echo $_SESSION['reg_email2'];
        } ?>" required>
        <br>
        <?php if(in_array("Email already in use.<br>",$error_array)) echo "Email already in use.<br>";
        else if(in_array("Invalid Format.<br>",$error_array)) echo "Invalid Format.<br>";
        else if(in_array("Emails don't match.<br>",$error_array)) echo "Emails don't match.<br>" ;?>

        <input type="password" name="reg_password" placeholder="Pasword" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Pasword" required>
        <br>
        <?php if(in_array("Your password do not match.<br>",$error_array)) echo "Your password do not match.<br>";
        else if(in_array("Your pasword can only contain english characters or numbers.<br>",$error_array)) echo "Your pasword can only contain english characters or numbers.<br>";
        else if(in_array("Your password must be between 5 and 30 characters.<br>",$error_array)) echo "Your password must be between 5 and 30 characters.<br>" ;?>

        <input type="submit" name="register_button" value="Register">
    </form>
</body>
</html>