<? session_start(); ?>

<?
 $_SESSION['directory'] = "openscads";
 $_SESSION['views'] = 3;
 $_SESSION['selectedproject'] = "labbotbuild";
 $_SESSION['openselectproject'] = 0;
 $_SESSION['openeditproject'] = 0;
 $_SESSION['opensaveproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['reallydeleteproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 1;
 $_SESSION['jscadfilename'] = "imagingblock_lid.jscad";
 //$_SESSION['jscadfilename'] = "iverntech_slider_xshuttle_connect.jscad";
?>
<? //header("Location: example.objects.json.php");?>
<? header("Location: index.php");?>
