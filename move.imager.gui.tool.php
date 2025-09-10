<form action=test.objects.json.form.php method=post>
<button type="submit" name="position" class="btn-sm btn-primary">Move</button><br><br>
Move X: <input name="movex" type="text" size=6 value="<?=$movedata['x']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Y: <input name="movey" type="text" size=6 value="<?=$movedata['y']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Z: <input name="movez" type="text" size=6 value="<?=$movedata['z']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
<br><br>
Rotate X: <input name="rotatex" type="text" size=6 value="<?=$movedata['rx']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Y: <input name="rotatey" type="text" size=6 value="<?=$movedata['ry']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Z: <input name="rotatez" type="text" size=6 value="<?=$movedata['rz']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
<br><br>
Mirror X: <input type=checkbox name=mirrorx <?=$movedata['mx']?>> &nbsp;&nbsp;&nbsp; 
Y: <input type=checkbox name=mirrory <?=$movedata['my']?>> &nbsp;&nbsp;&nbsp; 
Z: <input type=checkbox name=mirrorz <?=$movedata['mz']?>> &nbsp;&nbsp;&nbsp;
Lie flat: <input type=checkbox name=lieflat <?=$movedata['lieflat']?>>
<br><br>
<? if (!isset($movedata['sx'])){ $movedata['sx'] = 1; $movedata['sy'] = 1; $movedata['sz']; } ?>
<? if (($movedata['sx'] == 0)){ $movedata['sx'] = 1; $movedata['sy'] = 1; $movedata['sz'] =1; } ?>
Scale X: <input name="scalex" type="text" size=6 value="<?=$movedata['sx']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Y: <input name="scaley" type="text" size=6 value="<?=$movedata['sy']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
 Z: <input name="scalez" type="text" size=6 value="<?=$movedata['sz']?>" style="text-align:right;font-size:12px;"/>&nbsp;&nbsp;
<br>
<!--
<pre><code>
<?//echo $_SESSION['jscadcontents'];?>
</code></pre>
-->
</form>




