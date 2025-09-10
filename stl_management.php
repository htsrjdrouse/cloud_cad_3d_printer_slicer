<? //var_dump($projectsdata[$_SESSION['selectedproject']]['jscad']);?>
<br>

<? if (isset($_SESSION['selectedproject']['jscad'])){ ?>
<? $djdir = $projectsdata[$_SESSION['selectedproject']]['jscad']; ?>
<? $djdir = array_unique($djdir); ?>
<h4>Select STL list:</h4><br>
 <?$dir = scandir("uploads/"); ?>
<? $ddir = array(); 
  foreach($dir as $dd){ ?>
<? if (preg_match("/^.*.stl$|.STL$/", $dd)){ 
  if (in_array(preg_replace("/\.stl|\.STL/", ".jscad",$dd), $djdir)){ 
   array_push($ddir, $dd); 
  }
 }?>
<? } ?>
 <? $size = count($ddir);
  if (count($ddir) > 10){ $size=10; }
 ?>

<form action=objects.json.form.php method=post>
 <select class="form-control form-control-sm" name="objectlist" size=<?=$size?>>
  <? foreach($ddir as $key => &$val){ ?>
  <? if ($val == $_SESSION['objectsactive']) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
  <? } ?>
 </select>
<br>
  <button type="submit" name="select" class="btn-sm btn-primary">Select file</button>&nbsp;&nbsp;
<? if(isset($_SESSION['objectsactive'])){ ?>
  <a href="uploads/<?=$_SESSION['objectsactive']?>" class="btn btn-sm btn-success" role="button" aria-pressed="true"><b>Download STL</b></a>&nbsp;&nbsp;
  <button type="submit" name="delete" class="btn-sm btn-danger">Delete file</button><br><br>
<? } ?> 
</form>
<? } ?>
<br>

<form action="display.project.php" method="post" enctype="multipart/form-data">
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

<? if (isset($_SESSION['selectedproject'])){ ?>
<h4>Upload STL file (JSCAD saved in <u><?=$_SESSION['selectedproject']?></u>)</h4>
<br>
  <div id="yourBtn" onclick="getFile()">Click to upload STL</div>
  <!-- this is your file input tag, so i hide it!-->
  <!-- i used the onchange event to fire the form submission-->
  <div style='height: 0px;width: 0px; overflow:hidden;'><input id="upfile" type="file" name="fileToUpload" value="upload" onchange="sub(this)" /></div>
  <br><div id="myDIV">
 <button type="submit" name=upload value="Upload file" id="uploadbutton" class="btn btn-primary" style="visibility:hidden">Upload file</button></div>
<? } else { ?>
 <b>Please select a project in order to upload</b>
<? } ?>

<?  $configjson = json_decode(file_get_contents('slic3r/slic3rconfigfiles.json'), true);
if (count($configjson['file'])>3){ $size=3; } else { $size = count($configjson['file']);}
?>
</form>



