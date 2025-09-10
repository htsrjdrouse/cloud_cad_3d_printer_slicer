//producer: OpenJSCAD 1.10.0
      // source: uploads/zcarriage_bearing.jscad
      function main(){


return CSG.cube({center: [8,6,18.18],radius: [8,6,18.18], resolution: 16}).setColor().translate([-6.300000000000001,-31.05,23]).union([CSG.cube({center: [8,31,11.68],radius: [8,31,11.68], resolution: 16}).setColor().translate([-6.300000000000001,-31.05,23]),
CSG.cylinder({start: [0,0,0], end: [0,0,21.36],radiusStart: 5, radiusEnd: 5, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([9.7,24.25,29]),
CSG.cylinder({start: [0,0,0], end: [0,0,21.36],radiusStart: 5, radiusEnd: 5, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([9.7,-23.75,29])]).subtract([CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).rotateX(90).rotateY(0).rotateZ(0).translate([5.699999999999999,-8,53]),
CSG.cylinder({start: [0,0,0], end: [0,0,19.1],radiusStart: 4.25, radiusEnd: 4.25, resolution: 30}).rotateX(90).rotateY(0).rotateZ(0).translate([5.699999999999999,-8,53]),
CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([71.7,24.25,29]),
CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([71.7,-23.75,29])]);
};