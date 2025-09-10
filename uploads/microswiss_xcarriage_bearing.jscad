//producer: OpenJSCAD 1.10.0
      // source: uploads/microswiss_xcarriage_bearing.jscad
      function main(){


return CSG.cube({center: [10,36,7.305],radius: [10,36,7.305], resolution: 16}).translate([-10.3,-41.05,23]).union([CSG.cube({center: [15,18,9.305],radius: [15,18,9.305], resolution: 16}).translate([-10.3,23.95,23]),
CSG.cube({center: [12.75,20,24.055],radius: [12.75,20,24.055], resolution: 16}).translate([-15.8,-75.05,23]),
CSG.cylinder({start: [0,0,0], end: [0,0,21.36],radiusStart: 5, radiusEnd: 5, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([9.7,20.25,29]),
CSG.cylinder({start: [0,0,0], end: [0,0,21.36],radiusStart: 5, radiusEnd: 5, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([9.7,-19.75,29])]).subtract([CSG.cylinder({start: [0,0,0], end: [0,0,100],radiusStart: 12.5, radiusEnd: 12.5, resolution: 30}).rotateX(0).rotateY(0).rotateZ(0).translate([-12,-55,20]),
CSG.cylinder({start: [0,0,0], end: [0,0,100],radiusStart: 1.4, radiusEnd: 1.4, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).translate([48,-71,65]),
CSG.cylinder({start: [0,0,0], end: [0,0,100],radiusStart: 1.4, radiusEnd: 1.4, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).translate([48,-39,65]),
CSG.cylinder({start: [0,0,0], end: [0,0,95],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([12.2,52,-46]),
CSG.cylinder({start: [0,0,0], end: [0,0,95],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([12.2,32,-46]),
CSG.cylinder({start: [0,0,0], end: [0,0,95],radiusStart: 5, radiusEnd: 5, resolution: 30}).translate([12.2,52,-56]),
CSG.cylinder({start: [0,0,0], end: [0,0,95],radiusStart: 5, radiusEnd: 5, resolution: 30}).translate([12.2,32,-56]),
CSG.cylinder({start: [0,0,0], end: [0,0,95],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([0.1999999999999993,-8,-56]).translate([0,0,0]).union([CSG.cylinder({start: [0,0,0], end: [0,0,95],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([0.1999999999999993,10,-56]).translate([0,0,0])]),
CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([71.7,20.25,53.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([71.7,-19.75,53.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.9, radiusEnd: 2.9, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([71.7,20.25,29]),
CSG.cylinder({start: [0,0,0], end: [0,0,25],radiusStart: 5.1, radiusEnd: 5.1, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([19.7,20.25,29]),
CSG.cylinder({start: [0,0,0], end: [0,0,125],radiusStart: 2.9, radiusEnd: 2.9, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([71.7,-19.75,29]),
CSG.cylinder({start: [0,0,0], end: [0,0,25],radiusStart: 5.1, radiusEnd: 5.1, resolution: 30}).rotateX(0).rotateY(-90).rotateZ(0).setColor(1,0.753,0.796).translate([19.7,-19.75,29])]);
};