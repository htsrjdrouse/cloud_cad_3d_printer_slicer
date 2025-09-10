<? if(isset($_POST['upload'])){
$target_dir = "uploads/";
$target_file =  $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (preg_match("/\.stl$|\.STL$/",basename($_FILES["fileToUpload"]["name"]))){ $uploadOk = 1; } else { $uploadOk = 0; }
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
     $jscad = preg_replace("/.stl|.STL$/", "", $fnm);
     exec('sudo jscad uploads/'.$fnm.' -o uploads/'.$jscad.'.jscad');
     sleep(1);
     exec('sudo chown www-data:www-data uploads/'.$jscad.'.jscad');
     $ff= $jscad.".jscad";
     $res = parser('uploads',$ff);
     $projectsdata = json_decode(file_get_contents('projects.json'), true);
     if (!isset($projectsdata[$_SESSION['selectedproject']]['jscad'])){ $projectsdata[$_SESSION['selectedproject']]['jscad'] = array(); }
     if (!in_array($ff, $projectsdata[$_SESSION['selectedproject']]['jscad'])){
         array_push($projectsdata[$_SESSION['selectedproject']]['jscad'], $ff);
         file_put_contents('projects.json', json_encode($projectsdata));
     }
   } else {
      $msg = "Sorry, there was an error uploading your file.<br>";
  }
  }
}
?>
