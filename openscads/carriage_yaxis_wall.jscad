//producer: OpenJSCAD 1.10.0
      // source: openscads/carriage_yaxis_wall.jscad
      function main(){


return CSG.cube({center: [9.75,31,15],radius: [9.75,31,15], resolution: 16}).setColor(1,0.753,0.796).translate([-4.800000000000001,-30,-6]).translate([0,-1,0.5]).subtract([CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([9.2,-26.5,-56]),
CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([9.2,26,-56]),
CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([0.1999999999999993,-14,-56]),
CSG.cylinder({start: [0,0,0], end: [0,0,250],radiusStart: 2.4, radiusEnd: 2.4, resolution: 30}).translate([0.1999999999999993,16,-56])]);
};