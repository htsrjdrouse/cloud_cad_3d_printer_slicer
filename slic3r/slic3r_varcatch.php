<? session_start(); ?>
<? include('../jscadlib.php') ?>
<?



if (isset($_POST['editgcode'])){
include('../jscadlib.php');
$pdat = fopen("../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename']),"r");
$dat= fread($pdat,filesize("../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename'])));
$adat = preg_split("/\n/", $dat);
fclose($pdat);
$zlevels = gcodeparse($adat);
//var_dump($zlevels[0]);
$gcodelist = array();
if (count($_SESSION['gcodelayers']) > 1) { echo "Sorry you can only select one layer to edit at time.<br>";} else {
  foreach($zlevels as $key=>$ggg){
   if($_SESSION['gcodelayers'][0] == $key){
    foreach(preg_split("/\n/", $_POST['gcodesegment']) as $pg){
     array_push($gcodelist, $pg);
    }
   } else {
	   foreach($ggg as $gggg){
	    if ($gggg != NULL){
	      //echo $gggg['lines'].'<br>';
	      array_push($gcodelist, $gggg['lines']);
	    }
	   }
   }
  }
exec("sudo chown www-data:www-data ../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename']));
$pdat = fopen("../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename']),"w");
foreach($gcodelist as $gl){
  //echo ($gl).'\n';
  fwrite($pdat, $gl.PHP_EOL);
}
fclose($pdat);
header("Location: ../objects.json.php");
}
} ?>
<?if (isset($_POST['selectlayers'])){?>
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
<body>
<div class="row">
 <div class="col-md-2"></div>
 <div class="col-md-10">
 <a href=circuits.management.php>Visualize layers and design holes/traces</a><br><br>
 <form action=slic3r_varcatch.php method=post>
 <? $_SESSION['gcodelayers'] = $_POST['gcodelayers']; ?>
<a href="../objects.json.php" class="btn btn-sm btn-success" role="button" aria-pressed="true">STL Designer</a><br><br>
<!--<button type="submit" name="editgcode" class="btn-sm btn-danger">Save edited gcode</button><br>-->
<? $layers  = "";?>
<br>
<br>
<? $fname = "../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename'])?>
<?$pr = 0;?>
<? if(count($_POST['gcodelayers'])>1){?>
<? $ct=0;$st = $_POST['gcodelayers'][0];foreach($_POST['gcodelayers'] as $gg){
 if ($gg != ($st+$ct)){$pr = 1;}
 $ct = $ct +1;
} }?>
<? if($pr == 1) { ?> The selection of layers must be continuous<br> <? } else { ?>
<?//var_dump($_SESSION['filepos']);?>
<br>
<? 
	 $bkey = $_POST['gcodelayers'][0];
	 $ekey = $_POST['gcodelayers'][(count($_POST['gcodelayers'])-1)]+1;
         $section = file_get_contents($fname, NULL, NULL, $_SESSION['filepos'][$bkey], ($_SESSION['filepos'][$ekey] - $_SESSION['filepos'][$bkey]));
?>
<?
$s = preg_split("/\n/", $section);
foreach($s as $ss){
	echo $ss.'<br>';
}
?>
<? } ?>
</form>
</div>
</body></html>
<?
}
if (isset($_POST['downloadgcode'])){
    //$path ="/devstlwork/slic3r/rendered/gcodes/rendered_iverntech_connector.gcode";
    $path ="../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename']);
    header("Content-Type: application/octet-stream");    //
    header("Content-Length: " . filesize($path));
    header('Content-Disposition: attachment; filename='.$path);
    readfile($path);
}
if (isset($_POST['slice'])){
  //$cmd = "sudo slic3r rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename'])." --load slic3r/".$_SESSION['configactive'].".txt --output rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode", $_SESSION['jscadfilename']);
  unlink("../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode", $_SESSION['jscadfilename']));
  //$cmd = "sudo slic3r ../rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename'])." --load ".$_SESSION['configactive'].".txt --output ../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode", $_SESSION['jscadfilename']);
  $cmd = "sudo prusa-slicer ../rendered/rendered_".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename'])." --load ".$_SESSION['configactive'].".ini -g --o ../rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode", $_SESSION['jscadfilename']);
  /*
  system($cmd);
   */
  $output = shell_exec($cmd);
  //echo $cmd.'<br>';
  sleep(2);
  //echo "file ".preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename'])."<br>";

  scanprusagcode(preg_replace("/.jscad$/", ".stl", $_SESSION['jscadfilename']));
  header("Location: ../objects.json.php");
}
if (isset($_POST['saveconfig'])){
    $jsonfile = $_POST['slic3rconfig'];
    $_SESSION['configactive'] = $_POST['slic3rconfig'];
    $pcnt = collectvar();
    $a = fopen($jsonfile.'.json', 'w');
    fclose($a);
    file_put_contents($jsonfile.'.json', json_encode($pcnt));
    if (file_exists('slic3rconfigfiles.json')){
	    $configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
	    if (!in_array($jsonfile,$configjson['file'])){
	     array_push($configjson['file'], $jsonfile);
	     file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
	    }
    } else {
	    $configjson = array('file'=>array());
	    array_push($configjson['file'], $jsonfile);
       	    file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
    }
    $cmd = "sudo prusa-slicer";
    foreach($pcnt as $key => $value){
      if($value == "y"){ $cmd .= " --".$key; } else if($value != "n"){ $cmd .= " --".$key." ".$value; }
    }
    $cmd .= " --save ".$jsonfile.".ini";
    //system("sudo ".$cmd);
    //system($cmd);
    //echo $cmd.'<br>';
    $output = shell_exec($cmd);
    sleep(2);
    //echo $output.'<br>';
    header("Location: slic3rconfig_management.php");
}
if (isset($_POST['saveconfigtext'])){
    $jsonfile = $_POST['slic3rconfigtext'];
    $_SESSION['configactive'] = $_POST['slic3rconfigtext'];
    $a = fopen($jsonfile.'.ini', 'w');
    fwrite($a, $_POST['configfiledata']); 
    fclose($a);
    $configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
    if (!in_array($jsonfile,$configjson['file'])){
	     array_push($configjson['file'], $jsonfile);
	     file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
    } else { 
	    $newconfig = textparser($_POST['configfiledata']);
	    /*
	    echo "<br>";
	    var_dump($_SESSION['slic3rconfig']);
	    echo "<br>";
	    echo "<br>";
	    var_dump($newconfig);
	     */
	    $_SESSION['slic3rconfig'] = $newconfig;
    }
header("Location: slic3rconfig_management.php");
}
if (isset($_POST['selectconfig'])){
$configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
$_SESSION['configactive'] = $configjson['file'][$_POST['configlist']]; 
header("Location: slic3rconfig_management.php");
}
if (isset($_POST['selectconfigfront'])){
$configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
$_SESSION['configactive'] = $configjson['file'][$_POST['configlist']]; 
header("Location: ../objects.json.php");
}
if (isset($_POST['deleteconfig'])){
 $configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
 session_unset($_SESSION['configactive']);
 unset($configjson['file'][$_POST['configlist']]); 
 unlink($configjson['file'][$_POST['configlist']]."json"); 
 unlink($configjson['file'][$_POST['configlist']]."txt"); 
 file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
 header("Location: slic3rconfig_management.php");
}

function textparser($filetext){
	$jj = preg_split("/\n/", $filetext);
	array_shift($jj);
	$pop = array();
	foreach($_SESSION['slic3rconfig'] as $vkey=>$vv){
          //var_dump($vkey);
	  //echo "<br>";
	  $ppop = array();
	  foreach($vv as $akey => $avalue){
	   echo "<br>akey ".$akey."<br>";	
          $tval = $avalue;
	   foreach($jj as $key => $value){
	   $tp = preg_split("/ = /", $value);
	   if (strcmp(preg_replace("/_/", "-",$tp[0]),$akey)==0){
	   //echo "matches!!!!!!-------akey ".$akey."<br>";	
	   //echo "tp[0] ".$tp[0]."<br>";	
	    $tval = $tp[1];
	   }
	   }
	   $ppop[$akey] = $tval;
	   }
	  $pop[$vkey] = $ppop;
	}
        return($pop);
}

function collectvar(){
    $cnt = array( 
    'nozzle-diameter'=> $_POST['nozzle-diameter'],
    'print-center'=> $_POST['print-center'],
    'z-offset'=> $_POST['z-offset'],
    'use-relative-e-distances'=> $_POST['use-relative-e-distances'],
    'use-firmware-retraction'=> $_POST['use-firmware-retraction'],
    'use-volumetric-e'=> $_POST['use-volumetric-e'],
    'filament-diameter'=> $_POST['filament-diameter'],
    'extrusion-multiplier'=> $_POST['extrusion-multiplier'],
    'temperature'=> $_POST['temperature'],
    'bed-temperature'=> $_POST['bed-temperature'],
    'first-layer-bed-temperature'=> $_POST['first-layer-bed-temperature'],
    'travel-speed'=> $_POST['travel-speed'],
    'perimeter-speed'=> $_POST['perimeter-speed'],
    'small-perimeter-speed'=> $_POST['small-perimeter-speed'],
    'external-perimeter-speed'=> $_POST['external-perimeter-speed'],
    'infill-speed'=> $_POST['infill-speed'],
    'solid-infill-speed'=> $_POST['solid-infill-speed'],
    'top-solid-infill-speed'=> $_POST['top-solid-infill-speed'],
    'support-material-speed'=> $_POST['support-material-speed'],
    'support-material-interface-speed'=> $_POST['support-material-interface-speed'],
    'bridge-speed'=> $_POST['bridge-speed'],
    'gap-fill-speed'=> $_POST['gap-fill-speed'],
    'first-layer-speed'=> $_POST['first-layer-speed'],
    'perimeter-acceleration'=> $_POST['perimeter-acceleration'],
    'infill-acceleration'=> $_POST['infill-acceleration'],
    'bridge-acceleration'=> $_POST['bridge-acceleration'],
    'first-layer-acceleration'=> $_POST['first-layer-acceleration'],
    'default-acceleration'=> $_POST['default-acceleration'],
    'layer-height'=> $_POST['layer-height'],
    'first-layer-height' => $_POST['first-layer-height' ],
    'infill-every-layers'=> $_POST['infill-every-layers'],
    'solid-infill-every-layers'=> $_POST['solid-infill-every-layers'],
    'perimeters'=> $_POST['perimeters'],
    'top-solid-layers'=> $_POST['top-solid-layers'],
    'bottom-solid-layers'=> $_POST['bottom-solid-layers'],
    'solid-layers'=> $_POST['solid-layers'],
    'fill-density'=> $_POST['fill-density'],
    'fill-angle'=> $_POST['fill-angle'],
    'fill-pattern'=> $_POST['fill-pattern'],
    'fill-gaps'=> $_POST['fill-gaps'],
    'top-infill-pattern'=> $_POST['top-infill-pattern'],
    'bottom-infill-pattern'=> $_POST['bottom-infill-pattern'],
    'seam-position'=> $_POST['seam-position'],
    'external-perimeters-first'=> $_POST['external-perimeters-first' ],
    'spiral-vase'=> $_POST['spiral-vase'],
    'only-retract-when-crossing-perimeters'=> $_POST['only-retract-when-crossing-perimeters'],
    'solid-infill-below-area'=> $_POST['solid-infill-below-area'],
    'infill-only-where-needed'=> $_POST['infill-only-where-needed'],
    'infill-first'=> $_POST['infill-first'],
    'extra-perimeters'=> $_POST['extra-perimeters'],
    'avoid-crossing-perimeters'=> $_POST['avoid-crossing-perimeters'],
    'thin-walls'=> $_POST['thin-walls'],
    'detect-bridging-perimeters'=> $_POST['detect-bridging-perimeters'],
    'support-material'=> $_POST['support-material'],
    'support-material-threshold'=> $_POST['support-material-threshold'],
    'support-material-pattern'=> $_POST['support-material-pattern'],
    'support-material-spacing'=> $_POST['support-material-spacing'],
    'support-material-angle'=> $_POST['support-material-angle'],
    'support-material-contact-distance'=> $_POST['support-material-contact-distance'],
    'support-material-interface-layers'=> $_POST['support-material-interface-layers'],
    'support-material-interface-spacing'=> $_POST['support-material-interface-spacing'],
    'raft-layers'=> $_POST['raft-layers'],
    'support-material-enforce-layers'=> $_POST['support-material-enforce-layers'],
    'support-material-buildplate-only'=> $_POST['support-material-buildplate-only'],
    'dont-support-bridges'=> $_POST['dont-support-bridges'],
    'retract-length'=> $_POST['retract-length'],
    'retract-speed'=> $_POST['retract-speed'],
    'retract-restart-extra'=> $_POST['retract-restart-extra'],
    'retract-before-travel'=> $_POST['retract-before-travel'],
    'retract-lift'=> $_POST['retract-lift'],
    'retract-lift-above'=> $_POST['retract-lift-above'],
    'retract-lift-below'=> $_POST['retract-lift-below'],
    'retract-layer-change'=> $_POST['retract-layer-change'],
    'wipe'=> $_POST['wipe'],
    'retract-length-toolchange'=> $_POST['retract-length-toolchange'],
    'retract-restart-extra-toolchange'=> $_POST['retract-restart-extra-toolchange'],
    'cooling'=> $_POST['cooling'],
    'min-fan-speed'=> $_POST['min-fan-speed'],
    'max-fan-speed'=> $_POST['max-fan-speed'],
    'bridge-fan-speed'=> $_POST['bridge-fan-speed'],
    'fan-below-layer-time'=> $_POST['fan-below-layer-time'],
    'slowdown-below-layer-time'=> $_POST['slowdown-below-layer-time'],
    'min-print-speed'=> $_POST['min-print-speed'],
    'disable-fan-first-layers'=> $_POST['disable-fan-first-layers'],
    'fan-always-on'=> $_POST['fan-always-on'],
    'skirts'=> $_POST['skirts'],
    'skirt-distance'=> $_POST['skirt-distance'],
    'skirt-height'=> $_POST['skirt-height'],
    'min-skirt-length'=> $_POST['min-skirt-length'],
    'brim-width'=> $_POST['brim-width'],
    'interior-brim-width'=> $_POST['interior-brim-width'],
    'scale'=> $_POST['scale'],
    'rotate'=> $_POST['rotate'],
    'duplicate'=> $_POST['duplicate'],
    'duplicate-grid'=> $_POST['duplicate-grid'],
    'duplicate-distance'=> $_POST['duplicate-distance'],
    'xy-size-compensation'=> $_POST['xy-size-compensation'],
    'complete-objects'=> $_POST['complete-objects'],
    'extruder-clearance-radius'=> $_POST['extruder-clearance-radius'],
    'extruder-clearance-height'=> $_POST['extruder-clearance-height'],
    'resolution'=> $_POST['resolution'],
    'extrusion-width' => $_POST['extrusion-width' ],
    'first-layer-extrusion-width'=> $_POST['first-layer-extrusion-width'],
    'perimeter-extrusion-width'=> $_POST['perimeter-extrusion-width'],
    'external-perimeter-extrusion-width'=> $_POST['external-perimeter-extrusion-width'],
    'infill-extrusion-width'=> $_POST['infill-extrusion-width'],
    'solid-infill-extrusion-width'=> $_POST['solid-infill-extrusion-width'],
    'top-infill-extrusion-width'=> $_POST['top-infill-extrusion-width'],
    'support-material-extrusion-width'=> $_POST['support-material-extrusion-width'],
    'infill-overlap'=> $_POST['infill-overlap'],
    'bridge-flow-ratio'=> $_POST['bridge-flow-ratio'],
    'perimeter-extruder'=> $_POST['perimeter-extruder'],
    'infill-extruder'=> $_POST['infill-extruder'],
    'solid-infill-extruder'=> $_POST['solid-infill-extruder'],
    'support-material-extruder'=> $_POST['support-material-extruder'],
    'support-material-interface-extruder'=> $_POST['support-material-interface-extruder'],
    'ooze-prevention'=> $_POST['ooze-prevention'],
    'standby-temperature-delta'=> $_POST['standby-temperature-delta']
    );
    return $cnt;
}
?>
