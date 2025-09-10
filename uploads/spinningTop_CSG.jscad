
function main(params)
{
  var spinningtop = spinningTop();

  // Construct the result; use the parameters set by the end user:
  var result = new CSG();
  result = result.union(spinningtop);
  return result;
}


function spinningTop(){

     // the plate:
  var platetoo = CSG.cube({radius: [40,40,4]}).translate([30,10,50]);
  var basecylinder = CSG.cylinder({ radiusStart: 1, 
    radiusEnd:20,resolution: 16, start: [0, 0, 0], 
    end: [0, 0, 18] }).translate([0,0,0]);
  var cutcylinder = CSG.cylinder({ radiusStart: 0.5, 
    radiusEnd:18,resolution: 16, start: [0, 0, 1], 
    end: [0, 0, 20] }).translate([0,0,0]);
  var shaftcylinder = CSG.cylinder({ radius: 5, 
    resolution: 16, start: [0, 0, 3], 
    end: [0, 0, 40] }).translate([0,0,0]);
  //var result = basecylinder;
  var result = new CSG();
  basecylinder = basecylinder.subtract(cutcylinder);
  result = result.union(basecylinder);
  //result = result.union(cutcylinder.setColor(0,0.8,0));
  result = result.union(shaftcylinder);
  result = result.translate([40,0,0]);
  return result;
}
