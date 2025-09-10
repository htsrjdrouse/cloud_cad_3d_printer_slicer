<? session_start(); ?>
<? include('jscadlib.php') ?>
<? if(isset($_SESSION['opensaveproject'])){ ?>

<?
if (isset($_SESSION['jscadfilename']) and (!isset($_SESSION['jscadcontents']))){
  $f = fopen("uploads/".$_SESSION['jscadfilename'],"r");
  $_SESSION['jscadcontents'] = fread($f,filesize("uploads/".$_SESSION['jscadfilename']));
}
?>





<? } else { ?>
<? header("Location: redirect.php");?>
<? } ?>


