carriage_yaxis_wall();
//carriage_yaxis_wall();


module carriage_yaxis_wall(){
difference(){
 union(){
  translate([0,-1,0.5]){
  translate([-10+1.5-11.8+15.5,20+20-55-2-10-3,-10+28+8-32])color("pink")cube([14.5+5,31+23+8,29+1]);
  }
 }
translate([-10+1.5-11.8+15.5+5+8.5+0.5,20+20-48-8-10-0.5,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30);
translate([-10+1.5-11.8+15.5+5+8.5+0.5,20+20-48+18+8+7.5+0.5,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30);
translate([-10+1.5-11.8+15.5+5,20+20-48-8+2,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30);
translate([-10+1.5-11.8+15.5+5,20+20-48+18+8-2,-10+28+8-32-50])cylinder(r=4.8/2,h=250,$fn=30);
}
}

