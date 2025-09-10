
<div class="row">
<div class="col-sm-4"></div>
<div class="col-sm-4"></div>
<div class="col-sm-4"></div>
<? if (!(isset($_SESSION['labotjson']))){
 $dir = scandir("slic3r/uploads/");
 array_shift($dir);
 array_shift($dir);
 $_SESSION['objectsactive'] = $dir[0];
 $_SESSION['labotjson'] = json_decode(file_get_contents('slic3r/uploads/'.$_SESSION['objectsactive']), true);
} ?>
<? $types = ($_SESSION['labotjson']['types']);?>
<br>
<? //$indetype = $types[0][$_SESSION['labbotjson']['targettrack']]; ?>
<?for($i=0;$i<count($types)-1;$i++){
 if ($types[$i][0]['name'] == "bed"){
	$dim = $types[$i][0]['X'];
 }
} ?>
<!--<br>dkjfdljf<? //echo $_SESSION['objectsactive'];?>&nbsp;&nbsp;
<? //$dim = 180; ?>
<!--<a href="slic3r/targets_management.php" class="btn btn-sm btn-danger" role="button" aria-pressed="true">Target Layout</a><br><br>-->


<?  include('3dviewer.inc.php'); ?>
</div>

<div class="row">
<? //if (isset($_SESSION['objectsactive'])){  ?>
 <div class="col-sm-9">
<? $jsonfile = preg_replace("/.jscad$/", ".json", $_SESSION['jscadfilename']); ?>
<?  if (file_exists('uploads/'.$jsonfile)) { ?>
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

