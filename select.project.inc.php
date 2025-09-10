<? if (isset($_POST['opensaveproject'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['opensaveproject'] = 1;
 $_SESSION['openselectproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['reallydeleteproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
} ?>
<? if (isset($_POST['openselectproject'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['openselectproject'] = 1;
 $_SESSION['opensaveproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['reallydeleteproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
} ?>
<? if (isset($_POST['saveproject'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['opensaveproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
 $projectsdata = json_decode(file_get_contents('projects.json'), true);
   if (!isset($projectsdata['projlist'])){ $projectsdata['projlist'] = array(); }
   if (in_array($_POST['projectname'],$projectsdata['projlist'])){
     $projectsdata[$_POST['projectname']]['comment'] = $_POST['projectcomment'];
   } else {
     $pjn = str_replace(" ", "", $_POST['projectname']);
     array_push($projectsdata['projlist'], $pjn);
     $projectsdata[$pjn]['comment'] = $_POST['projectcomment'];
   }
   file_put_contents('projects.json', json_encode($projectsdata));
 }?>
<? if (isset($_POST['editproject'])){ 
   $projectsdata = json_decode(file_get_contents('projects.json'), true);
   $projectsdata[$_SESSION['selectedproject']]['comment'] = $_POST['projectcomment'];
   file_put_contents('projects.json', json_encode($projectsdata));
 }?>
<? if (isset($_POST['openeditproject'])){ 
 $_SESSION['openeditproject'] = 1;
 $_SESSION['opensaveproject'] = 0;
 $_SESSION['openselectproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['reallydeleteproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
 }?>
<? if (isset($_POST['deleteproject'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['reallydeleteproject'] = 1;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['openselectproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
 $_SESSION['selectedproject'] = htmlentities($_POST["projectlist"]);
}?>
<? if (isset($_POST['reallydeleteproject'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['reallydeleteproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['openselectproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
 echo "project ".$_SESSION['selectedproject']." will be deleted<br>";;
 $projectsdata = json_decode(file_get_contents('projects.json'), true); 
 $keep = array();
 foreach($projectsdata['projlist'] as $p){
  if ($_SESSION['selectedproject'] != $p){
   if (is_array($projectsdata[$p]['jscad'])){
    foreach($projectsdata[$p]['jscad'] as $ppp){
      array_push($keep,$ppp);
    }
   }
  }
 }
 $projlist = array();
 foreach($projectsdata[$_SESSION['selectedproject']]['jscad'] as $pp){
	 if (!in_array($pp,$keep)){
	   //echo "delete project jscad uploads/".$pp.'<br>';
	   unlink("uploads/".$pp);
	   if (file_exists("rendered/rendered_".preg_replace("/jscad$/", "stl", $pp))){ 
		   //echo "delete rendered/rendered_".preg_replace("/jscad$/", "stl", $pp).'<br>';
		   unlink("rendered/rendered_".preg_replace("/jscad$/", "stl", $pp));
	   }
	   if (file_exists("rendered/gcodes/rendered_".preg_replace("/jscad$/", "gcode", $pp))){ 
		   //echo "delete rendered/gcodes/rendered_".preg_replace("/jscad$/", "gcode", $pp).'<br>';
		   unlink("rendered/gcodes/rendered_".preg_replace("/jscad$/", "gcode", $pp));
	   }
	 } 
 }
 $key = array_search($_SESSION['selectedproject'],$projectsdata['projlist']);
 unset($projectsdata['projlist'][$key]);
 unset($projectsdata[$_SESSION['selectedproject']]);
 unset($_SESSION['selectedproject']);
 file_put_contents('projects.json', json_encode($projectsdata));
}?>
<? if (isset($_POST['keeproject'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['deleteproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['reallydeleteproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
}?>
<? if (isset($_POST['selectproject'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['openselectproject'] = 0;
 $_SESSION['opencopyfiles'] = 0;
 $_SESSION['selectedprojectdetails'] = 1;
 //$_SESSION['selectedproject'] = $_POST['projectlist'];
 $_SESSION['selectedproject'] = str_replace(" ", "&nbsp;", $_POST['projectlist']); //$_POST["projectlist"];
 }?>
<? if (isset($_POST['opencopyfiles'])){ 
 $_SESSION['openeditproject'] = 0;
 $_SESSION['openselectproject'] = 0;
 $_SESSION['selectedprojectdetails'] = 0;
 $_SESSION['opencopyfiles'] = 1;
 $_SESSION['selectedproject'] = $_POST['projectlist'];
 }?>
<? if (isset($_POST['copyfiles'])){ 
  $projectsdata = json_decode(file_get_contents('projects.json'), true); 
  if(!isset($projectsdata[$_POST['toprojectlist']]['jscad'])){ $projectsdata[$_POST['toprojectlist']]['jscad'] = array(); }
  $tory = $projectsdata[$_POST['toprojectlist']]['jscad'];
  foreach ($_POST['jscadlist'] as $key=>&$val){
   if (!in_array($val, $tory)){ array_push($projectsdata[$_POST['toprojectlist']]['jscad'], $val); }
  }
   file_put_contents('projects.json', json_encode($projectsdata));
 } ?>

<? if(isset($_SESSION['selectedproject'])){ ?>
<b>Project: <?=$_SESSION['selectedproject']?><br>
<? } ?>
<br>
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<? if(!$_SESSION['opensaveproject']){ ?><button type="submit" name="opensaveproject" class="btn-sm btn-success">Create project</button>&nbsp;&nbsp;<? } ?>
<? if(!$_SESSION['openselectproject']){ ?><button type="submit" name="openselectproject" class="btn-sm btn-primary">Select project</button><? } ?>
<? if(($_SESSION['views'] != 3) and (isset($_SESSION['selectedproject']))){ ?>  <button type="submit" name="selectOpenSCAD" class="btn-sm btn-success">Manage OpenSCAD</button><? } ?>

</form>
<br>
<?  if ($_SESSION['opensaveproject'] == 1){ ?>
<h4>Save project</h4>
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<button type="submit" name="saveproject" class="btn-sm btn-success">Save project</button>
<input type=text name="projectname" size="12"><br>
<textarea name=projectcomment rows="3" cols="23"></textarea>
</form>
<? } ?> 
<?  if ($_SESSION['openeditproject'] == 1){ ?>
<h4>Edit project</h4>
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<button type="submit" name="editproject" class="btn-sm btn-success">Save project</button>
<b><?=htmlentities($_SESSION["selectedproject"])?></b> <br>
<? $projectsdata = json_decode(file_get_contents('projects.json'), true); ?>
<textarea name=projectcomment rows="3" cols="23"><?=$projectsdata[$_SESSION['selectedproject']]['comment']?></textarea>
</form>
<? } ?> 


<?  if ($_SESSION['openselectproject'] == 1){ ?>
<div class="row">
<? $projectsdata = json_decode(file_get_contents('projects.json'), true); ?>
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<div class="col-sm-4">
<h4>Select project</h4>
<? if (count($projectsdata['projlist']) > 10){ $size = 10; } else {$size = count($projectsdata['projlist']); } ?>
<select class="form-control form-control-sm" name="projectlist" size=<?=$size?>>
<? foreach($projectsdata['projlist'] as $key=>&$val){?>
       <option value=<?=$val?>><?=$val?></option>
<? } ?>
</select>
</div>
<div class="col-sm-4">
<button type="submit" name="selectproject" class="btn-sm btn-success">Select project</button><br><br>
<button type="submit" name="opencopyfiles" class="btn-sm btn-warning">Copy files</button><br><br>
<button type="submit" name="openeditproject" class="btn-sm btn-primary">Edit project</button><br><br>
<button type="submit" name="deleteproject" class="btn-sm btn-danger">Delete project</button><br>
</div>
</form>
</div>
<? } ?> 
<?  if ($_SESSION['opencopyfiles'] == 1){ ?>

<? if(!isset($_SESSION['selectedproject'])){?>
You need to select a project first<br>
<? } else {  ?>

<div class="row">
<? $projectsdata = json_decode(file_get_contents('projects.json'), true); ?>
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<div class="col-sm-8">
<h4>Select project</h4>
<button type="submit" name="copyfiles" class="btn-sm btn-primary">Copy files</button><br><br>
<b><?=$_SESSION['selectedproject']?><b><br>
<? if(isset($_SESSION['selectedproject'])){?>
<? if((isset($projectsdata[$_SESSION['selectedproject']]['jscad'])) and (count($projectsdata[$_SESSION['selectedproject']]['jscad'])>0)){ ?>
<? $djdir = $projectsdata[$_SESSION['selectedproject']]['jscad']; ?>
<? $size = count($projectsdata[$_SESSION['selectedproject']]['jscad']);?>
<?
  if (($size) > 10){ $size=10; }
?>
<? $_SESSION['jscadlist'] = $djdir;?>
 <select class="form-control form-control-sm" name="jscadlist[]" size=<?=$size?> multiple>
  <? foreach($djdir as $key => &$val){ ?>
  <? if (!preg_match('/^\d\d\d\d\d\d\d\d\d\d.jscad$/', $val)){ ?>
  <? if ($val == $_SESSION['jscadfilename']) { ?> 
   <option value=<?=$val?> selected><?=$val?></option>
  <? } else { ?>
   <option value=<?=$val?>><?=$val?></option>
  <? } ?>
 <? } ?>
 <? } ?>
 </select>
<br>
<? } ?>
<? } ?>
</div>
<div class="col-sm-4">
<b>Recipient project</b>
<? if (count($projectsdata['projlist']) > 10){ $size = 10; } else {$size = count($projectsdata['projlist'])-1; } ?>
<select class="form-control form-control-sm" name="toprojectlist" size=<?=$size?>>
<? foreach($projectsdata['projlist'] as $key=>&$val){?>
   <? if($val != $_SESSION['selectedproject']) { ?>
       <option value=<?=$val?>><?=$val?></option>
   <? } ?>
<? } ?>
</select>
</div>
</form>
</div>
<? } ?> 
<? } ?> 
<?  if ($_SESSION['reallydeleteproject'] == 1){ ?>
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<b>Really delete project <?$_SESSION['selectedproject']?>? <br>
<button type="submit" name="reallydeleteproject" class="btn-sm btn-danger">Really delete <?=$_SESSION['selectedproject']?></button>
&nbsp;&nbsp;
<button type="submit" name="keeproject" class="btn-sm btn-success">Keep <?=$_SESSION['selectedproject']?></button>
<br><br>
</b>
</form>
<? } ?> 
<?  if ($_SESSION['selectedprojectdetails'] == 1){ ?>
<? $projectsdata = json_decode(file_get_contents('projects.json'), true); ?>
 <?=$projectsdata[$_SESSION['selectedproject']]['comment']?>

<? include('select.jscad.inc.php');?>
<? } ?> 







