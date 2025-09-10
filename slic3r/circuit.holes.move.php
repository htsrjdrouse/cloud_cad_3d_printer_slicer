<? session_start(); ?>
<? if(isset($_POST['exportgcode'])){ 


} ?>
<? if(isset($_GET['tar'])){ 
 $_SESSION['setholeposition'] = 0;
 echo 'Target '.$_GET['tar'].'<br>';
 $_SESSION['holes']['X'] = $_GET['x'];
 $_SESSION['holes']['Y'] = $_GET['y'];
 $_SESSION['holes']['rX'] = $_GET['rx'];
 $_SESSION['holes']['rY'] = $_GET['ry'];
 array_push($_SESSION['holelist'],$_SESSION['holes']);
 header("Location: circuits.management.php");
}
if(isset($_GET['line'])){ 
if(!isset($_SESSION['line'])){$_SESSION['line'] = array(); }
if (count($_SESSION['line']) > 0){
 if (($_SESSION['line'][count($_SESSION['line'])-1]['rX'] == $_GET['rx']) and ($_SESSION['line'][count($_SESSION['line'])-1]['rY'] == $_GET['ry'])){
  $_SESSION['settraceposition'] = 0;
 } else {
  array_push($_SESSION['line'], array('linekey'=>$_SESSION['line']['key']+1,'X'=>$_GET['x'], 'Y'=>$_GET['y'], 'rX'=>$_GET['rx'],'rY'=>$_GET['ry']));
 }
}
  array_push($_SESSION['line'], array('linekey'=>0,'X'=>$_GET['x'], 'Y'=>$_GET['y'], 'rX'=>$_GET['rx'],'rY'=>$_GET['ry']));
 header("Location: circuits.management.php");
}
?>
