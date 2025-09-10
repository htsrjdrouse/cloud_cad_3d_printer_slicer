
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
  $shimx = 40;
  $shimy = 30;
?>
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
  size(<?=($circuitsizex+80)?>,<?=($circuitsizey+60)?>);
  color c1 = color(102, 255, 255);
  background(100);
  fill(0,0,0);
  fill(c1);
  noStroke();
  rect(0,0,<?=($circuitsizex+80)?>,<?=($circuitsizey+60)?>);
  fill(255,255,255);
  rect(<?=$shimx?>,<?=$shimy?>,<?=$circuitsizex?>,<?=$circuitsizey?>);
  noStroke();
  fill(0,0,0);
  font = loadFont("FFScala.ttf");
  textFont(font);
  textSize(10);
  text("<?=0?>, <?=0?>",<?=(40-10)?>,<?=($circuitsizey+30+10)?>);
  text("<?=($circuitsizex)?>, <?=$circuitsizey?>",<?=$circuitsizex+14?>,<?=30-5?>);
  stroke(230,230,186);
  <? foreach($lntrace as $k=>$v){ ?>
	line(<?=$v[0]['X']+$shimx?>,<?=$circuitsizey+$shimy-$v[0]['Y']?>,<?=$v[1]['X']+$shimx?>,<?=$circuitsizey+$shimy-$v[1]['Y']?>);
  <? }?>
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
  rect(80,0,60,30);
  fill(0,0,0);
  text((mouseX-<?=$shimx?>)+" "+(<?=($circuitsizey+$shimy)?>-mouseY),90,20);
}


</script>
<canvas id="mycanvas"></canvas>
