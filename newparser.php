<? session_start(); ?>

<?
/*
//$pdat = fopen("rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename']),"r");
$pdat = fopen("rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode","Extruder_fix_prusaslicer.stl"),"r");
$dat= fread($pdat,filesize("rendered/gcodes/rendered_".preg_replace("/.jscad$/", ".gcode",$_SESSION['jscadfilename'])));
$adat = preg_split("/\n/", $dat);
 */

//$flnm = "Extruder_fix_prusaslicer.stl";
$flnm = "hot_end_clamp.stl";

scangcode($flnm);
//$stats = readgcodestats($flnm);

function readgcodestats($filenm){
$fll = "rendered/gcodes/rendered_".preg_replace("/.stl$/", ".txt",$filenm);
$file = new SplFileObject($fll);
$file->seek(PHP_INT_MAX); // cheap trick to seek to EoF
$total_lines = $file->key(); // last line number

// output the last twenty lines
$reader = new LimitIterator($file, $total_lines - 7);
$lns = array();
foreach ($reader as $line) {
    array_push($lns,preg_replace("/\n/", "", $line));
    //echo $line.'<br>'; // includes newlines
}
$stats = array(
 "layercount"=>preg_replace("/layer count /", "", $lns[0]),
 "filamentvol"=>preg_replace("/filament vol /", "", $lns[1]),
 "filamentmass"=>preg_replace("/filament mass /", "", $lns[2]),
 "filamentcost"=>preg_replace("/filament cost /", "", $lns[3]),
 "time"=>preg_replace("/time /", "", $lns[5]),
);
return $stats;
}
function scangcode($filenm){
$fl = "rendered/gcodes/rendered_".preg_replace("/.stl$/", ".gcode",$filenm);
$fll = "rendered/gcodes/rendered_".preg_replace("/.stl$/", ".txt",$filenm);
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
$zstring = "";
$chrcnt = 0;
$chrcntstr = "";
fwrite($dfile, "Layer num: ".$lyct.PHP_EOL);
if ($file = fopen($fl, "r")) {
    while(!feof($file)) {
	    $line = fgets($file);
	    $chrcnt = $chrcnt + strlen($line);
	    if (!preg_match("/^.*AFTER_LAYER_CHANGE.*/", $line)){
    	      array_push($layers, $line);
	      if(preg_match("/^G1.*F.*/", $line)){
	          preg_match("/^G1.*F(.*)$/", $line,$aa);
		  $feed = preg_replace("/;.*/", "", $aa[1]);
	      }
	      if(preg_match("/^G1.*Z.*/", $line)){
	          preg_match("/^G1.*Z(.*) F.*$/", $line,$aa);
		  $z = preg_replace("/;.*/", "", $aa[1]);
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
		    preg_match("/;AFTER_LAYER_CHANGE (.*)/", $line, $ag);
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

    if (count($xcoord)>0){
      fwrite($dfile, "Layer num: ".($lyct+1).PHP_EOL);
      fwrite($dfile,$ly);
    }
    $chrcntstr = $chrcntstr.$chrcnt.",";
    array_push($lry, $layers);
    $layers = array();
    fclose($file);
}


//echo $zstring.'<br>';
echo "<br>";
//var_dump($prevlayers);
echo $chrcntstr;
echo "<br>";
echo $zstring;
echo "<br>";


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

fwrite($dfile,"filepos ".$chrcntstr.PHP_EOL);
fwrite($dfile,"zlevels ".$zstring.PHP_EOL);
fwrite($dfile,"layer count ".$lyct.PHP_EOL);
fwrite($dfile,"filament vol ".$filvol.PHP_EOL);
fwrite($dfile,"filament mass ".$filmass.PHP_EOL);
fwrite($dfile,"filament cost ".$filcost.PHP_EOL);
fwrite($dfile,"time (s) ".($tsec*2).PHP_EOL);
$tme = gmdate('H:i:s', ($tsec*2)); 
fwrite($dfile,"time ".$tme.PHP_EOL);
fwrite($dfile,"box size minx ".min($xcoord)." maxx ".max($xcoord)." miny ".min($ycoord)." maxy ".max($ycoord).PHP_EOL);
fclose($dfile);


$filepos = preg_split("/,/", $chrcntstr);
var_dump($filepos[72]);
echo "<br>";
var_dump($filepos[73]);
echo "<br>";
//$section = file_get_contents($fl, NULL, NULL, 0, ($filepos[0]));

$section = file_get_contents($fl, NULL, NULL, $filepos[72], ($filepos[73]-$filepos[72]));
//var_dump($section);
$s = preg_split("/\n/", $section);
foreach($s as $ss){
	echo $ss.'<br>';
}

}
echo "success";

?>
