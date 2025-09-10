<?
session_start();


$cool = array( 
	"jscadlist" => array(
		"imagingblock_lightingside.jscad",
		"directdrive_coupler.jscad",
		"imagingblock_lid.jscad",
		"imagingblock_lid.scad",
		"directdrive_coupler.scad",
		"carriage_yaxis_wall.jscad",
		"carriage_prototype_xaxis_wall.scad",
		"iverntech_connector.jscad",
		"25mm_cube.jscad",
		"bom_camera.jscad",
		"carriage_yaxis_wall.scad",
		"3DPNFilHoldRollerassy.jscad"
		),
		"views" => 3,
		"openeditproject" => 0,
		"opensaveproject" => 0,
		"openselectproject" => 0,
		"opencopyfiles" => 0,
		"reallydeleteproject" => 0,
		"selectedprojectdetails" => 1,
		"jscadlist" => array("imagingblock_lightingside.jscad", "directdrive_coupler.jscad", "imagingblock_lid.jscad", "imagingblock_lid.scad", "directdrive_coupler.scad","carriage_yaxis_wall.jscad", "carriage_prototype_xaxis_wall.scad", "iverntech_connector.jscad", "25mm_cube.jscad", "bom_camera.jscad", "carriage_yaxis_wall.scad", "3DPNFilHoldRollerassy.jscad"),
		"jscadfilename" => "carriage_yaxis_wall.jscad",
		"fromstl" => 0,
		"jscadcontents"  =>  "//producer: OpenJSCAD 1.10.0 // source: openscads/carriage_yaxis_wall.jscad function main(){ return CSG.cube({center: [9.75,31,15],radius: [9.75,31,15], resolution: 16}).setColor(1,0.753,0.796).translate([-4.800000000000001,-30,-6]).translate([0,-1,0.5]).subtract([CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([9.2,-26.5,-56]), CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([9.2,26,-56]), CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([0.1999999999999993,-14,-56]), CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([0.1999999999999993,16,-56])]); };",
		"objectsactive" => "carriage_yaxis_wall.jscad",
		"scadview" => 0,
		"oscadcontents" =>  'carriage_yaxis_wall(); //carriage_yaxis_wall(); module carriage_yaxis_wall(){ difference(){ union(){ translate([0,-1,0.5]){ translate([-10+1.5-11.8+15.5,20+20-55-2-10-3,-10+28+8-32])color("pink")cube([14.5+5,31+23+8,29+1]); } } translate([-10+1.5-11.8+15.5+5+8.5+0.5,20+20-48-8-10-0.5,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30); translate([-10+1.5-11.8+15.5+5+8.5+0.5,20+20-48+18+8+7.5+0.5,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30); translate([-10+1.5-11.8+15.5+5,20+20-48-8+2,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30); translate([-10+1.5-11.8+15.5+5,20+20-48+18+8-2,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30); } } ',
		"selectedproject"=> "openscads",
		"scadfilename"=> "carriage_yaxis_wall.jscad",
);



$_SESSION = $cool;
//$_SESSION['jscadfilename'] = $_SESSION['jscadlist'][$_POST['objectlist']];
 $_SESSION['fromstl'] = 0;
 $f = fopen("openscads/".$_SESSION['jscadfilename'],"r");
 $_SESSION['jscadcontents'] = fread($f,filesize("openscads/".$_SESSION['jscadfilename']));



//echo $_SESSION['jscadfilename'];

header("Location: objects.json.php");
//var_dump($_SESSION);
?>
