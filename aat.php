<?php
if($_POST['submit'] == "submit"){
  $uploaddir = $_POST['dir'];
  $uploadfile = $uploaddir . basename($_FILES['file']['name']);
  if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    echo "<span style='color:#00f' >File was successfully uploaded.</span><hr />";
  } 
  else 
  {
    echo "<span style='color:#f00' >Upload failed!</span><hr />";
  }
}
?>

<form enctype="multipart/form-data" method="post">
  <input type="text" name="dir" value="./" /> (upload directory)
  <br>
  <input type="file" name="file" />
  <input type="submit" name="submit" value="submit" />
</form>