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
             )";
}

$control = $_POST["control"];
if ($control == "verify"){
  echo "verify";
} elseif ($control == "create"){
  echo "create";
} else {
  echo "else";
}
echo "<br><br>";

// See the password_hash() example to see where this came from.
$hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMsTpOq';
//$hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';
//$hash = password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

if (password_verify($_POST["password"], $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}


mysqli_close($link)
?>

<form action="index.php" method="post">
userid: <input type="text" name="userid"><br>
password: <input type="password" name="password"><br>
<input type="submit" name="control" value="verify"><br><br>


<form action="index.php" method="post">
userid: <input type="text" name="userid"><br>
password: <input type="password" name="password"><br>
<input type="submit" name="control" value="create">

</body>
</HTML>
