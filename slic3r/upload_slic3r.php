<? if(isset($_POST['upload'])){

$target_dir = "./";
$target_file =  $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (preg_match("/\.ini$|\.INI$/",basename($_FILES["fileToUpload"]["name"]))){ $uploadOk = 1; } else { $uploadOk = 0; }
//$uploadOk = 1;
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check == false) {
  $uploadOk = 1;
} else {
  echo "File must have a .ini suffex.";
  $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

  if ($uploadOk == 1){
   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
     //$msg = 'target file '.$target_file.' uploaded<br>';
     $fnm = basename($_FILES["fileToUpload"]["name"]);
     $config = preg_replace("/\.ini$|\.INI$/", "", $fnm);
     $_SESSION['configactive'] = $config;
     if (file_exists('slic3rconfigfiles.json')){
	    $configjson = json_decode(file_get_contents('slic3rconfigfiles.json'), true);
	    if (!in_array($config,$configjson['file'])){
	     array_push($configjson['file'], $config);
	     file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
	    }
    } else {
	    $configjson = array('file'=>array());
	    array_push($configjson['file'], $config);
       	    file_put_contents('slic3rconfigfiles.json', json_encode($configjson));
    }
     /*
     $projectsdata = json_decode(file_get_contents('projects.json'), true);
     if(!isset($projectsdata[$_SESSION['selectedproject']]['jscad'])){ $projectsdata[$_SESSION['selectedproject']]['jscad'] = array(); }
     if(!is_array($projectsdata[$_SESSION['selectedproject']]['jscad'])){ $projectsdata[$_SESSION['selectedproject']]['jscad'] = array(); }
     array_push($projectsdata[$_SESSION['selectedproject']]['jscad'],$jscad.'.jscad');
     file_put_contents('projects.json', json_encode($projectsdata));
      */
      //echo 'sudo openjscad openscads/'.$fnm.' -o openscads/'.$jscad.'.jscad';
      //exec('sudo openjscad openscads/'.$fnm.' -o openscads/'.$jscad.'.jscad');
     $ff= $config.".ini";
     //$res = parser('openscads',$ff);
   } else {
      $msg = "Sorry, there was an error uploading your file.<br>";
  }
  }
 header("Location: slic3rconfig_management.php");
}
?>

	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
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



<h4>Upload Slic3r configuration</u></h4>
<br>
  <div id="yourBtn" onclick="getFile()">Click to upload</div>
  <!-- this is your file input tag, so i hide it!-->
  <!-- i used the onchange event to fire the form submission-->
  <div style='height: 0px;width: 0px; overflow:hidden;'><input id="upfile" type="file" name="fileToUpload" value="upload" onchange="sub(this)" /></div>
  <br><div id="myDIV">
 <button type="submit" name=upload value="Upload file" id="uploadbutton" class="btn btn-primary" style="visibility:hidden">Upload file</button></div>
</form>

