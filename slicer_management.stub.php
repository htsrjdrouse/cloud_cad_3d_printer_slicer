<div class="col-sm-7">
<form action="slic3r/slic3r_varcatch.php" method="post">

<b>Select Slic3r configuration</b><br>
<? if(!isset($_SESSION['configactive'])){?> <font color=red>Please select configuration file</font><?} ?>
<?=$_SESSION['configactive']?>
<br>
 <? $ddir = $configjson['file'];?>
 <select class="form-control form-control-sm" name="configlist" size=<?=$size?>>
  <? foreach($ddir as $key => &$val){ ?>
  <? if ($val == $_SESSION['configactive']) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
  <? } ?>
 </select>



</form>

</div>
