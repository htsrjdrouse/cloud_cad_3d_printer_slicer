<? if (isset($_SESSION['jscadfilename'])){ 
$dir = scandir("uploads/");
$ddir = array(); 
foreach($dir as $dd){ 
 if (preg_match("/^.*\.jscad$|\.JSCAD$/", $dd)){ array_push($ddir, $dd); }
} 
$dir = scandir("openscads/");
foreach($dir as $dd){ 
 if (preg_match("/^.*\.jscad$|\.JSCAD$/", $dd)){ array_push($ddir, $dd); }
} 
if (in_array($_SESSION['jscadfilename'], $ddir)){
	include('3d_display_set.inc.php');  
}
?>
<br>
<? if($_SESSION['views'] == 0) { include('code.editor.php'); }?>
<? } ?>


