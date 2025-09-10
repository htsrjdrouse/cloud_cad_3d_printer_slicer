<?
$f = fopen('uploads/3dprint_adjuster.jscad', 'r');
$ff = fread($f,filesize("uploads/3dprint_adjuster.jscad"));
fclose($f);
$fff = preg_split("/\n/", $ff);
//print_r($fff);

$fl = 0;
$points = array();
foreach($fff as $j){
	//echo $j.'<br>';
	if (preg_match("/^.*onst points.*/", $j)){
		$fl = 1;
	}
	if (preg_match("/^.*onst colors.*/", $j)){
		$fl = 0;
	}
	if (preg_match("/^.*onst faces.*/", $j)){
		$fl = 0;
	}
	if ($fl == 1){
         array_push($points, $j);
	}
}
//print_r($points);


echo "function main() { return union(<br>";
echo "polyhedron({ points: [<br>";
for($i=1;$i<count($points)-1; $i++){
echo $points[$i].'<br>';
}
echo "}).lieFlat()<br>";
echo "); }<br>";
?>
