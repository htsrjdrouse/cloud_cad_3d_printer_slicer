//producer: OpenJSCAD 1.10.0 testing
      // source: openscads/imagingblock_lid.jscad
      function main(){


return CSG.cube({center: [29,50.199999999999996,2.5],radius: [29,50.199999999999996,2.5], resolution: 16}).translate([-28,-3,37]).union([CSG.cube({center: [71.5,15,2],radius: [71.5,15,2], resolution: 16}).translate([-113,32,37]),
CSG.cube({center: [39,5,4.5],radius: [39,5,4.5], resolution: 16}).translate([-93,42,37])]).setColor(0,1,0).subtract([CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 2.35, radiusEnd: 2.35, resolution: 30}).translate([-104,38,23]),
CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 2.35, radiusEnd: 2.35, resolution: 30}).translate([-104,55,23]),
CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 1.45, radiusEnd: 1.45, resolution: 30}).rotateX(0).rotateY(90).rotateZ(0).translate([-62,6,31]),
CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 1.45, radiusEnd: 1.45, resolution: 30}).rotateX(0).rotateY(90).rotateZ(0).translate([-62,88,31]),
CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 1.45, radiusEnd: 1.45, resolution: 30}).rotateX(0).rotateY(90).rotateZ(0).translate([-62,6,31]).translate([0,0,-27]).union([CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 1.45, radiusEnd: 1.45, resolution: 30}).rotateX(0).rotateY(90).rotateZ(0).translate([-62,88,31]).translate([0,0,-27])]),
CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 2.45, radiusEnd: 2.45, resolution: 30}).translate([20,1,23]),
CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 2.45, radiusEnd: 2.45, resolution: 30}).translate([20,94,23]),
CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 2.45, radiusEnd: 2.45, resolution: 30}).translate([20,1,23]).translate([-39,0,0]).union([CSG.cylinder({start: [0,0,0], end: [0,0,50],radiusStart: 2.45, radiusEnd: 2.45, resolution: 30}).translate([20,94,23]).translate([-39,0,0])]),
CSG.cube({center: [6.5,37.5,15],radius: [6.5,37.5,15], resolution: 16}).translate([11,10,35]),
CSG.cylinder({start: [0,0,0], end: [0,0,40],radiusStart: 1.9, radiusEnd: 1.9, resolution: 30}).rotateX(0).rotateY(90).rotateZ(0).translate([-51,24,13]),
CSG.cylinder({start: [0,0,0], end: [0,0,40],radiusStart: 6.75, radiusEnd: 6.75, resolution: 30}).rotateX(0).rotateY(90).rotateZ(0).translate([-51,46.9,22]),
CSG.cylinder({start: [0,0,0], end: [0,0,40],radiusStart: 1.9, radiusEnd: 1.9, resolution: 30}).rotateX(0).rotateY(90).rotateZ(0).translate([-51,69,13])]).translate([0,0,-30]).lieFlat();
};