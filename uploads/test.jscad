var w = new Array();

function main() {
   a();
   return w;
}

function a() {
//w.push(cylinder({r1: 1, r2:20, h: 15}));
w.push(b());
}

/*
function rotate_about_pt(z, y, pt) {
    translate(pt)
        rotate([0, y, z])
            translate(-pt)
                children();
}
*/
function b(){
g = cylinder({ r1: 10, r2: 10, h: 5}); //head
h = cylinder({ r1: 2, r2: 2, h: 7}).translate([-2,5,-1]); //left eye
i = cylinder({ r1: 2, r2: 2, h: 7}).translate([-2,-3,-1]); //right eye
j = cylinder({ r1:3,r2:3,h: 7}).translate([5,0,-1]); //mouth
e = difference(g,h,i,j);
f = cube([20,20,5]).translate([8,-10,0]);
//k = cube([ 5, 20, 5 ]).translate([8,-30,0]).rotate_about_pt(30,0,[8,-10,0]);
return(union(e,f));
}