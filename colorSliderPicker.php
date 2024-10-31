<?php
class colorSliderPicker
{
  function colorSliderPicker()
  {

  }

  function draw_outbox()
  {
    ?>
    
    <div id="totalResistance">0&#8486+/- 5%</div>
      <input type="hidden" name="ohms" id="ohms"  value="" />
      <input type="hidden" name="perc" id="perc"  value="5" />
    <?php
  }
  function draw_input_form($colors, $name)
  {
    $ary = array_keys($colors);
				       
    ?>
    <div class="formWrapper" >
      <input type="hidden" id="<?php echo $name; ?>"  name="<?php echo $name; ?>" value="<?php echo $ary[0]; ?>" /> 
<!--       <div id="<?php echo $name;?>Show" class="inputFake" ><?php echo $ary[0]; ?></div> -->
      <br />
      <div class="sliderWrapper rounded" id="slider<?php echo $name; ?>Wrapper">
      <div class="slider" id="slider<?php echo $name; ?>" onselectstart="return false" 
      <?php 
	 echo 'style="background-color: #' .  $colors[$ary[0]] . ';';
	 if($colors[0] == '000000'){echo 'color: #FFFFFF";'; }
         echo '">';  
	 
	 echo $ary[0];b
	 ?> 
      
      </div>
      <?php
	$count = 0;
      foreach ($colors as $key=> $value)
      {
	
	?>
	<div class="rulerColor" id="rulerColorslider<?php echo $name . '_' . $count; ?>" 
	style="background-color: #<?php 
echo $value;
if ($value == '000000')
{
echo '; color: #FFFFFF';
}
$boxHeight = floor(200/count($colors));
$padding = (($boxHeight/2) - 10);
echo '; height: ' . $boxHeight  .'px; line-height: ' . $boxHeight . 'px;';
?>" onselectstart="return false">
	  <?php echo $key; ?>
	</div>
	<?php
	    $count++;
      }

      ?>
      </div>
    </div>
      
    <?php
  }
}

?>
