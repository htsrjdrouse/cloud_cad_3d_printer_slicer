<? session_start(); ?>
<br>
<? if(isset($_SESSION['opensaveproject'])){ ?>
<?

/*
$filepath = "uploads/".$_SESSION['jscadfilename'];
if (!file_exists($filepath)){ $_SESSION['jscadfilename'] = "iverntech_slider_xshuttle_connect.jscad"; }
*/
if (isset($_SESSION['jscadfilename']) and (!isset($_SESSION['jscadcontents']))){
  $f = fopen($_SESSION['directory']."/".$_SESSION['jscadfilename'],"r");
  $_SESSION['jscadcontents'] = fread($f,filesize($_SESSION['directory']."/".$_SESSION['jscadfilename']));
}
?>
<? include('jscadlib.php') ?>
<? if (!isset($_SESSION['views'])){$_SESSION['views'] = 1; }?>
<? if(isset($_POST['selectSTL'])){
$_SESSION['views'] = 1; 
} ?>
<? if(isset($_POST['selecteditor'])){
$_SESSION['views'] = 0; 
} ?>
<? if(isset($_POST['selectslice'])){
$_SESSION['views'] = 2; 
} ?>
<? if(isset($_POST['selectOpenSCAD'])){
 $_SESSION['views'] = 3; 
 $_SESSION['jscadfilename'] = "imagingblock_lid.jscad";
} ?>

<? include('uploadfile.php'); ?>


<? //header("Refresh:0");?>
<!DOCTYPE html>
<html lang="en">
<head>
<? //include('functionslib.php');?>
<? error_reporting(E_ALL & ~E_NOTICE);?>
<title>HTS LabBot</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/bootstrap.min.css">
  <script src="/jquery.min.js"></script>
  <script src="/bootstrap.min.js"></script>

</head>

<div class="row">
 <div class="col-md-5"><br><br>
 <ul>
  <h3>CAD development tool for 3-D printing</h3>
 </ul>

</div>
 <div class="col-md-6"><br><br>
 </div>
</div>
<div class="row">
 <div class="col-md-4">
<ul>
<br> 


<? include('example.display.project.php'); ?>




<? if($_SESSION['views'] == 2) { ?>
<form action=example.objects.json.php method=post>
  <button type="submit" name="selectSTL" class="btn-sm btn-primary">Manage STL</button> 
  <!--<button type="submit" name="selectOpenSCAD" class="btn-sm btn-success">Manage OpenSCAD</button> -->
  <button type="submit" name="selecteditor" class="btn-sm btn-warning">Code editor</button> 
</form><br>
<? include('slicer_management.php');  ?>
<? }?>

<? if($_SESSION['views'] == 3) { ?>
<!--
<form action=example.objects.json.php method=post>
  <button type="submit" name="selectSTL" class="btn-sm btn-primary">Manage STL</button> 
</form><br>
-->
<? include('example.display.openscad_management.php'); ?>
<? }?>



</div>


<div class="col-md-8">
<!-- 3d viewer -->
 <!--<div class="col-md-1"></div> -->
<? include('example.3dviewer.caller.inc.php'); ?>

</div>

<div class="col-md-1">
</div>
</div> <!--end  row-->

<!-- code viewer -->
<div class="row">
 <div class="col-md-3">
 <ul>
<? if (isset($_SESSION['scadview']) and ($_SESSION['scadview'] == 1)){ ?>
 <? include('ref.openjscad.inc.php'); ?>
<? } ?>
<? if (isset($_SESSION['scadview']) and ($_SESSION['scadview'] == 0)){ ?>
<a href="https://openscad.org/cheatsheet/" target=_new>OpenSCAD cheat sheet</a>
<? } ?>
 </ul>
</div>
 <div class="col-md-8">
<? if(($_SESSION['views'] == 3) and isset($_SESSION['objectsactive'])){  include('example.openscad.code.editor.php'); }?>
 <div class="col-md-1">
</div>
<? //if (isset($_SESSION['jscadfilename'])){ include('code.editor.php'); } ?><br>
 </div>
</div>

</body>
</html>

<? } else { ?>
<? header("Location: example.redirect.php");?>
<? } ?>

