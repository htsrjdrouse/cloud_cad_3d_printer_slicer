//producer: OpenJSCAD 1.10.0
      // source: uploads/zcarriage_bearing_single.jscad
      function main(){


return CSG.cube({center: [8,5,14.68],radius: [8,5,14.68], resolution: 16}).setColor().translate([-6.300000000000001,20.999999999999996,23]).union([CSG.cube({center: [8,17,7.18],radius: [8,17,7.18], resolution: 16}).setColor().translate([-6.300000000000001,-9.05,23]),
CSG.cylinder({start: [0,0,0], end: [0,0,21.36],radiusStart: 5, radiusEnd: 5, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([9.7,0.25,29])]).subtract([CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([11.7,0.25,29]),
CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).rotateX(-90).rotateY(0).rotateZ(0).setColor(1,0.753,0.796).translate([5.699999999999999,2.25,45]),
CSG.cylinder({start: [0,0,0], end: [0,0,27],radiusStart: 4.5, radiusEnd: 4.5, resolution: 30}).rotateX(-90).rotateY(0).rotateZ(0).setColor(1,0.753,0.796).translate([5.699999999999999,0.25,45]),
CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 4.75, radiusEnd: 4.75, resolution: 30}).translate([0.1999999999999993,10,-64]),
CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 4.75, radiusEnd: 4.75, resolution: 30}).translate([0.1999999999999993,-8,-64])]);
};