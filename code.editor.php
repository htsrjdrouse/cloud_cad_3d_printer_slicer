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

<form action="objects.json.form.php" method="post" >
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js"></script>-->
<!--<script src="../src/ace.js"></script>-->
<? 
$contents =  $_SESSION['jscadcontents'];
$jscadfile = $_SESSION['jscadfilename'];
$numcnt = count(preg_split("/\n/", $contents));
if ($numcnt > 25){$numcnt = 25;}
?>
<!--<input type=submit>-->
<input type=text name="filename" value="<?=$jscadfile?>" size=30><br>
<button type="submit" name="savefile" class="btn-sm btn-success">Save file</button><br>
<br>
<script src="/ace-builds/src/ace.js"></script>
<textarea name="macrofiledata" data-editor="xml" data-gutter="1" rows="<?=$numcnt?>">
<?=$contents;?>
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

