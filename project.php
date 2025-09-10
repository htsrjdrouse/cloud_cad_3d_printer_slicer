<? if(!isset($_SESSION['views'])){ $_SESSION['views'] = 0; } ?>
<? if($_SESSION['views'] == 0) { ?>
<? include('select.project.inc.php');?>
<? if (isset($_SESSION['selectedproject'])){ ?>
<br>
<form action=objects.json.php method=post>
  <button type="submit" name="selectSTL" class="btn-sm btn-primary">Manage STL</button> 
  <button type="submit" name="selectOpenSCAD" class="btn-sm btn-success">Manage OpenSCAD</button> 
  <button type="submit" name="selectslice" class="btn-sm btn-danger">Slice STL</button> 
</form><br>
<? } ?>
<hr>
<!--Project List -->
<? //include('edit.jscad.inc.php');?>
<br><br></b>
<? if (isset($_SESSION['jscadfilename'])){ include('ref.openjscad.inc.php');} ?>
<? }?> 
<? if($_SESSION['views'] == 1) { ?>
<? include('select.project.inc.php');?><br>
<form action=objects.json.php method=post>
  <!--<button type="submit" name="selectOpenSCAD" class="btn-sm btn-success">Manage OpenSCAD</button> -->
  <button type="submit" name="selecteditor" class="btn-sm btn-warning">Code editor</button> 
  <button type="submit" name="selectslice" class="btn-sm btn-danger">Slice STL</button> 
</form><br>
<!--STL management system -->

<? ///include('dev.stl_management.php'); ?> 
<? include('stl_management.php'); ?> 
<? } ?>



