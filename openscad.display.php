<!DOCTYPE html>
<html lang="en">
<head>
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
 <div class="col-md-5"><br><br>
  <ul>
  <b> OpenSCAD to OpenJSCAD converter</b>
  <br><br>
 <ul>
 <? include('openscad.code.editor.php');  ?>
 </ul>
  </ul>
 </div> <!-- end col -->
 <div class="col-md-5"><br><br>

 <? include('openscad.3d_display_set.inc.php');  ?>
 <? //include('3dviewer.inc.php');  ?>
 
 </div> <!-- end col -->
</div> <!-- end row -->

</body>

</html>
