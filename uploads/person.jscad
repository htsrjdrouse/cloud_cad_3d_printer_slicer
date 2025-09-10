var w = new Array();

function main() {
   a();
   return w;
}

function a() {
//w.push(cylinder({r1: 1, r2:20, h: 15}));
w.push(b());
}


function b(){
g = cylinder({ r1: 10, r2: 10, h: 5}); //head
h = cylinder({ r1: 2, r2: 2, h: 7}).translate([-2,5,-1]); //left eye
i = cylinder({ r1: 2, r2: 2, h: 7}).translate([-2,-3,-1]); //right eye
j = cylinder({ r1:3,r2:3,h: 7}).translate([5,0,-1]); //mouth
e = difference(g,h,i,j);
f = cube([20,20,5]).translate([8,-10,0]);
la = cube([5,20,5]);
la = rotate([0,0,30],la);
la = la.translate([18.5,-27,0]);
ra = cube([5,20,5]);
ra = rotate([0,0,30],ra);
ra = ra.translate([7.5,6,0]);
ll = cube([20,7,5]);
ll = ll.translate([28,-5,0]);
ll = rotate([0,0,-10],ll);
rl = cube([20,7,5]);
rl = rl.translate([28,3,0]);
rf = cube([5,7,12]).translate([28+15,3,0]);
lf = cube([5,7,12]).translate([28+15,3-16,0]);
//k = cube([ 5, 20, 5 ]).translate([8,-30,0]).rotate_about_pt(30,0,[8,-10,0]);
return(union(e,f,la,ra,ll,rl,rf,lf));
}