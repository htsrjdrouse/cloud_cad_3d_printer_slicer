<? session_start(); ?>
<? if(isset($_GET['jscad'])){
$_SESSION['jscadfilename'] = $_GET['jscad'];
$_SESSION['selectedproject'] = $_GET['project'];
$f = fopen("uploads/".$_SESSION['jscadfilename'],"r");
$_SESSION['jscadcontents'] = fread($f,filesize("uploads/".$_SESSION['jscadfilename']));
 header("Location: objects.json.php");
} ?>
