
<? if(isset($_POST['adjustbedsize'])){
  $_SESSION['circuitsize']['circuitsizex'] = $_POST['circuitsizex'];
  $_SESSION['circuitsize']['circuitsizey'] = $_POST['circuitsizey'];
  file_put_contents('circuit.size.json', json_encode($_SESSION['circuitsize']));
} ?>
<?
 $_SESSION['circuitsize'] = json_decode(file_get_contents('circuit.size.json'), true);
?>

<!--
<br>
<form action=<?=$_SERVER['PHP_SELF']?> method=post>
<b>Adjust bed size 
X<input type=text name=circuitsizex value="<?=$_SESSION['circuitsize']['circuitsizex']?>" size=5 style="text-align:right;font-size:10px;">
Y<input type=text name=circuitsizey value="<?=$_SESSION['circuitsize']['circuitsizey']?>" size=5 style="text-align:right;font-size:10px;">
<button type="submit" name=adjustbedsize value="Adjust bed size" class="btn btn-success btn-sm">Adjust bedsize</button><br>
</b>
</form>
-->

<?
  $circuitsizex=($_SESSION['circuitsize']['circuitx']);
  $circuitsizey=($_SESSION['circuitsize']['circuity']);
  
  $circuitsizex = (max($xry)-min($xry))*4;
  $circuitsizey = (max($yry)-min($yry))*4;
  $shimx = 0;
  $shimy = 20;
?>
<br>


<br>
<br>

  <?// $mqttset = array("divmsg"=>"procmessages","topic"=>"proctemp","client"=>"client5","x"=>"x","y"=>"y")?>
  <?// include('mqtt.proc.js.inc.php'); ?> 
<script src="/processing.min.js"></script>
<script type="text/processing" data-processing-target="mycanvas">

// Global variables
float radius = 50.0;
//int X, Y;
//int nX, nY;
int delay = 16;


PImage bg;
PFont f;
int a;
boolean overRightButton = false;
boolean reGrid = false;
boolean setSearcharea = false;
boolean overLeftButton = false;
boolean bover = false;
boolean locked = false;
float bdifx = 0.0;
float bdify = 0.0;
int px,py,rowdiam,columndiam;
int rectX, rectY;      // Position of square button
int circleX, circleY;  // Position of circle button
int rectSize = 60;     // Diameter of rect
int circleSize = 60;   // Diameter of circle
int nX, nY;
int X, Y;
color rectColor, circleColor, baseColor;
color rectHighlight, circleHighlight;
color currentColor;
boolean rectOver = false;
boolean clrectOver = false;
boolean circleOver = false;
PFont font;
String spots;
String st;
ArrayList spotlist;
int flag = 0;
color currentcolor;
spotlistch = new ArrayList();
String[] sa1;
String[] xpos;
String[] ypos;
String[] shapex;
String[] shapey;
String[] shape;
String[] wellrowsp;
String[] wellcolumnsp;


void setup()
{
  frameRate( 15 );
  size(<?=($circuitsizex)?>,<?=($circuitsizey+$shimy)?>);
  color c1 = color(102, 255, 255);
  background(100);
  fill(0,0,0);
  fill(c1);
  noStroke();
  rect(0,0,<?=($circuitsizex)?>,<?=($circuitsizey)?>);
  fill(255,255,255);
  rect(<?=$shimx?>,<?=$shimy?>,<?=$circuitsizex+$shimx?>,<?=$circuitsizey+($shimy/4)?>);
  noStroke();
  fill(0,0,0);
  font = loadFont("FFScala.ttf");
  textFont(font);
  textSize(10);
  text("<?=0?>, <?=0?>",<?=($shimx-10)?>,<?=($circuitsizey+30+10)?>);
  <? foreach($lntrace as $k=>$v){ ?>
        stroke(230,230,186);
	line(<?=($v[0]['X']-min($xry))*4?>,<?=$circuitsizey+$shimy-($v[0]['Y']-min($yry))*4?>,<?=($v[1]['X']-min($xry))*4?>,<?=$circuitsizey+$shimy-($v[1]['Y']-min($yry))*4?>);
        stroke(53,123,206);
	ellipse(<?=($v[0]['X']-min($xry))*4?>,<?=$circuitsizey+$shimy-($v[0]['Y']-min($yry))*4?>,1,1);
	ellipse(<?=($v[1]['X']-min($xry))*4?>,<?=$circuitsizey+$shimy-($v[1]['Y']-min($yry))*4?>,1,1);
  <? }?>



<? if(isset($_SESSION['holelist'])){ ?>
<? foreach($_SESSION['holelist'] as $hk=>$hv) {?>
 <? if((isset($_GET['type'])) and ($_GET['type'] == "highlightholes") and ($_GET['key'] == $hv['holename'])){ ?>
   stroke(255, 127, 80);
   fill(255, 127, 80);
 <? } else { ?>
  stroke(30,30,86);
  fill(30,30,86);
<? } ?>
<?
  for($y=1;$y<=$hv['row'];$y++){
  for($x=1;$x<=$hv['column'];$x++){
?>
 ellipse(<?=floatval($hv['rX'])-(10)+(($x)*floatval($hv['columnsp']))*4?>,<?=floatval($hv['rY'])+(10)-(($y)*floatval($hv['rowsp']))*4?>,<?=floatval($hv['diameter'])*4?>,<?=floatval($hv['diameter'])*4?>);
<?
  }
  }
?>
<? } ?>
<? } ?>  

<? if(isset($_SESSION['linelist'])){ ?>
  stroke(30,30,86);
<? 
  foreach($_SESSION['linelist'] as $kl=>$line){
  foreach($line as $k=>$v){
 if (($k > 0)){
?>
  <? if((isset($_GET['type'])) and ($_GET['type'] == "highlighttrace") and ($_GET['key'] == $kl)){ ?>
   stroke(255, 127, 80);
  <? } else { ?> 
  stroke(30,30,86);
  <? } ?>
  line(<?=$v['rX']?>,<?=$v['rY']?>,<?=$line[$k-1]['rX']?>,<?=$line[$k-1]['rY']?>);
<?
 }
  }
  }
 } ?>

<? if(isset($_SESSION['line'])){ ?>
  stroke(30,30,86);
<? foreach($_SESSION['line'] as $k=>$v){
 if (($k > 0)){
?>
	line(<?=$v['rX']?>,<?=$v['rY']?>,<?=$_SESSION['line'][$k-1]['rX']?>,<?=$_SESSION['line'][$k-1]['rY']?>);
<?
 }
  }
 } ?>


}

void draw(){  
 update(mouseX, mouseY);
}

void mouseMoved(){
  nX = mouseX;
  nY = mouseY;  
  //println(nX+","+nY);
  textFont(font);
  fill(230, 230, 250);
  noStroke();
  rect(80,0,60+30,20);
  fill(0,0,0);
  text((round(mouseX/4+<?=min($xry)?>))+" "+(round(<?=($circuitsizey/4+$shimy/4+min($yry))?>-mouseY/4)),90,15);
  noStroke();
  fill(230, 230, 250);
  rect(80+100,0,60+30,20);
  fill(0,0,0);
  text(((mouseX))+" "+(mouseY),90+100,15);
}

void mousePressed(){
<? if (isset($_SESSION['setholeposition']) and ($_SESSION['setholeposition'] == 1)){  ?>
	link("circuit.holes.move.php?tar="+<?=$_SESSION['holes']['holename']?>+"&x="+(mouseX/4+<?=min($xry)?>)+"&y="+(<?=($circuitsizey/4+$shimy/4+min($yry))?>-mouseY/4)+"&rx="+mouseX+"&ry="+mouseY);
<? } ?>

<? if (isset($_SESSION['settraceposition']) and ($_SESSION['settraceposition'] == 1)){  ?>
  link("circuit.holes.move.php?line=ll&x="+(mouseX/4+<?=min($xry)?>)+"&y="+(<?=($circuitsizey/4+$shimy/4+min($yry))?>-mouseY/4+"&rx="+mouseX+"&ry="+mouseY));
<? } ?>
}
</script>
<canvas id="mycanvas"></canvas>
