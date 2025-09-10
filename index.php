<? session_start(); ?>
<br>
<? if(isset($_SESSION['opensaveproject'])){ ?>
<?

/*
$filepath = "uploads/".$_SESSION['jscadfilename'];
if (!file_exists($filepath)){ $_SESSION['jscadfilename'] = "iverntech_slider_xshuttle_connect.jscad"; }
*/
if (isset($_SESSION['jscadfilename']) and (!isset($_SESSION['jscadcontents']))){
  $f = fopen($_SESSION['directory']."/".$_SESSION['jscadfilename'],"r");
  $_SESSION['jscadcontents'] = fread($f,filesize($_SESSION['directory']."/".$_SESSION['jscadfilename']));
}
?>
<? include('jscadlib.php') ?>
<? if (!isset($_SESSION['views'])){$_SESSION['views'] = 1; }?>
<? if(isset($_POST['selectSTL'])){
$_SESSION['views'] = 1; 
} ?>
<? if(isset($_POST['selecteditor'])){
$_SESSION['views'] = 0; 
} ?>
<? if(isset($_POST['selectslice'])){
$_SESSION['views'] = 2; 
} ?>
<? if(isset($_POST['selectOpenSCAD'])){
 $_SESSION['views'] = 3; 
 $_SESSION['jscadfilename'] = "imagingblock_lid.jscad";
} ?>

<? include('uploadfile.php'); ?>


<? //header("Refresh:0");?>
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

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/index.php">HTS Resources</a>
            <!-- Add navigation items here -->
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Online CAD Designer</h1>
            <p class="lead">Supporting 3D Design for Printing</p>
        </div>
    </header>




<!-- Narrative Section -->
<section id="narrative" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
			<h2>Welcome to HTS Resources' Cloud-Based CAD Tool</h2>
                <div class="card">
                    <div class="card-body">
			<p class="card-text">
<p>Revolutionize your 3D printing experience with our online CAD tool. Powered by script-driven technologies like OpenSCAD and JSCAD, this innovative platform allows you to create, visualize, and customize 3D shapes without installing any software.</p>
<p>Key Features:</p>
<p>
<li> Instant Visualization: See your designs come to life in real-time</li>
<li> No Installation Required: Access powerful CAD tools directly from your browser</li>
<li> Customizable Solutions: We tailor our software to meet your specific needs</li>
<li> Seamless Integration: From design to 3D printing, all in one place</li>
</p>
<p>
Whether you're looking to prototype a single part or set up entire 3D printer workstations, HTS Resources is your partner in bringing ideas to life. Our team of experts can customize this tool to address your unique requirements, ensuring a smooth workflow from concept to creation.
Experience the future of CAD design – try our cloud-based tool today and transform the way you approach 3D printing.
</p>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<div class="row">
 <div class="col-md-5"><br><br>
 <ul>
  <h3>CAD development tool for 3-D printing</h3>
 </ul>

</div>
 <div class="col-md-6"><br><br>
 </div>
</div>
<div class="row">
 <div class="col-md-4">
<ul>
<br> 


<? include('example.display.project.php'); ?>




<? if($_SESSION['views'] == 2) { ?>
<form action=example.objects.json.php method=post>
  <button type="submit" name="selectSTL" class="btn-sm btn-primary">Manage STL</button> 
  <!--<button type="submit" name="selectOpenSCAD" class="btn-sm btn-success">Manage OpenSCAD</button> -->
  <button type="submit" name="selecteditor" class="btn-sm btn-warning">Code editor</button> 
</form><br>
<? include('slicer_management.php');  ?>
<? }?>

<? if($_SESSION['views'] == 3) { ?>
<!--
<form action=example.objects.json.php method=post>
  <button type="submit" name="selectSTL" class="btn-sm btn-primary">Manage STL</button> 
</form><br>
-->
<? include('example.display.openscad_management.php'); ?>
<? }?>



</div>


<div class="col-md-8">
<!-- 3d viewer -->
 <!--<div class="col-md-1"></div> -->
<? include('example.3dviewer.caller.inc.php'); ?>

</div>

<div class="col-md-1">
</div>
</div> <!--end  row-->

<!-- code viewer -->
<div class="row">
 <div class="col-md-3">
 <ul>
<? if (isset($_SESSION['scadview']) and ($_SESSION['scadview'] == 1)){ ?>
 <? include('ref.openjscad.inc.php'); ?>
<? } ?>
<? if (isset($_SESSION['scadview']) and ($_SESSION['scadview'] == 0)){ ?>
<a href="https://openscad.org/cheatsheet/" target=_new>OpenSCAD cheat sheet</a>
<? } ?>
 </ul>
</div>
 <div class="col-md-8">
<? if(($_SESSION['views'] == 3) and isset($_SESSION['objectsactive'])){  include('example.openscad.code.editor.php'); }?>
 <div class="col-md-1">
</div>
<? //if (isset($_SESSION['jscadfilename'])){ include('code.editor.php'); } ?><br>
 </div>
</div>

</body>
</html>

<? } else { ?>
<? header("Location: example.redirect.php");?>
<? } ?>

