<? session_start(); ?>
<? if(isset($_GET['jscad'])){

//http://52.200.33.55/devstlwork/openscad.catch.php?jscad=arducam_basecase_attachstem.jscad&project=openscads
$_SESSION['jscadfilename'] = $_GET['jscad'];
$_SESSION['selectedproject'] = $_GET['project'];
$f = fopen("openscads/".$_SESSION['jscadfilename'],"r");
$_SESSION['jscadcontents'] = fread($f,filesize("uploads/".$_SESSION['jscadfilename']));
 header("Location: objects.json.php");
} ?>

