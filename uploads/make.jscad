var w = new Array();

function main() {
   a();
   return w;
}

function a() {
//w.push(cylinder({r1: 1, r2:20, h: 15}));
var ba = b();
ba = scale(0.8,ba);
var cy = cylinder({r: 10, h: 1});
var dcy = cylinder({r: 7, h: 1});
var ccy = difference(cy,dcy);
ccy = scale([5,2,1],ccy).translate([0,9,0]);
w.push(ba,ccy);
}


function b(){
var l = vector_text(-40,0,"MAKE");  // l contains a list of polylines to be drawn
var o = [];
l.forEach(function(pl) {  // pl = polyline (not closed)
   o.push(rectangular_extrude(pl, {w: 2, h: 4}));   // extrude it to 3D
});
return union(o);
}