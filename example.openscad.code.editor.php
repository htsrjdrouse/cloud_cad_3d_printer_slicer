<style type="text/css" media="screen">

	.ace_editor {
		border: 1px solid lightgray;
		margin: auto;
		height: 200px;
		width: 80%;
	}
	.scrollmargin {
		height: 80px;
        text-align: center;
	}
    </style>

<style>
textarea {
  width: 100%;
}
</style>

<form action="example.openscad.objects.json.form.php" method="post" >
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js"></script>-->
<!--<script src="../src/ace.js"></script>-->
<?
//$contents =  $_SESSION['jscadcontents'];
$jscadfile = $_SESSION['jscadfilename'];
//echo $contents;
//$_SESSION['oscadfilename'] = "arducam_case_rtPCR.scad";
///$_SESSION['jscadfilename'] = "arducam_case_rtPCR.jscad";
//$f = fopen("openscads/".$_SESSION['oscadfilename'],"r");

$dir = scandir("openscads/");
$jdir = $dir;
/*
$ddir = array(); 
foreach($dir as $dd){ 
 if (preg_match("/^.*\.jscad$|\.JSCAD$/", $dd)){ array_push($ddir, $dd); }
} 
 */

$dir = "openscads";
if (!array_search($jscadfile,$jdir)){
	$_SESSION['scadview'] = 1;
	$dir = "uploads";
} 

if (!isset($_SESSION['scadview'])) {$_SESSION['scadview'] = 0;}
if ($_SESSION['scadview'] == 0){
 $f = fopen($dir."/".preg_replace("/\.jscad/",".scad",$jscadfile),"r");
 $_SESSION['oscadcontents'] = fread($f,filesize($dir."/".preg_replace("/\.jscad/",".scad",$jscadfile)));
 $oscadfile = $jscadfile;
 $ocontents =  $_SESSION['oscadcontents'];
} else {
 $f = fopen($dir."/".$jscadfile,"r");
 $_SESSION['oscadcontents'] = fread($f,filesize($dir."/".$jscadfile));
 $oscadfile = $jscadfile;
 $ocontents =  $_SESSION['oscadcontents'];
}
$numcnt = count(preg_split("/\n/", $ocontents));
if ($numcnt > 25){$numcnt = 25;}
?>


<? if ($_SESSION['scadview'] == 0){ ?>
<!--<input type=submit>-->
<input type=text name="filename" value="<?=preg_replace("/\.jscad/", ".scad", $jscadfile)?>" size=30>
<!--&nbsp;&nbsp;<button type="submit" name="savescad" class="btn-sm btn-success">Save</button>-->
&nbsp;&nbsp;<button type="submit" name="openjscad" class="btn-sm btn-warning">JSCAD</button><br>
<? } else { ?>
<!--<input type=submit>-->
<input type=text name="filename" value="<?=$jscadfile?>" size=30>
<!--&nbsp;&nbsp;<button type="submit" name="savejscad" class="btn-sm btn-success">Save</button>-->
&nbsp;&nbsp;<button type="submit" name="openscad" class="btn-sm btn-warning">OpenSCAD</button><br>
<? } ?>

<br>
<script src="/ace-builds/src/ace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>
<textarea name="macrofiledata" data-editor="xml" data-gutter="1" rows="<?=$numcnt?>">
<?=$ocontents;?>
</textarea>

</form>
	<script>
// Hook up ACE editor to all textareas with data-editor attribute
$(function() {
  $('textarea[data-editor]').each(function() {
    var textarea = $(this);
    var mode = textarea.data('editor');
    var editDiv = $('<div>', {
      position: 'absolute',
      width: textarea.width(),
      height: textarea.height(),
      'class': textarea.attr('class')
    }).insertBefore(textarea);
    textarea.css('display', 'none');
    var editor = ace.edit(editDiv[0]);
    editor.renderer.setShowGutter(textarea.data('gutter'));
    editor.getSession().setValue(textarea.val());
    editor.setKeyboardHandler("ace/keyboard/vscode");
    editor.setAutoScrollEditorIntoView(true);
    editor.getSession().setMode("ace/mode/scad");
    editor.setTheme("ace/theme/tomorrow");
    // copy back to textarea on form submit...
    textarea.closest('form').submit(function() {
      textarea.val(editor.getSession().getValue());
    })
  });
});
	</script>

