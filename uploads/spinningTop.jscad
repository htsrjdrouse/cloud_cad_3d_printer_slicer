var w = new Array();
function a() {
//w.push(cylinder({r1: 1, r2:20, h: 15}));
w.push(b());
}
function main() {
   a();
   return w;
}
function b(){
g = cylinder({r1: 1, r2:20, h: 15});
h = cylinder({r1: 0.5, r2:18, h: 16}).translate([0,0,1]);
e = difference(g,h);
i = cylinder({r:5,h:30}).translate([0,0,3]);
return(union(e,i));
}