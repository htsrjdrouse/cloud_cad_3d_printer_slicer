<? $size =count($zlevels); if ($size > 10){ $size=10; }?>
<? $_SESSION['zlevels'] = $zlevels; ?>
<form action=slic3r/slic3r_varcatch.php method=post>
<input type=hidden name=zlevels[] value="<?=$zlevels?>">
 <!--<a href="slic3r/circuits.management.php" class="btn btn-primary btn-sm" role="button" aria-pressed="true">View single layer</a><br>-->
<br>
  <button type="submit" name="selectlayers" class="btn-sm btn-danger">Display selected layers</button>
  <button type="submit" name="downloadgcode" class="btn-sm btn-success">Download gcode</button>
<br>
 <select class="form-control form-control-sm" name="gcodelayers[]" multiple size=<?=$size?>>
<? 
$key = 0;
foreach($zlevels as $key => &$val){?>
       <option value=<?=$key?>><?=$key+1?> -- Z level: <?=$val?></option>
<? } ?>
 </select>
</form>
