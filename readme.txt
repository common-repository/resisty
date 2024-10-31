=== Plugin Name ===
Contributors: CupNoodles
Tags: resistor, captcha
Requires at least: 2.0.2
Tested up to: 2.1
Stable tag: 1.6

This plugin creates a resistor color code captcha on comment forms

== Description ==

This plugin will draw a random 5% or 10% resistor and four color band sliders beneath it. The commenter needs to match the colors on the sliders to the colors on the resistor.

Commenters don't actually need to know how to read resistors. 

Random resistors are generated from E12 and E24 decade values (so there's never something like a 4.6K Ohm resistor).

== Installation ==

1.) Unpack the .zip file if you downloaded this as a .zip file. 
2.) Upload the entire resisty/ directory to wp-content/plugins/.
3.) In the blog admin page, navigate to plugins, and click "Activate" under Resisty. 



Colorblind friendly instructions (still in beta!):

1.)In classyCaptcha.php, find and replace all instances of 

      "resistorImage.php"

with 

      "resistorImage.php?blind=colorblind&"

2.) Upload a .ttf font of your choice to the plugins/resisty/ directory
3.) Insert into line 97 of resistorImage.php

$font = 'MYFONT.ttf';

where MYFONT is the file you uploaded.

== Changelog ==

= 1.5 =

We've made a few changes thanks to our many beta testers:

* New reload image button
* Image path name is now correct
* Parses out single and double quotes and backslashed out correctly.
* Colorblind friendly option now in beta. 
* 20% resistors now show up

= 1.4 = 

Official Release!

