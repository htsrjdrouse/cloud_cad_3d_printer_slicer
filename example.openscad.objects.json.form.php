<? session_start(); ?>
<? if(isset($_POST['selectjscadlist'])){
 $_SESSION['views'] = 0;
 $_SESSION['jscadfilename'] = "iverntech_slider_xshuttle_connect.jscad";
 //header("Location: example.objects.json.php");
 header("Location: index.php");
} ?>
<? if(isset($_POST['selectslice'])){
$_SESSION['views'] = 2; 
 //header("Location: example.objects.json.php");
 header("Location: index.php");
} ?>
<? if(isset($_POST['renderfromjscad'])){
//$jscadfile = preg_replace("/stl$|STL$/", "jscad", $_SESSION['objectsactive']);
$jscadfile = $_SESSION['objectsactive'];
system("sudo openjscad openscads/".$jscadfile." -o openscads/rendered_".preg_replace("/\.jscad/", ".stl",$_SESSION['objectsactive']));
exec('sudo chown www-data:www-data openscads/rendered_'.preg_replace("/\.jscad/", ".stl",$_SESSION['objectsactive']));
 //header("Location: example.objects.json.php");
 header("Location: index.php");
}?>
<? if(isset($_POST['openjscad'])){
 $_SESSION['scadfilename']= $_POST['filename'];
 $_SESSION['scadview'] = 1;
 $jscadfile = preg_replace("/\.scad|\.SCAD/", ".jscad", $_POST['filename']);
 //header("Location: example.objects.json.php");
 header("Location: index.php");
} ?>
<? if(isset($_POST['openscad'])){
 $_SESSION['scadfilename']= $_POST['filename'];
 $_SESSION['scadview'] = 0;
 //$jscadfile = $_POST['filename'];
 $jscadfile = preg_replace("/\.jscad|\.JSCAD/", ".scad", $_POST['filename']);
 //header("Location: example.objects.json.php");
 header("Location: index.php");
} ?>
<? if(isset($_POST['savejscad'])){
 $projectsdata = json_decode(file_get_contents('projects.json'), true);
 $_SESSION['scadview'] = 1;
 $_SESSION['scadcontents']= $_POST['macrofiledata'];
 $_SESSION['scadfilename']= $_POST['filename'];
 echo $_SESSION['selectedproject'].'<br>';
 print_r($projectsdata[$_SESSION['selectedproject']]);
 //print_r($projectsdata[$_SESSION['selectedproject']]['jscad']);
 if (!in_array($_POST['filename'], $projectsdata[$_SESSION['selectedproject']]['jscad'])){
         array_push($projectsdata[$_SESSION['selectedproject']]['jscad'], $_POST['filename']);
         file_put_contents('projects.json', json_encode($projectsdata));
 }
 $myfile = fopen("openscads/".$_SESSION['scadfilename'], "w");
 fwrite($myfile, $_SESSION['scadcontents']); 
 fclose($myfile);
 $f = fopen("openscads/".$_SESSION['scadfilename'],"r"); //$_SESSION['jscadfilename'],"r");
 $_SESSION['fromstl'] = 0;
 $_SESSION['jscadcontents'] = fread($f,filesize("openscads/".$_SESSION['scadfilename']));
 //header("Location: example.objects.json.php");
 header("Location: index.php");
 } ?>
<? if(isset($_POST['savescad'])){
 $_SESSION['scadview'] = 0;
 $_SESSION['scadcontents']= $_POST['macrofiledata'];
 $_SESSION['scadfilename']= $_POST['filename'];
 $projectsdata = json_decode(file_get_contents('projects.json'), true);
 if (!in_array($_POST['filename'], $projectsdata[$_SESSION['selectedproject']]['jscad'])){
         array_push($projectsdata[$_SESSION['selectedproject']]['jscad'], $_POST['filename']);
         file_put_contents('projects.json', json_encode($projectsdata));
 }
 $myfile = fopen("openscads/".$_SESSION['scadfilename'], "w");
 fwrite($myfile, $_SESSION['scadcontents']); 
 fclose($myfile);
 exec('sudo openjscad openscads/'.$_SESSION['scadfilename'].' -o openscads/'.preg_replace("/\.scad|\.SCAD/",".jscad", $_SESSION['scadfilename']));
 $f = fopen("openscads/".preg_replace("/\.scad|\.SCAD/",".jscad", $_SESSION['scadfilename']),"r"); //$_SESSION['jscadfilename'],"r");
 $_SESSION['fromstl'] = 0;
 $_SESSION['jscadcontents'] = fread($f,filesize("openscads/".preg_replace("/\.scad|\.SCAD/",".jscad", $_SESSION['scadfilename'])));
 //header("Location: example.objects.json.php");
 header("Location: index.php");
 }?>

<? if(isset($_POST['delete'])){
 $_SESSION['scadview'] = 0;
 $projectsdata = json_decode(file_get_contents('projects.json'), true); 
 $_SESSION['fromstl'] = 1;
 $dir = scandir("openscads/");
 $ddir = array(); 
 foreach($dir as $dd){ 
   if (preg_match("/^.*\.scad$|\.SCAD$/", $dd)){ 
    array_push($ddir, $dd); 
   }
  }
 unlink("openscads/".$ddir[$_POST['objectlist']]);
 unlink("openscads/".preg_replace("/\.scad|\.SCAD/", ".jscad", $ddir[$_POST['objectlist']]));
 unset($_SESSION['objectsactive']);
 $jscadv = preg_replace("/\.scad$|\.SCAD$/", "jscad", $ddir[$_POST['objectlist']]);
 unlink("openscads/".$jscadv);
 $key =array_search(preg_replace("/\.scad|\.SCAD/", ".jscad",$_SESSION['objectsactive']),$projectsdata[$_SESSION['selectedproject']]['jscad']);
 unset($projectsdata[$_SESSION['selectedproject']]['jscad'][$key]);
 file_put_contents('projects.json', json_encode($projectsdata));
 //header("Location: example.objects.json.php");
 header("Location: index.php");
} ?>
<? if(isset($_POST['selectjscad'])){
 $_SESSION['jscadfilename'] = $_SESSION['jscadlist'][$_POST['objectlist']];
 $_SESSION['fromstl'] = 0;
 $f = fopen("openscads/".$_SESSION['jscadfilename'],"r");
 $_SESSION['jscadcontents'] = fread($f,filesize("openscads/".$_SESSION['jscadfilename']));
 //header("Location: example.objects.json.php");
 header("Location: index.php");
}
?>
<? include('jscadlib.php') ?>
<? if(isset($_POST['selectopenscad'])){
 //echo "selected<br>";
 $_SESSION['fromstl'] = 0;
 //$_SESSION['jsonpositions'] = json_decode(file_get_contents('uploads/'.$_SESSION['objectsactive']), true);
 $dir = scandir("openscads/");
 $ddir = array(); 
 $jdir = array();
 foreach($dir as $dd){ 
   if (preg_match("/^.*\.scad$|\.SCAD$/", $dd)){ 
    array_push($ddir, $dd); 
   }
   if (preg_match("/^.*.jscad$/", $dd)){ 
    array_push($jdir, $dd); 
   }
  }
 $_SESSION['objectsactive'] = preg_replace("/\.scad|\.SCAD/", ".jscad",$ddir[$_POST['objectlist']]);
 $openscadfile = $_SESSION['objectsactive'];
 $jscad = preg_replace("/\.scad$|\.SCAD$/", "", $ddir[$_POST['objectlist']]);
 $ff= $jscad.".jscad";
 $projectsdata = json_decode(file_get_contents('projects.json'), true); 
 /*
 if (!in_array($ff, $projectsdata[$_SESSION['selectedproject']]['jscad'])){
	 array_push($projectsdata[$_SESSION['selectedproject']]['jscad'], $ff);
         file_put_contents('projects.json', json_encode($projectsdata));
 }
 */
 if (!in_array($openscadfile, $jdir)){ 
  exec('sudo openjscad openscads/'.$openscadfile.' -o openscads/'.$jscad.'.jscad');
  exec('sudo chown www-data:www-data openscads/'.$jscad.'.jscad');
  exec('sudo chmod 777 openscads/'.$jscad.'.jscad');
  sleep(3);
  //$trimmed = file('uploads/'.$ff, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  //$res = parser($ff);
 }
 $_SESSION['jscadfilename'] =  $ff;
 $f = fopen("openscads/".$_SESSION['jscadfilename'],"r");
 $_SESSION['jscadcontents'] = fread($f,filesize("openscads/".$ff));
 //header("Location: example.objects.json.php");
 header("Location: index.php");
}
?>
<? if(isset($_POST['upload'])){
$_SESSION['scadview'] = 0;
$target_dir = "openscads/";
$target_file =  $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (preg_match("/\.scad$|\.SCAD$/",basename($_FILES["fileToUpload"]["name"]))){ $uploadOk = 1; } else { $uploadOk = 0; }
//$uploadOk = 1;
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check == false) {
  $uploadOk = 1;
} else {
  echo "File is an image.";
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
     $jscad = preg_replace("/\.scad$|\.SCAD$/", "", $fnm);
     $projectsdata = json_decode(file_get_contents('projects.json'), true); 
     if(!isset($projectsdata[$_SESSION['selectedproject']]['jscad'])){ $projectsdata[$_SESSION['selectedproject']]['jscad'] = array(); }
     if(!is_array($projectsdata[$_SESSION['selectedproject']]['jscad'])){ $projectsdata[$_SESSION['selectedproject']]['jscad'] = array(); }
     array_push($projectsdata[$_SESSION['selectedproject']]['jscad'],$jscad.'.jscad');
     file_put_contents('projects.json', json_encode($projectsdata));
      //echo 'sudo openjscad openscads/'.$fnm.' -o openscads/'.$jscad.'.jscad';
      exec('sudo openjscad openscads/'.$fnm.' -o openscads/'.$jscad.'.jscad');
     $ff= $jscad.".jscad";
     $res = parser('openscads',$ff);
   } else {
      $msg = "Sorry, there was an error uploading your file.<br>";
  }
  }
 //header("Location: example.objects.json.php");
 header("Location: index.php");
}
?>
