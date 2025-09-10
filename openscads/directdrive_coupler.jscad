//producer: OpenJSCAD 1.10.0
      // source: openscads/directdrive_coupler.jscad
      function main(){


return CSG.cylinder({start: [0,0,0], end: [0,0,10],radiusStart: 11, radiusEnd: 11, resolution: 30}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-45,22.5]).union([CSG.cube({center: [17.25,6.5,2.4750000000000005],radius: [17.25,6.5,2.4750000000000005], resolution: 16}).translate([-41.65,-48,26.3])]).subtract([CSG.cylinder({start: [0,0,0], end: [0,0,28],radiusStart: 6, radiusEnd: 6, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-37.5,22.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,28],radiusStart: 6, radiusEnd: 6, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-70.5,22.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,36],radiusStart: 1.9, radiusEnd: 1.9, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-48,14.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,4],radiusStart: 4.25, radiusEnd: 4.25, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-47,14.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,24],radiusStart: 4.25, radiusEnd: 4.25, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-67,30.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,24],radiusStart: 4.25, radiusEnd: 4.25, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-46.15,-67,22.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,24],radiusStart: 4.25, radiusEnd: 4.25, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-30.15,-67,22.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,36],radiusStart: 1.9, radiusEnd: 1.9, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-53,30.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,36],radiusStart: 1.9, radiusEnd: 1.9, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-46.15,-53,22.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,36],radiusStart: 1.9, radiusEnd: 1.9, resolution: 35}).rotateX(-90).rotateY(0).rotateZ(0).translate([-30.15,-53,22.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,241],radiusStart: 3.9, radiusEnd: 3.9, resolution: 13}).rotateX(-90).rotateY(0).rotateZ(0).translate([-38.15,-70,22.5]),
CSG.cylinder({start: [0,0,0], end: [0,0,120],radiusStart: 1.85, radiusEnd: 1.85, resolution: 6}).translate([-9.549999999999999,-40,-23.7]).union([CSG.cylinder({start: [0,0,0], end: [0,0,120],radiusStart: 1.85, radiusEnd: 1.85, resolution: 6}).translate([0.45000000000000107,-40,-23.7])]).translate([-12,-4.3,0])]).translate([0,-29,0]);
};