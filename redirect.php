<? session_start(); ?>

<?
 $_SESSION['selectedproject'] = "labbotbuild";
 $_SESSION['openselectproject'] = 1;
 $_SESSION['openeditproject'] = 0;
 $_SESSION['openselectproject'] = 1;
 $_SESSION['opensaveproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['reallydeleteproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 1;
 $_SESSION['jscadfilename'] = "iverntech_slider_xshuttle_connect.jscad";
?>
<? header("Location: objects.json.php");?>
