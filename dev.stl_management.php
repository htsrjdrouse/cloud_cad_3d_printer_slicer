skfjlsfj
<br>
<? print_r($projectsdata[$_SESSION['selectedproject']]); ?>
<? if (isset($_SESSION['selectedproject']['jscad'])){ ?>
<? //$djdir = $projectsdata[$_SESSION['selectedproject']]['jscad']; ?>
<? $djdir = $projectsdata; ?>
<? print_r($djdir);?>
<? } else { ?>blah blah<br> <? } ?>
