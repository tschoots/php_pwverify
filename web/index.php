<HTML>
<body>

<?php

var_dump($_POST);
echo "<br><br>";

$link = mysqli_connect('mysql', 'root', 'example');
if (!$link){
   echo 'could not connect: ' . mysql_error();
}

// see if db is there otherwise create one
$db_selected = mysqli_select_db( $link, 'my_db');
if (!$db_selected){
   // db not there create
   $sql = 'CREATE DATABASE my_db';
   if (mysqli_query($link, $sql)){
      echo "<br><br>Database my_db created successfully<br><br>";
   } else {
      echo '<br><br>Error creating database: ' . mysqli_error();
   }
}


// now see to it the table exist
$query = 'SELECT ID FROM USERS';
$result = mysqli_query($link, $query);
if (empty($result)){
   $query = "CREATE TABLE USERS (
                ID int(11) AUTO_INCREMENT,
                NAME varchar(255) NOT NULL UNIQUE,
                PASSWORD varchar(255) NOT NULL,
                PRIMARY KEY (ID)
             )";
  $result = mysqli_query($link, $query);
}

// get userid password from db
$username = $_POST['userid'];
$query = "SELECT NAME, PASSWORD FROM USERS WHERE NAME='$username'";
echo $query . "<br><br>";
$result = mysqli_query($link, $query);
$db_user = mysqli_fetch_array($result); 
var_dump($db_user);
echo "<br><br>";


$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$username = $_POST['userid'];
$control = $_POST["control"];
if ($control == "verify"){
  if ( password_verify($_POST['password'], $db_user['PASSWORD']) and (!empty($result))){
    echo "login for $username ok!";
  } else {
    echo "username password error";
  }
} elseif ($control == "create"){
  $query = "INSERT INTO USERS (NAME, PASSWORD) values ('$username', '$hash')";
  $result = mysqli_query($link, $query);
  echo "create<br>";
  echo $query . "<br><br>";
  if ($result){
    echo "user $username created!<br>";
  } else {
    echo "user $username already in use!<br>";
  }
} else {
  echo "else";
}
echo "<br><br>";



mysqli_close($link)
?>



<form action="index.php" method="post">
userid: <input type="text" name="userid"><br>
password: <input type="password" name="password"><br>
<input type="submit" name="control" value="create">
<input type="submit" name="control" value="verify"><br><br>

</body>
</HTML>
