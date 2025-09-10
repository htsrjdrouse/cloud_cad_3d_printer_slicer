
function main(params)
{
  var spinningtop = spinningTop();
  var spinningtopjscad = spinningjscadTop();

  // Construct the result; use the parameters set by the end user:
  var result = new CSG();
  result = result.union(spinningtop);
  result = result.union(spinningtopjscad);
  return result;
}


function spinningjscadTop(){
  g = cylinder({r1: 1, r2:20, h: 15});
  h = cylinder({r1: 0.5, r2:18, h: 16}).translate([0,0,1]);
  e = difference(g,h);
  i = cylinder({r:5,h:30}).translate([0,0,3]);
  return(union(e,i));
}


function spinningTop(){

     // the plate:
  var platetoo = CSG.cube({radius: [40,40,4]}).translate([30,10,50]);
  var basecylinder = CSG.cylinder({ radiusStart: 1, 
    radiusEnd:20,resolution: 16, start: [0, 0, 0], 
    end: [0, 0, 15] }).translate([0,0,0]);
  var cutcylinder = CSG.cylinder({ radiusStart: 0.5, 
    radiusEnd:18,resolution: 16, start: [0, 0, 1], 
    end: [0, 0, 16] }).translate([0,0,0]);
  var shaftcylinder = CSG.cylinder({ radius: 5, 
    resolution: 16, start: [0, 0, 3], 
    end: [0, 0, 30] }).translate([0,0,0]);
  //var result = basecylinder;
  var result = new CSG();
  basecylinder = basecylinder.subtract(cutcylinder);
  result = result.union(basecylinder);
  //result = result.union(cutcylinder.setColor(0,0.8,0));
  result = result.union(shaftcylinder);
  result = result.translate([40,0,0]);
  return result;
}
