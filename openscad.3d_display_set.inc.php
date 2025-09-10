
<div class="row">
<div class="col-sm-4"></div>
<div class="col-sm-4"></div>
<div class="col-sm-4"></div>


<br>

<?  include('3dviewer.inc.php'); ?>


</div>

<div class="row">
<? //if (isset($_SESSION['objectsactive'])){  ?>
 <div class="col-sm-9">
<? $jsonfile = preg_replace("/.jscad$/", ".json", $_SESSION['jscadfilename']); ?>
<?  if (file_exists('openscads/'.$jsonfile)) { ?>
<? $movedata = json_decode(file_get_contents('uploads/'.$jsonfile), true);?>
<? } else { 
$movedata = array(
	'x'=>"0",
	'y'=>"0",
	'z'=>"0",
	'rx'=>"0",
  	'ry'=>"0",
  	'rz'=>"0",
  	'mx'=>"0",
  	'my'=>"0",
  	'mz'=>"0",
  	'lieflat'=>"",
  	'sx'=>"1",
  	'sy'=>"1",
  	'sz'=>"1"
 ); 
} ?>

<? if (isset($_SESSION['jscadfilename'])){ ?>
<? //include('move.imager.gui.tool.php'); ?>
<? } ?>
</div>
<div class="col-sm-1"></div>
</div>

