/*
 *   Plugin Name: Resisty
 *   Plugin URI: http://www.ladyada.net/website/start
 *   Description: A captcha that uses resistor code values instead of hard to read letters
 *   Version: 1.1
 *   Author: Daigo Kawasaki
 *   Author URI: http://www.adafruit.com
 * License: GPL2
 */

var ie=document.all;
var nn6=document.getElementById&&!document.all;

var isdrag=false;
var x,y;
var dobj;

var sliderRange = 200;
var sliderStart;

/*
 * Initialize mouse event handlers
 */
function init_slider()
{
    document.onmousedown=selectmouse;
    document.onmouseup=new Function("isdrag = false");

    //ALRIGHT STEVE JOBS, LETS DANCE. 
    document.addEventListener("touchstart", function(e) {  
	    //	    var touch = e.changedTouches[0];  
	    selectmouse(e.touches[0]);
	}, false);  

    document.addEventListener("touchmove", function(e) {

	    if (e.target.className == 'slider' && isdrag == true)
		{
		    e.preventDefault();

		    //		    alert(e.touches.length);
		    

		    movemouse(e.touches[0]);

		}
	    
	}, false);
    document.addEventListener("touchend", function(e) {
			      
	    isdrag = false;

	}, false);
}
/*
 * Move slider class, replace html in slider, show resistor value.
 */
function movemouse(e)
{

    if (isdrag)// && document.getElementById(dobj.id + 'Wrapper'))
	{

	    
	    id = dobj.id;
	    
	    sliderStart = findy(document.getElementById(id + 'Wrapper'));
	    mousey = nn6 ? ty + e.clientY - y: ty + event.clientY -y;
	    
	    //get the number of boxes the slider is split into
	    elems = document.getElementById(id + 'Wrapper').getElementsByTagName('div').length - 1;
		
	    sliderPos = dobj.offsetTop - sliderStart + 12;
	    sliderBox = (sliderPos / (sliderRange/elems));
	    //this is the box the slider is on top of
	    sliderBox = Math.floor(sliderBox);
		
	    var copyBoxId = 'rulerColor' + id + '_' + sliderBox;
		
	    //This is what we call 'resist1' etc
	    idNum = id.replace('slider', '');

	    if(document.getElementById(copyBoxId))
		{
		    //		    document.getElementById('totalResistance').innerHTML = 'fired';
		    if ( document.getElementById(copyBoxId).innerHTML != dobj.innerHTML)
		        {
			    // make sure to do this first! I dont know why but it only works if you do this first!
			    document.getElementById(idNum).value = document.getElementById(copyBoxId).innerHTML.replace(/^\s*|\s*$/g,''); 
			    if(ie)
				{
				    replace_html(dobj.id, document.getElementById(copyBoxId).innerHTML);	
				    replace_html('totalResistance', getResistance());
				}
			    else
				{
				dobj.innerHTML = document.getElementById(copyBoxId).innerHTML;	
				document.getElementById('totalResistance').innerHTML =  getResistance();
				}
			    dobj.style.backgroundColor = document.getElementById(copyBoxId).style.backgroundColor;
			}
		    dobj.style.color = document.getElementById(copyBoxId).style.color;
		}

	    if ( mousey >= sliderStart && mousey < sliderStart + sliderRange - 12)
		{
		    if (isdrag)
			{
			    numerical_top = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
			    dobj.style.top = numerical_top + 'px';
			    return false;
			}
		    
		}
	}
    }

/*
 * formats resist1~4 to readable resistor value.
 * also sets hidden post data ohms and perc (these are sent to be compared with session data)
 */
function getResistance()
{
    resist1 = document.getElementById('resist1').value;
    resist2 = document.getElementById('resist2').value;
    resist3 = document.getElementById('resist3').value;
    resist4 = document.getElementById('resist4').value;
    
    resist = parseInt(resist1 + resist2) * Math.pow(10, resist3);

    document.getElementById('ohms').value = resist;
    document.getElementById('perc').value = resist4;
	
    if( resist >= 1000000)
	{
	    resist = resist / 1000000;
	    resist = resist + 'M&#8486;';
	}
    else if( resist >= 1000)
	{
	    resist = resist / 1000;
	    resist = resist + 'K&#8486;';
	}
    else
	{
	    resist = resist + '&#8486;';
	}
    resist = resist + '+/- ' + resist4 + '%';
	
    return resist;
}

/*
 * Bound to event handler onMouseDown
 * fires if onMouseDown is on an element with class='slider'
 * calls mousemove to do actual moving
 */
function selectmouse(e) 
{

    
    var fobj       = nn6 ? e.target : event.srcElement;
    var topelement = nn6 ? "HTML" : "BODY";
    


    while (fobj.tagName != topelement && fobj.className != "slider")
	{
	    fobj = nn6 ? fobj.parentNode : fobj.parentElement;
	}

    if (fobj.className=="slider")
	{
	    isdrag = true;
	    dobj = fobj;
	    ty = parseInt(dobj.offsetTop+0);
	    y = nn6 ? e.clientY : event.clientY;

	    document.onmousemove=movemouse;
	    
		
	    return false;
	}
}

/*
 * replace innerHTML in el with html (IE fix)
 */
function replace_html(el, html) 
{
    if( el ) 
	{
	    var oldEl = document.getElementById(el);
	    var newEl = oldEl.cloneNode(true);
	
	    //If this is the moving element we need to keep that in newEl
	    var dobby = (dobj == oldEl) ? true : false;

	    //set the new HTML and insert back into the DOM
	    newEl.innerHTML = html;
	    if(oldEl.parentNode)
		{
		    oldEl.parentNode.replaceChild(newEl, oldEl);
		    if(dobby)
			{
			    dobj = newEl;
			}
		}
	}
}


/* 
 * return the actual Y offset of obj (as with most things, this is an IE fix)
 */
function findy(obj)
{
    var top = 0;
    if (obj.offsetParent)
	{
	    do {
		top += obj.offsetTop;
	    }while(obj = obj.offsetParent);
	}
    return top;
}

//initialize!
init_slider();

