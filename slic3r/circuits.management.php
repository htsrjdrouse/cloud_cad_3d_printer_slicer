<? session_start(); ?>
<? include('../jscadlib.php');?>
<?
if ((isset($_POST['adjustxoffset']))){ 
 $_SESSION['xoffset'] = $_POST['xoffset'];
}
if (!(isset($_SESSION['layer']))){ 
 $_SESSION['layer'] = 0;
}

$layer = $_SESSION['layer']; 
$row = 1; 
$rowsp = 2.54; 
$column = 3; 
$columnsp = 2.54; 
$diameter = 1; 
$exportgcode = 0;
?>
<? if(isset($_POST['exportgcode'])){
$exportgcode = 1;
}?>
<? if(isset($_POST['clearselected'])){
 if ($_POST['type'] == "highlightholes"){ 
	 unset($_SESSION['holelist'][$_POST['key']]); 
 } 
 if ($_POST['type'] == "highlighttrace"){ 
	 unset($_SESSION['linelist'][$_POST['key']]); 
 }
}?>
<? if(isset($_POST['clear'])){
$_SESSION['holelist'] =array();
$_SESSION['holes'] = array();
$_SESSION['linelist'] =array();
$_SESSION['lines'] = array();
}?>
<? if(isset($_POST['stoptrace'])){
$_SESSION['settraceposition'] = 0;
if(!isset($_SESSION['linelist'])){ $_SESSION['linelist'] = array(); }
 array_push($_SESSION['linelist'], $_SESSION['line']);
 $_SESSION['line'] =array();
}
?>
<? if(isset($_POST['drawtrace'])){ 
 $_SESSION['settraceposition'] = 1;
}?>
<? if(isset($_POST['addholes'])){ 
 $row = $_POST['holerow'];
 $rowsp = $_POST['holerowsp'];
 $column = $_POST['holecol'];
 $columnsp = $_POST['holecolsp'];
 $diameter = $_POST['diameter'];
 if (!isset($_SESSION['holename'])){$_SESSION['holename'] = 0;} else {$_SESSION['holename'] = $_SESSION['holename'] + 1;}
 if (!isset($_SESSION['holelist'])){ $_SESSION['holelist'] = array(); }
 $_SESSION['holes'] = array('row'=>$row,'rowsp'=>$rowsp,'column'=>$column, 'columnsp'=>$columnsp,'diameter'=>$diameter,'holename'=>$_SESSION['holename'], 'X'=>-1, 'Y'=>-1);
 $_SESSION['setholeposition'] = 1;
 }
?>

<? if(isset($_POST['selectlevel'])){ 
$layer = $_POST['gcodelayer'];
$_SESSION['layer'] = $layer;
 } ?>

<html lang="en">
<head>


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
 <div class="col-md-1">
 </div>
 <div class="col-md-4">
<br>
<?=$_SESSION['jscadfilename']?>
<?
$pdat = fopen("../rendered/gcodes/rendered_".preg_replace("/\.jscad/", ".gcode",$_SESSION['jscadfilename']),"r");
$dat= fread($pdat,filesize("../rendered/gcodes/rendered_".preg_replace("/\.jscad/",".gcode",$_SESSION['jscadfilename'])));
$adat = preg_split("/\n/", $dat);
?>
<br>
 <a href="../objects.json.php" class="btn btn-sm btn-success" role="button" aria-pressed="true">STL Designer</a><br><br>
 <a href="targets_management.php" class="btn btn-sm btn-danger" role="button" aria-pressed="true">Target Layout</a><br><br>
<br>
<b>Model: rendered_<?=preg_replace("/\.jscad/", ".stl",$_SESSION['jscadfilename'])?>.stl</b>
<br>


<? if(!isset($layer)){ $layer = count($zlevels)-1; }?>
<? $zlevels = prusagcodeparse($adat); ?>
<b>Layer: <?=count($zlevels)?></b><br>
<br>
<? if(isset($layer)){ ?>
<? $lvr = levelparser($zlevels,$layer); ?>
<? } ?>
<? $size =count($zlevels); if ($size > 10){ $size=10; }?>
<br>
<? //print_r($zlevels);?>
<? 
/*
foreach($zlevels as $key => &$val){
print_r($val[2]['lines']);
echo "<br>";
echo "<br>";
}
 */
?>
<form action=circuits.management.php method=post>
<input type=hidden name=zlevels[] value="<?=$zlevels?>">
  <!--<button type="submit" name="selectlayers" class="btn-sm btn-danger">Display selected layers</button>-->
 <div class="col-sm-5">
 <select class="form-control form-control-sm" name="gcodelayer" size=<?=$size?>>
<?
$key = 0;
foreach($zlevels as $key => &$val){?>
<? 
     if (preg_match("/^G1 Z.*$/", $val[2]['lines'])){
       preg_match("/^G1 Z(.*) F.*$/", $val[2]['lines'], $ar); ?>
       <?$str =$key." -- Z level: ".round($ar[1],3); ?>
     <?
     } else { ?>
       <?$str ="prelude"; ?>
 <? } ?>
  <? if ($key == $layer){ $selzlevel= $ar[1];?>
  <option value=<?=$key?> selected><?=$str?></option>
  <? } else { ?>
  <option value=<?=$key?>><?=$str?></option>
  <? } ?>
<? } ?>
 </select>
 <br>
<? //print_r($lvr); ?>
<? $xry=array();$yry=array();$ct=0;$ln=array();$lntrace = array();foreach($lvr as $key=>$value){ ?>
    <? $ct = $ct+1; array_push($xry,floatval($value['X']));array_push($yry,floatval($value['Y']));array_push($ln, array('X'=>$value['X'], 'Y'=>$value['Y'])); if($ct == 2){?><? array_push($lntrace,$ln);?><?$ct = 0;$ln=array();}?>
<? } ?>
<br>
<br>
<? //var_dump($_SESSION['holelist']);?>
<font size=1>
 
<? if((isset($_SESSION['holelist'])) and (count($_SESSION['holelist']))){ ?>
<b>Holes</b><br>
<? foreach($_SESSION['holelist'] as $hh){ ?>
 //<?=$hh['holename']?> row <?=$hh['row']?> column <?=$hh['column']?> diameter <?=$hh['diameter']?><br>
 //circle <?=$hv['holename']?><br>
<? for($y=0;$y<$hh['row'];$y++){ 
   for($x=0;$x<$hh['column'];$x++){ ?>
 G1 Z<?=$selzlevel+(0.4+1)?><br>  
 G1 X<?=$hh['X']+($x*$hh['columnsp'])+$_SESSION['xoffset']?> Y<?=$hh['Y']+($y*$hh['rowsp'])?><br>
 G1 Z<?=$selzlevel+0.4?><br>  
 //Dispense volume need to specify
 G1 Z<?=$selzlevel+(0.4+1)?><br>  
<? } } ?>
<? } ?>
<? } ?>
<br>
<? if((isset($_SESSION['linelist'])) and (count($_SESSION['linelist'])>0)){ ?>
<b>Traces</b><br>
<?
  $circuitsizex = (max($xry)-min($xry))*4;
  $circuitsizey = (max($yry)-min($yry))*4;
  $shimy=20;
?>
<? foreach($_SESSION['linelist'] as $kl=>$line){
   foreach($line as $k=>$v){
    if (($k > 0)){
?>
  //<br>
  G1 Z<?=$selzlevel+1;?><br>
  G1 X<?=round($line[$k-1]['X']+$_SESSION['xoffset'],3)?> Y<?=round((($circuitsizey/4+$shimy/4+min($yry))-$line[$k-1]['Y']),3)?><br>
  //Turn on dispenser
  G1 Z<?=$selzlevel+0.4;?><br>
  G1 X<?=round($v['X']+$_SESSION['xoffset'],3)?> Y<?=round((($circuitsizey/4+$shimy/4+min($yry)) - $v['Y']),3)?><br>
  //Turn off dispenser
  G1 Z<?=$selzlevel+1;?><br>
  //<br>
<? }} } ?>
<? } ?>
</font>
<br>
 </div>
 <div class="col-sm-3">
<button type="submit" name="selectlevel" class="btn-sm btn-primary">View layer</button></form><br><br>
 </div>
<div class="col-sm-4">
<?if((isset($_SESSION['holelist']) and (count($_SESSION['holelist']) > 0 ))or (isset($_SESSION['linelist']) and (count($_SESSION['linelist'])>0))) { ?><form action=circuits.management.php method=post><button type="submit" name="clear" class="btn-sm btn-danger">Clear</button><br></form> <? } ?>
<br>
<form action=circuits.management.php method=post>
<? if(!(isset($_SESSION['xoffset']))){ $_SESSION['xoffset'] = 0;}?>
<b>X offset</b><br>
<input type=text name=xoffset value=<?=$_SESSION['xoffset']?> size=3>
<button type="submit" name="adjustxoffset" class="btn-sm btn-warning">Adjust X offset</button><br><br>
</form>
<form action=circuits.management.php method=post>
<b><u>Holes</u></b><br>
<table><tr>
<tr><td><font size=1><b>Row</b></font> </td><td><input type=text name=holerow value="<?=$row?>" style="font-size: 10px;" size=2></td>
<td>&nbsp;<font size=1><b>Spacing</b>&nbsp;</font> </td><td><input type=text name=holerowsp value="<?=$rowsp?>" style="font-size: 10px;" size=2></td></tr>
<tr><td><font size=1><b>Column&nbsp;</b></font> </td><td><input type=text name=holecol value="<?=$column?>" style="font-size: 10px;" size=2> </td>
<td>&nbsp;<font size=1><b>Spacing</b>&nbsp;</font> </td><td><input type=text name=holecolsp value="<?=$columnsp?>" style="font-size: 10px;" size=2></td></tr>
<tr><td><font size=1><b>Diameter&nbsp;</b></font> </td><td><input type=text name=diameter value="<?=$diameter?>" style="font-size: 10px;" size=2></td></tr>
</table>
<br>
<button type="submit" name="addholes" class="btn-sm btn-success">Add holes</button><br><br>
<br>
<? if($_SESSION['settraceposition'] != 1){ ?>
<button type="submit" name="drawtrace" class="btn-sm btn-warning">Draw trace</button><br><br>
<? } ?>
<? if (isset($_SESSION['settraceposition']) and ($_SESSION['settraceposition'] == 1)){ ?>
<button type="submit" name="stoptrace" class="btn-sm btn-danger">Stop/Store trace</button><br><br>
<? } ?>
</form>
<br>
<? if((isset($_SESSION['holelist']) or (isset($_SESSION['linelist'])))){?>
<form action=circuit.holes.move.php method=post>
<button type="submit" name="exportgcode" class="btn-sm btn-success">Export gcode</button><br>
</form>
<? } ?>

<br>
<?if(isset($_GET['type'])) { ?><form action=circuits.management.php method=post><button type="submit" name="clearselected" class="btn-sm btn-danger">Clear selected</button><br><input type=hidden name="type" value=<?=$_GET['type']?>><input type=hidden name="key" value="<?=$_GET['key']?>"></form> <? } ?>
<? if((isset($_SESSION['holelist']))and(count($_SESSION['holelist'])>0)){ ?>
<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseHoles">
      <b>Holes</b>
      </a>
    </div>
   <div id="collapseHoles" class="accordion-body collapse">
  <? foreach($_SESSION['holelist'] as $hk=>$hv) {?>
   &nbsp;&nbsp;<font size=1><a href=circuits.management.php?key=<?=$hv['holename']?>&type=highlightholes><?=($hk+1)?>. <?=$hv['holename']?> X: <?=$hv['X']?> Y: <?=$hv['Y']?></a><br></font>
  <? } ?> 
    <div class="accordion-inner">
   </div>
 </div>
</div>
</div>
<? } ?>
<? if((isset($_SESSION['linelist'])) and (count($_SESSION['linelist'])>0)){ ?>
<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseLines">
      <b>Lines</b>
      </a>
    </div>
   <div id="collapseLines" class="accordion-body collapse">
  <? foreach($_SESSION['linelist'] as $kl =>$line) { ?>
  <font size=1>&nbsp;&nbsp;&nbsp;<a href=circuits.management.php?key=<?=$kl?>&type=highlighttrace>trace <?=$kl?></a><br></font>
 <? } ?> 
    <div class="accordion-inner">
   </div>
 </div>
</div>
</div>

<? } ?>

</div>
<div class="col-sm-12">
</div>

 </div>
 <div class="col-md-6">
<? if(count($lvr)> 0) { ?>
<? include('circuit.design.inc.php'); ?>
<? } ?>
 </div>
</div> <!-- row -->

</body>
</html>

<?
function levelparser($zlevels,$layer){
 $lvr = array();
 foreach($zlevels[$layer] as $zz){
	 if (preg_match('/^.*X.*Y.*$/',$zz['lines'])){
		 preg_match('/^.*X(.*)Y(.*) .*$/',$zz['lines'],$ag);
		 array_push($lvr, array("X"=>$ag[1], "Y"=>$ag[2]));
	 }
 }
 return $lvr;
}
?>

<?
function slicer_accord(){
?>
<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseHeader">
       <b>Subject</b>
      </a>
    </div>
   <div id="collapseHeader" class="accordion-body collapse">
   <div class="accordion-inner">
     <ul>Header</ul>
   </div>
 </div>
</div>
</div>


<? } ?>






