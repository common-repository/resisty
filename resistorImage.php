<?php
  /* This generates a random value resistor. 
   * since not all resistor values exist, we select at random from a list instead
   * $rand1 = rand(10,99);
   * $rand3 = rand(0,7);
   * $rand = $rand1 * pow(10, $rand3);
  */

  //24 basic resistor values

$e6 =  array(10, 15, 22, 33, 47, 68);
$e12 = array(10, 12, 15, 18, 22, 27, 33, 39, 47, 56, 68, 82);
$e24 = array(10, 11, 12, 13, 15, 16, 18, 20, 22, 24, 27, 30, 33, 36, 39, 43, 47, 51, 56, 62, 68, 75, 82, 91);


$rand3 = rand(0,6);
$rand4 = rand(0,2);

switch ($rand4)
  {
  case 0: 
    $rand4 = 5; 
    $randIndex = rand(0, 23);
    $rand1 = $e24[$randIndex];
    break;
  case 1: 
    $rand4 = 10; 
    $randIndex = rand(0, 11);
    $rand1 = $e12[$randIndex];
    break;
  case 2:
    $rand4 = 20;
    $randIndex = rand(0, 5);
    $rand1 = $e6[$randIndex];
    break;
  }

$rand = $rand1 * pow(10, $rand3);

$randSave = $rand + $rand4;
session_start();
session_unregister("randomResistor");
$_SESSION['randomResistor'] = md5($randSave);


$resistorPNG = 'resistor.png';

// set the HTTP header type to PNG
header("Content-type: image/png");

// create a pointer to a new true colour image
$im = ImageCreateFromPNG($resistorPNG); 
ImageTrueColorToPalette($im, false, 255);


// Allocate colors


// shades of gray
$black = ImageColorAllocate($im, 0, 0, 0);
$one = ImageColorClosest($im, 0x11,0x11,0x11); 
$two = ImageColorClosest($im, 0x22,0x22,0x22); 
$three = ImageColorClosest($im, 0x33,0x33,0x33); 
$four = ImageColorClosest($im, 0x44,0x44,0x44); 
$nine = ImageColorClosest($im, 0x99, 0x99, 0x99);

$colors = array();
$colors[0] = array(0,0,0, 'black'); 
$colors[1] = array(100, 50, 0, 'brown');
$colors[2] = array(255, 0, 0, 'red');
$colors[3] = array(255, 150, 0, 'orange');
$colors[4] = array(255, 255, 0, 'yellow');
$colors[5] = array(0, 255, 0, 'green');
$colors[6] = array(0, 0, 255, 'blue');
$colors[7] = array(255, 0, 255, 'violet');
$colors[8] = array(100, 100, 100, 'gray');
$colors[9] = array(255, 255, 255, 'white');

$colors[15] = array(233, 233, 20, 'gold');
$colors[20] = array(180, 180, 180, 'silver');
$colors[30] = array(241, 196, 58, 'none');


// Set color bands
$band1 = floor($rand1/10);
$band2 = $rand1%10;
$band3 = $rand3;
$band4 = $rand4 + 10; // fourth band is either gold (5) silver (10) or none (20)
ImageColorSet($im, $one, $colors[$band1][0], $colors[$band1][1], $colors[$band1][2]);
ImageColorSet($im, $two, $colors[$band2][0], $colors[$band2][1], $colors[$band2][2]);
ImageColorSet($im, $three, $colors[$band3][0], $colors[$band3][1], $colors[$band3][2]);
ImageColorSet($im, $four, $colors[$band4][0], $colors[$band4][1], $colors[$band4][2]);

// Set background (0x999999) transparent
ImageColorTransparent($im, $nine);


if ($_GET['blind'] == 'colorblind')
{
// Upload your font file to the resisty/ directory and point $font to it
//$font = 'MYFONT.ttf';
imagettftext($im, 10, 0, 31, 75, $black,  $font, $band1);
imagettftext($im, 10, 0, 65, 75, $black,  $font, $band2);
imagettftext($im, 10, 0, 111, 75, $black,  $font, $band3);
imagettftext($im, 10, 0, 146, 75, $black,  $font, $band4);
}
// send the new PNG image to the browser
ImagePNG($im); 
 
// destroy the reference pointer to the image in memory to free up resources
ImageDestroy($im); 

?>
