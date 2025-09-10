<? session_start(); ?>
<html lang="en">
<head>
<? if (!(isset($_SESSION['labbotjson']))){
 $dir = scandir("uploads/");
 array_shift($dir);
 array_shift($dir);
 $_SESSION['objectsactive'] = $dir[0];
 $_SESSION['labbotjson'] = json_decode(file_get_contents('uploads/'.$_SESSION['objectsactive']), true);
} ?>
<? $types = ($_SESSION['labbotjson']['types']);?>
<? //$groups = ($_SESSION['labbotjson']['groups']);?>



<? //include('functionslib.php');?>
<? error_reporting(E_ALL & ~E_NOTICE);?>
<title>HTS LabBot</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/bootstrap.min.css">
  <script src="/jquery.min.js"></script>
  <script src="/bootstrap.min.js"></script>
</head>
<body>

<div class="row">
<br><br>
</div>
<div class="row">
 <div class="col-md-2"><ul>
 <a href="../objects.json.php" class="btn btn-sm btn-success" role="button" aria-pressed="true">STL Designer</a><br><br>
 <a href="slic3rconfig_management.php" class="btn btn-sm btn-danger" role="button" aria-pressed="true">Slic3r designer</a><br><br>
  </ul>
 </div>
 <div class="col-md-4">
 <br>
 <? include('objects.inc.php'); ?>
 <? include('edittargets.php'); ?>
 </div>
 <div class="col-md-4">
 <? include('target.layout.inc.php'); ?>
 </div>


 </div><!-- end row -->


</body>
</html>

