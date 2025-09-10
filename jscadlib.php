<?
function readgcodestats($filenm){
$fll = "rendered/gcodes/rendered_".preg_replace("/.stl$/", ".txt",$filenm);
$file = new SplFileObject($fll);
$file->seek(PHP_INT_MAX); // cheap trick to seek to EoF
$total_lines = $file->key(); // last line number

// output the last twenty lines
$reader = new LimitIterator($file, $total_lines - 9);
$lns = array();
$ct = 0;
foreach ($reader as $line) {
    array_push($lns,preg_replace("/\n/", "", $line));
    //echo $ct.' '.$line.'<br>'; // includes newlines
    $ct = $ct +1;
}
/*
; filament used [mm] = 7317.64
; filament used [cm3] = 17.60
; total filament used [g] = 0.00
; total filament cost = 0.00
; estimated printing time (normal mode) = 1h 7m 6s
; estimated printing time (silent mode) = 1h 8m 44s
 */

$stats = array(
 "layercount"=>preg_replace("/layer count /", "", $lns[3]),
 "filepos"=>$lns[1],
 "zlevels"=>$lns[2],
 "filamentvol"=>preg_replace("/filament vol /", "", $lns[4]),
 "filamentlength"=>preg_replace("/filament length /", "", $lns[5]),
 "time"=>preg_replace("/time /", "", $lns[7]),
);
/*
echo 'layercount '.$stats['layercount'].'<br>';
echo 'zlevels <br>';
print_r($stats['zlevels']);
echo '<br>';
echo "file pos<br>";
print_r($stats['filepos']);
echo '<br>';
echo 'filament volume '.$stats['filamentvol'].' cm3<br>';
echo 'filament length '.$stats['filamentlength'].' mm <br>';
echo "<br><br>";
 */
return $stats;
}







function scangcode($filenm){
$fl = "../rendered/gcodes/rendered_".preg_replace("/.stl$/", ".gcode",$filenm);
$fll = "../rendered/gcodes/rendered_".preg_replace("/.stl$/", ".txt",$filenm);
$lry = array();
$layers = array();
$dfile = fopen($fll, "w"); 
$xcoord = array();
$ycoord = array();
$layerstats = array();
$ct = 0;
$tx = array();
$ty = array();
$ly = "";
$tsec = 0;
$lyct = 0;
$chrcnt = 0;
$chrcntstr = "";
fwrite($dfile, "Layer num: ".$lyct.PHP_EOL);
if ($file = fopen($fl, "r")) {
    while(!feof($file)) {
	    $line = fgets($file);
	    $chrcnt = $chrcnt + strlen($line);
	    if (!preg_match("/^.*AFTER_LAYER_CHANGE.*$/", $line)){
    	      array_push($layers, $line);
	      if(preg_match("/^G1.*F.*/", $line)){
	          preg_match("/^G1.*F(.*)$/", $line,$aa);
		  $feed = preg_replace("/;.*/", "", $aa[1]);
	      }
	      if(preg_match("/^G1.*X.*Y.*E.*/", $line)){
	       preg_match("/^G1.*X(.*)Y(.*) .*$/", $line,$aa);
	       array_push($xcoord,floatval($aa[1]));
	       array_push($tx,$aa[1]);
	       array_push($ycoord,floatval($aa[2]));
	       array_push($ty,$aa[2]);
	       $ct = $ct + 1;
	       if ($ct == 2){ 
	        $ly = $ly."bx".$tx[0]."ex".$tx[1]."by".$ty[0]."ey".$ty[1]."f".$feed.PHP_EOL;
                $len = sqrt(pow((floatval($tx[0])-floatval($tx[1])),2)+pow((floatval($ty[0])-floatval($ty[1])),2));
		$sec = $len / (intval($feed)*0.0167);
		$tsec = $tsec + $sec;
	        $ct = 0; 
		$tx = array();
		$ty = array();
	       }
	      }
	    } else {
		    if (preg_match("/;AFTER_LAYER_CHANGE .*/", $line)){
		     preg_match("/;AFTER_LAYER_CHANGE (.*)$/", $line, $ag);
		     $prevlayers = $layers;
		     $zstring = $zstring.round($ag[1],3).",";
		     $chrcntstr = $chrcntstr.$chrcnt.",";
		    }
		    if (count($xcoord)>0){
		     $lyct = $lyct + 1;
		     fwrite($dfile, "Layer num: ".($lyct).PHP_EOL);
		     fwrite($dfile,$ly);
		    }
		    $ly = "";
		    $layers = array();
		    array_push($layers, $line);
	    }
    }
    $chrcntstr = $chrcntstr.$chrcnt.",";
    if (count($xcoord)>0){
      fwrite($dfile, "Layer num: ".($lyct+1).PHP_EOL);
      fwrite($dfile,$ly);
    }
    array_push($lry, $layers);
    $layers = array();
    fclose($file);
}







foreach($prevlayers as $ll){
     if (preg_match("/^; filament used = .*mm.*/", $ll)){
		preg_match("/^; filament used = (.*)mm.*/",$ll, $av);
 		$filvol = $av[1];
     }
     if (preg_match("/^; filament used = .*g/", $ll)){
		preg_match("/^; filament used = (.*)g/",$ll, $av);
		$filmass = $av[1];
     }
     if (preg_match("/^; filament cost = .*/", $ll)){
		preg_match("/^; filament cost = (.*)/",$ll, $av);
		$filcost = $av[1];
     }
}

fwrite($dfile,preg_replace("/,$/", "", $chrcntstr.PHP_EOL));
fwrite($dfile,preg_replace("/,$/", "", $zstring.PHP_EOL));
fwrite($dfile,"layer count ".$lyct.PHP_EOL);
fwrite($dfile,"filament vol ".$filvol.PHP_EOL);
fwrite($dfile,"filament mass ".$filmass.PHP_EOL);
fwrite($dfile,"filament cost ".$filcost.PHP_EOL);
fwrite($dfile,"time (s) ".($tsec*2).PHP_EOL);
$tme = gmdate('H:i:s', ($tsec*2)); 
fwrite($dfile,"time ".$tme.PHP_EOL);
fwrite($dfile,"box size minx ".min($xcoord)." maxx ".max($xcoord)." miny ".min($ycoord)." maxy ".max($ycoord).PHP_EOL);
fclose($dfile);

}





function printime($xyray){
$timry = array();
for($i=0;$i<count($xyray);$i++){
 if ($i>0){
  $x1 = $xyray[$i-1]["X"];
  $x2 = $xyray[$i]["X"];
  $y1 = $xyray[$i-1]["Y"];
  $y2 = $xyray[$i]["Y"];
  $len = sqrt(pow(($x1-$x2),2)+pow(($y1-$y2),2));
  $sec = $len / ($xyray[$i]["F"]*0.0167);
  array_push($timry, $sec);
 }
}
//$t = array_sum($timry)+600;
//echo "Time ".gmdate('H:i:s', $t);
$t = (array_sum($timry)*2);
$tme = gmdate('H:i:s', $t); 
return $tme;
}


function gcodeparsefilament($gdat){
 $zlevels = array();
 $fl = 0;
 $xyray = array();
 foreach($gdat as $key => &$val){ 
    if(preg_match('/^G1.*F.*/', $val,$ar)){
      preg_match('/^G1.*F(.*)/', $val,$ar);
      $feed = $ar[1];
    }
    if(preg_match('/^.*filament used = .*mm/', $val)){
     preg_match('/^.*filament used = (.*)mm/', $val, $ar);
     $filamentlength = $ar[1];
    }
    if(preg_match('/^.*filament used = .*g/', $val)){
     preg_match('/^.*filament used = (.*)g/', $val, $ar);
     $filamentweight = $ar[1];
    }
   $ct = 0;
   $timry = array();
    if(preg_match('/^G1.*X.*Y.*/', $val,$ar)){
	    preg_match('/^G1.*X(.*)Y(.*)/', $val,$ar);
      /*
     array_push($xyray, array(
      'X'=>$ar[1], 
      'Y'=>$ar[2],
      'F' => $feed
     ));
     */
     if ($ct > 0){
      $x1 = $xyray[$i-1]["X"];
      $x2 = $xyray[$i]["X"];
      $y1 = $xyray[$i-1]["Y"];
      $y2 = $xyray[$i]["Y"];
      $len = sqrt(pow(($x1-$x2),2)+pow(($y1-$y2),2));
      $sec = $len / ($xyray[$i]["F"]*0.0167);
      array_push($timry, $sec);
     }
     $ct = $ct+1;
    }

 }
  var_dump(count($timry));
  echo "<br>";
  $t = (array_sum($timry)*2);
  $tme = gmdate('H:i:s', $t); 
  //$tme = printime($xyray);
  return array("xyray"=>$xyray, "filamentlength"=>$filamentlength, "filamentweight"=>$filamentweight, "time"=>$tme);
}

function gcodeparse($gdat){
 $zlevels = array();
 $fl = 0;
 $pzlev = array( "lines" => array(), "linenum"=>array());
 foreach($gdat as $key => &$val){ 
    if (preg_match("/^;AFTER_LAYER_CHANGE$/", $val)) {
     array_push($zlevels, $pzlev);
     $pzlev = array( "lines" => array(), "linenum"=>array());
     array_push($pzlev, array('lines' => $val, 'linenum' => $key));
    } else {  
	    array_push($pzlev, array('lines' => $val, 'linenum' => $key));
    }
 }
     array_push($zlevels, $pzlev);
 return($zlevels);
}

function prusagcodeparse($gdat){
 $zlevels = array();
 $fl = 0;
 $pzlev = array( "lines" => array(), "linenum"=>array());
 foreach($gdat as $key => &$val){ 
    if (preg_match("/^;Z:.*$/", $val)) {
     array_push($zlevels, $pzlev);
     $pzlev = array( "lines" => array(), "linenum"=>array());
     array_push($pzlev, array('lines' => $val, 'linenum' => $key));
    } else {  
	    array_push($pzlev, array('lines' => $val, 'linenum' => $key));
    }
 }
     array_push($zlevels, $pzlev);
 return($zlevels);
}






function writejscad($functionname,$contents){
 $myfile = fopen("uploads/".$functionname.".jscad", "w");
 fwrite($myfile, $contents); 
 fclose($myfile);
}


function displayjscad($stlobj){
  //$stlobj['functionname'];
  $contents = $stlobj['header'].PHP_EOL;
  $contents = $contents.$stlobj['polyhedronheader'].PHP_EOL;
  foreach($stlobj['polyheadrons'][0] as $pl){
   $contents = $contents.$pl.PHP_EOL;
  }
  $contents = $contents.$stlobj['polygonheader'].PHP_EOL;
  foreach($stlobj['polygons'][0] as $ppl){
   $contents = $contents.$ppl.PHP_EOL;
  } 
  $contents = $contents.$stlobj['functiontail'];
  writejscad($stlobj['functionname'],$contents);
}
function positionstats($polyhedron,$functionname){
  if (file_exists('uploads/'.$functionname.'.json')) {
   $movedata = json_decode(file_get_contents('uploads/'.$functionname.'.json'), true);
  } else {
   $movedata = array(
     "x"=>0,
     "y"=>0,
     "z"=>0,
     "rx"=>0,
     "ry"=>0,
     "rz"=>0,
     "sx"=>0,
     "sy"=>0,
     "sz"=>0,
     "mx"=>null,
     "my"=>null,
     "mz"=>null
    );
   file_put_contents('uploads/'.$functionname.'.json', json_encode($movedata));
  }
  // [61.7279,3,199],    
  $xpos = array();
  $ypos = array();
  $zpos = array();
  //var_dump($polyhedron);
  foreach($polyhedron[0] as $pp){
   //echo preg_replace("/\[/", "", $pp).'<br>';
   $ppp =  preg_replace("/\[/", "", $pp);
   $pppp =  preg_replace("/\]/", "", $ppp);
   $pppp =  preg_replace("/\],/", "", $pppp);
   $ar = preg_split("/,/", $pppp);
   array_push($xpos,$ar[0]);
   array_push($ypos,$ar[1]);
   array_push($zpos,$ar[2]);
  }
  $stats = array(
    "minx"=>min($xpos),
    "maxx"=>max($xpos),
    "miny"=>min($ypos),
    "maxy"=>max($ypos),
    "minz"=>min($zpos),
    "maxz"=>max($zpos),
    "movex"=>$movedata['x'],
    "movey"=>$movedata['y'],
    "movez"=>$movedata['z'],
    "rotatex"=>$movedata['rx'],
    "rotatey"=>$movedata['ry'],
    "rotatez"=>$movedata['rz'],
    "scalex"=>$movedata['sx'],
    "scaley"=>$movedata['sy'],
    "scalez"=>$movedata['sz'],
    "mirrorx"=>$movedata['mx'],
    "mirrory"=>$movedata['my'],
    "mirrorz"=>$movedata['mz']
  );
  return $stats;
}
function parser($dir, $ff){
$trimmed = file($dir.'/'.$ff, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$fl = 0;
$polyhedrons = array();
$polygons = array();
foreach($trimmed as $tt){
	$ttt =preg_split('/\.setColor\(\)/', $tt);
	$tt = implode($ttt);
	if (preg_match("/^.*polyhedron\({ points: \[/", $tt)){
		$fl = 1;
		$prepoly = array();
	}
  //polygons: [
	if (preg_match("/^.*polygons: \[/", $tt)){
		$fl = 2;
		$prepolygon = array();
	}

	if ((preg_match("/^.*\]\]/", $tt)) and ($fl == 1)){
		array_push($prepoly, $tt);
		array_shift($prepoly);
		array_push($polyhedrons, $prepoly);
		$fl = 0;
	}

	if ((preg_match("/^.*\]\]/", $tt))and ($fl == 2)){
		array_push($prepolygon, $tt);
		array_shift($prepolygon);
		array_push($polygons, $prepolygon);
		$fl = 0;
	}

	if ($fl == 1){
		array_push($prepoly, $tt);
        }
	if ($fl == 2){
		array_push($prepolygon, $tt);
        }
 }
   $objects = array("polyhedrons"=>$polyhedrons, "polygons"=>$polygons);
   return $objects;
}

/*
function cleanjsscript($dir, $ff){
$trimmed = file($dir.'/'.$ff, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$fl = 0;
$polyhedrons = array();
$polygons = array();
$myfile = fopen($dir."/".$ff, "w");
foreach($trimmed as $tt){
	$ttt =preg_split('/\.setColor\(\)/', $tt);
	$tt = implode($ttt);
        fwrite($myfile, $tt.PHP_EOL);
}
fclose($myfile);
}
*/

?>
<?
function scanprusagcode($filenm){

$fl = "../rendered/gcodes/rendered_".preg_replace("/.stl$/", ".gcode",$filenm);
$fll = "../rendered/gcodes/rendered_".preg_replace("/.stl$/", ".txt",$filenm);
$lry = array();
$layers = array();
$dfile = fopen($fll, "w"); 
$xcoord = array();
$ycoord = array();
$layerstats = array();
$ct = 0;
$tx = array();
$ty = array();
$ly = "";
$tsec = 0;
$lyct = 0;
$chrcnt = 0;
$chrcntstr = "";
$zstring = "";
fwrite($dfile, "Layer num: ".$lyct.PHP_EOL);
if ($file = fopen($fl, "r")) {
    while(!feof($file)) {
	    $line = fgets($file);
	    $chrcnt = $chrcnt + strlen($line);
	    if (!preg_match("/^;Z:.*$/", $line)){
    	      array_push($layers, $line);
	      if(preg_match("/^G1.*F.*/", $line)){
	          preg_match("/^G1.*F(.*)$/", $line,$aa);
		  $feed = preg_replace("/;.*/", "", $aa[1]);
	      }
	      if(preg_match("/^G1.*X.*Y.*E.*/", $line)){
	       preg_match("/^G1.*X(.*)Y(.*) .*$/", $line,$aa);
	       array_push($xcoord,floatval($aa[1]));
	       array_push($tx,$aa[1]);
	       array_push($ycoord,floatval($aa[2]));
	       array_push($ty,$aa[2]);
	       $ct = $ct + 1;
	       if ($ct == 2){ 
	        $ly = $ly."bx".$tx[0]."ex".$tx[1]."by".$ty[0]."ey".$ty[1]."f".$feed.PHP_EOL;
                //$len = sqrt(pow((floatval($tx[0])-floatval($tx[1])),2)+pow((floatval($ty[0])-floatval($ty[1])),2));
		//$sec = $len / (intval($feed)*0.0167);
		//$tsec = $tsec + $sec;
	        $ct = 0; 
		$tx = array();
		$ty = array();
	       }
	      }

	    } else {
		    if (preg_match("/;Z:.*/", $line)){
		     preg_match("/;Z:(.*)$/", $line, $ag);
		     $prevlayers = $layers;
		     $zstring = $zstring.round($ag[1],3).",";
		     $chrcntstr = $chrcntstr.$chrcnt.",";
		    }
		    if (count($xcoord)>0){
		     $lyct = $lyct + 1;
		     fwrite($dfile, "Layer num: ".($lyct).PHP_EOL);
		     fwrite($dfile,$ly);
		    }
		    $ly = "";
		    $layers = array();
		    array_push($layers, $line);
	    }
    }
    $chrcntstr = $chrcntstr.$chrcnt.",";
    if (count($xcoord)>0){
      fwrite($dfile, "Layer num: ".($lyct+1).PHP_EOL);
      fwrite($dfile,$ly);
    }
    array_push($lry, $layers);
    $layers = array();
    fclose($file);
}
//var_dump($lry);
/*
; filament used [mm] = 7317.64
; filament used [cm3] = 17.60
; total filament used [g] = 0.00
; total filament cost = 0.00
; estimated printing time (normal mode) = 1h 7m 6s
; estimated printing time (silent mode) = 1h 8m 44s
 */


foreach($lry as $lll){
   foreach($lll as $ll){
	if (preg_match("/^; filament used .*cm3.* = .*/", $ll)){
         preg_match("/^; filament used .* = (.*)$/",$ll, $av);
         $filvol = $av[1];
	 }
	if (preg_match("/^; filament used .*mm.* = .*/", $ll)){
         preg_match("/^; filament used .* = (.*)$/",$ll, $av);
         $fillength = $av[1];
	 }
     if (preg_match("/^; total filament cost = .*/", $ll)){
                preg_match("/^; total filament cost = (.*)$/",$ll, $av);
                $filcost = $av[1];
     }
     if (preg_match("/^; estimated printing time \(normal mode\) = .*/", $ll)){
                preg_match("/^; estimated printing time \(normal mode\) = (.*)$/",$ll, $av);
                $time = $av[1];
     }
}
}

fwrite($dfile,preg_replace("/,$/", "", $chrcntstr.PHP_EOL));
fwrite($dfile,preg_replace("/,$/", "", $zstring.PHP_EOL));
fwrite($dfile,"layer count ".$lyct.PHP_EOL);
fwrite($dfile,"filament vol ".$filvol.PHP_EOL);
fwrite($dfile,"filament length ".$fillength.PHP_EOL);
fwrite($dfile,"filament cost ".$filcost.PHP_EOL);
fwrite($dfile,"time ".$time.PHP_EOL);
//fwrite($dfile,"time (s) ".($tsec*2).PHP_EOL);
//$tme = gmdate('H:i:s', ($tsec*2));
//fwrite($dfile,"time ".$tme.PHP_EOL);
fwrite($dfile,"box size minx ".min($xcoord)." maxx ".max($xcoord)." miny ".min($ycoord)." maxy ".max($ycoord).PHP_EOL);
fclose($dfile);



}
?>


