<? session_start(); ?>
<?
if (isset($_GET['id'])){
$fln = $_GET['id'];
$_SESSION['jscadfilename'] = $fln;
$f = fopen("uploads/".$_SESSION['jscadfilename'],"r");
$_SESSION['jscadcontents'] = fread($f,filesize("uploads/".$_SESSION['jscadfilename']));
header("Location: objects.json.php");
}
?>
