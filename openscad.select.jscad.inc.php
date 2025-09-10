<? if(isset($_SESSION['selectedproject'])){?>
<br>
<? if((isset($projectsdata[$_SESSION['selectedproject']]['jscad'])) and (count($projectsdata[$_SESSION['selectedproject']]['jscad'])>0)){ ?>

<br>
<h4>Select JSCAD file:</h4>
<br>
<? if((isset($_GET['oid']))and($_GET['oid']=="download")){?>
<a href="openscads/rendered_<?=preg_replace("/.jscad$/", ".stl",$_SESSION['jscadfilename'])?>" class="btn btn-sm btn-success" role="button" aria-pressed="true">Download Rendered STL</a><br>
<? } ?>
<br>
<? $djdir = $projectsdata[$_SESSION['selectedproject']]['jscad']; ?>
<? $size = count($projectsdata[$_SESSION['selectedproject']]['jscad']);?>
<?
  if (($size) > 10){ $size=10; }
?>
<? $_SESSION['jscadlist'] = $djdir;?>
<form action=openscad.objects.json.form.php method=post>
 <select class="form-control form-control-sm" name="objectlist" size=<?=$size?>>
  <? foreach($djdir as $key => &$val){ ?>
  <? if (!preg_match('/^\d\d\d\d\d\d\d\d\d\d.jscad$/', $val)){ ?>
  <? if ($val == $_SESSION['jscadfilename']) { ?> 
   <option value=<?=$key?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$key?>><?=$val?></option>
  <? } ?>
 <? } ?>
 <? } ?>
 </select>
<br>
  <button type="submit" name="selectjscad" class="btn-sm btn-primary">Select file</button> 
&nbsp;
&nbsp;
 <button type="submit" name="deletejscad" class="btn-sm btn-danger">Delete file</button>
&nbsp;
&nbsp;
<? if(isset($_SESSION['jscadfilename'])){ ?>
<button type="submit" name="renderfromjscad" class="btn-sm btn-success">Render to STL</button>
<? } ?>
</form>
<? } ?>
<? } ?>


