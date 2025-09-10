<? $projectsdata = json_decode(file_get_contents('projects.json'), true); ?>
<br>
<? //include('openscad.select.jscad.inc.php');?>
<h4>Select OpenSCAD list:</h4><br>
<? if((isset($_GET['oid']))and($_GET['oid']=="download")){?>
<a href="openscads/rendered_<?=preg_replace("/.jscad$/", ".stl",$_SESSION['jscadfilename'])?>" class="btn btn-sm btn-success" role="button" aria-pressed="true"><b>Download Rendered STL</b></a><br><br>
<? } ?>
 <?$dir = scandir("openscads/"); ?>
<? $ddir = array(); 
  foreach($dir as $dd){ ?>
<? if (preg_match("/^.*\.scad$|\.SCAD$/", $dd)){ array_push($ddir, $dd); }?>
<? } ?>
 <? $size = count($ddir);
  if (count($ddir) > 10){ $size=10; }
 ?>

<form action=example.openscad.objects.json.form.php method=post>
 <select class="form-control form-control-sm" name="objectlist" size=<?=$size?>>
  <? foreach($ddir as $key => &$val){ ?>
  <? if ($val == preg_replace("/\.jscad/", ".scad", $_SESSION['objectsactive'])) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
  <? } ?>
 </select>
<br>
  <button type="submit" name="selectopenscad" class="btn-sm btn-primary"><b>Select file</b></button>&nbsp;&nbsp;<br><br>
<!--  <button type="submit" name="selectjscadlist" class="btn-sm btn-primary"><b>JSCAD list</b></button>&nbsp;&nbsp;-->
  <!--<a href="openscads/<?=$_SESSION['objectsactive']?>" class="btn btn-sm btn-warning" role="button" aria-pressed="true"><b>Download OpenSCAD file</b></a>
&nbsp;&nbsp;-->
  <!--<button type="submit" name="renderfromjscad" class="btn-sm btn-success"><b>Render to STL</b></button>&nbsp;&nbsp; 
  <button type="submit" name="selectslice" class="btn-sm btn-danger"><b>Slice STL</b></button>&nbsp;&nbsp; 
-->
<br><br>
  <!--<button type="submit" name="delete" class="btn-sm btn-danger"><b>Delete file</b></button><br>-->
</form>
<br>
<?// print_r($projectsdata[$_SESSION['selectedproject']]); ?>
<? //print_r($projectsdata[$_SESSION['selectedproject']]['jscad'])?>
<?//$_SESSION['jscadlist'][$_POST['objectlist']]?>
<? //$key =array_search(preg_replace("/\.scad|\.SCAD/", ".jscad",$_SESSION['objectsactive']),$projectsdata[$_SESSION['selectedproject']]['jscad']);?>
<? //array_push($projectsdata[$_SESSION['selectedproject']]['jscad'],$jscad.'.jscad'); ?>
<br>
<form action="example.openscad.objects.json.form.php" method="post" enctype="multipart/form-data">
 <style>
.fileContainer {
    overflow: hidden;
    position: relative;
}

.fileContainer [type=file] {
    cursor: inherit;
    display: block;
    font-size: 999px;
    filter: alpha(opacity=0);
    min-height: 100%;
    min-width: 100%;
    opacity: 0;
    position: absolute;
    right: 0;
    text-align: right;
    top: 0;
}
 </style>
 <script type ="text/javascript" >
function showButton(){
 document.getElementById ("uploadbutton").style.visibility ="visible";
}

function getFile() {
  showButton();
  document.getElementById("upfile").click();
}

function sub(obj) {
  var file = obj.value;
  var fileName = file.split("\\");
  document.getElementById("yourBtn").innerHTML = fileName[fileName.length - 1];
  document.myForm.submit();
  event.preventDefault();
}
</script>
<style>
#yourBtn {
  position: relative;
  /*top: 50px;*/
  font-family: calibri;
  width: 150px;
  padding: 10px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border: 1px dashed #BBB;
  font-family: Arial, Helvetica, sans-serif;
  text-align: center;
  background-color: #FF8C00;
  color: white;
  cursor: pointer;
}
</style>


<? //if (isset($_SESSION['selectedproject'])){ ?>
<!--
<h4>Upload OpenSCAD file</u></h4>
<br>
  <div id="yourBtn" onclick="getFile()">Click to upload OpenSCAD</div>
  <div style='height: 0px;width: 0px; overflow:hidden;'><input id="upfile" type="file" name="fileToUpload" value="upload" onchange="sub(this)" /></div>
  <br><div id="myDIV">
 <button type="submit" name=upload value="Upload file" id="uploadbutton" class="btn btn-primary" style="visibility:hidden">Upload file</button></div>
</form>
-->
<?// } else { ?>
<!-- <b>Please select a project in order to upload</b>-->
<? //} ?>

<?  $configjson = json_decode(file_get_contents('slic3r/slic3rconfigfiles.json'), true);
if (count($configjson['file'])>3){ $size=3; } else { $size = count($configjson['file']);}
?>



