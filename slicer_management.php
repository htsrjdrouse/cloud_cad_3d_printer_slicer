<!--<div class="row">-->
<div class="col-sm-7">
<form action="slic3r/slic3r_varcatch.php" method="post">

<b>Select Slic3r configuration</b><br>
<? if(!isset($_SESSION['configactive'])){?> <font color=red>Please select configuration file</font><?} ?>

<?  $configjson = json_decode(file_get_contents('slic3r/slic3rconfigfiles.json'), true); ?>
<?=$_SESSION['configactive']?>

<br>
 <? $ddir = $configjson['file'];?>
 <select class="form-control form-control-sm" name="configlist" size=<?=$size?>>
  <? foreach($ddir as $key => &$val){ ?>
  <? if ($val == $_SESSION['configactive']) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
  <? } ?>
 </select>

<br>
<br>

<button type="submit" name="selectconfigfront" class="btn-sm btn-success">Select</button><br><br>
<a href="slic3r/slic3rconfig_management.php" class="btn btn-sm btn-warning" role="button" aria-pressed="true">Manage</a><br><br>
<? if (isset($_SESSION['jscadfilename'])){?>
<?$jdir = scandir("rendered/"); ?>
<? if (in_array("rendered_".preg_replace("/.jscad$/", ".stl",$_SESSION['jscadfilename']), $jdir)){ $fl = 1; } else { $fl = 0; } ?>
<? if ($fl==1) { ?> 
<? if (isset($_SESSION['configactive'])){ ?>
<button type="submit" name="slice" class="btn-sm btn-danger">Slice</button>
<? } ?>
<br><br>
<?="rendered_".preg_replace("/.jscad$/", ".stl",$_SESSION['jscadfilename'])?><br> 
<? } ?> 
<? } ?> 
<?$jdir = scandir("rendered/gcodes"); ?>
<? if (in_array("rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename']), $jdir)){  ?>
<? 
$pdat = fopen("rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename']),"r");
$dat= fread($pdat,filesize("rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename'])));
$adat = preg_split("/\n/", $dat);
//var_dump($dat);	
?>
<? 
//$zlevels = gcodeparse($adat);
$stats = readgcodestats(preg_replace("/.jscad$/", ".stl",$_SESSION['jscadfilename']));
//$stats = gcodeparsefilament($adat);
//var_dump($stats['filamentlength']);

echo "<br>&nbsp;&nbsp;Filament volume (cm<sup>3</sup>) ".($stats['filamentvol']).'<br>';
echo "&nbsp;&nbsp;Filament length (mm) ".($stats['filamentlength']).'<br>';
echo "&nbsp;&nbsp;Print time ".$stats['time']."<br>";
?>
<? $_SESSION['filepos'] =  preg_split("/,/", $stats['filepos']);?>
<? array_unshift($_SESSION['filepos'],0); ?>
<? //array_pop($_SESSION['filepos']); ?>
<? $zlevels =  preg_split("/,/", $stats['zlevels']);?>
<? //print_r($zlevels); ?>
<br>
<? //array_pop($zlevels); ?>
<? include('selectgcodelines.php'); ?>
<? } ?>
<br>
</div>


