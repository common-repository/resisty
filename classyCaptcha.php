<?php
class classyCaptcha
{

  /*
   * CONSTRUCTOR
   */
  function classyCaptcha()
  {

    add_action('comment_form', array('classyCaptcha', 'output_form'));
    add_action('comment_post', array('classyCaptcha', 'validate_resistor'));
  }
  /* 
   *Draw the form, place it above the submit button
   */
  function output_form($id)
  {
    ?>

    <script type="text/javascript">
      // This is a hack to work around the strange MOD Rewrite rules we have on the dev server. 
      // It works fine but in reality we should be using the other commented code, below
      <?php include('resistorScript.js'); ?>
      
      // load javascript and css into the head of the documnt
      //      var filejavascript=document.createElement('script');
      //      filejavascript.setAttribute("type","text/javascript");
      //      filejavascript.setAttribute("src", "resistorScript.js");
      //      document.getElementsByTagName("head")[0].appendChild(filejavascript);
      //
      // css
      //      var filestyle=document.createElement("link");
      //      filestyle.setAttribute("rel", "stylesheet");
      //      filestyle.setAttribute("type", "text/css");
      //      filestyle.setAttribute("href", "resistorStyle.css");
      //      document.getElementsByTagName("head")[0].appendChild(filestyle);

    </script>
	<style language="text/css" >
	<?php include('resistorStyle.css'); ?> 
	</style>

    <div id="cResist">
      <div id="resistorError" style="font-size: 14px; font-weight: bold; color: #FF0000;"><?php if(isset($_POST['resistorError'])) echo "Your resistor value is incorrect!"; ?></div>
      <div class="fullWidth">Prove you are human by reading this resistor:</div>
      <div class="col45">
          <img id="resistorImagePNG" src="<?php bloginfo('url'); ?>/wp-content/plugins/resisty/resistorImage.php" />
          <div class="fullWidth" >

<?php 

    include("colorSliderPicker.php");
    
    $colors = array('000000', '643200', 'FF0000', 'FF9600', 'FFFF00', '00FF00', '0000FF', 'FF00FF', '646464', 'FFFFFF');
    $percs = array(  '5' => 'e9e914',
		     '10'=> 'b3b3b3',
		     '20' => 'f1c43a');
    $colorSlider = new colorSliderPicker();

    $colorSlider->draw_outbox();
?>
    <div id="allSliders">
<?php
    $colorSlider->draw_input_form($colors, 'resist1');
    $colorSlider->draw_input_form($colors, 'resist2');
    $colorSlider->draw_input_form($colors, 'resist3');
    $colorSlider->draw_input_form($percs, 'resist4');
?>
      </div>
      </div>
    </div>

	  <div class="col45" style="text-align: left;">

	  <br />
	  Match the sliders on the left to each color band on the resistor. <br /><br />
	<a href="#postcomment" onClick="javascript: document.getElementById('resistorImagePNG').src = '<?php bloginfo('url'); ?>/wp-content/plugins/resisty/resistorImage.php?' + (new Date()).getTime()">Click Here</a> for a new resistor image.
<br /><br />
	  If you'd like to learn more, read about resistor color codes <a href="http://en.wikipedia.org/wiki/Electronic_color_code" target="_blank">here</a>.
<br /><br />
	  </div>
</div>
    <script type="text/javascript">
      //<![CDATA[

    var commentForm = document.getElementById('submit');
    var commentArea = commentForm.parentNode;
    var captchafrm = document.getElementById("cResist");
    commentArea.insertBefore(captchafrm, commentForm);
    


document.getElementById('comment').value = "<?php $trans = array("\r" => '\r', "\n" => '\n');echo strtr($_POST['comment1'], $trans); ?>";

document.getElementById('author').value = '<?php echo $_POST['name1']; ?>';
document.getElementById('email').value = '<?php echo $_POST['email1']; ?>';
document.getElementById('url').value = '<?php echo $_POST['url1']; ?>';


    //]]>
</script>
   

 <?php
//'
    
  }



  /*
   * Validate the captcha code
   */
  function validate_resistor($id)
  {
        session_start();
    $rezzy = $_POST['ohms'] + $_POST['perc'];
    
    
    if(md5($rezzy) == $_SESSION['randomResistor'])
      {
	return $id;
      }
    else
      {
	wp_delete_comment($id);
	?>
<html>
       <head><title>Invalid Code</title></head>
   <body>
   <form name="data" action="<?php echo $_SERVER['HTTP_REFERER']; ?>#postcomment" method="post">
   <input type="hidden" name="resistorError" value="error" />
   <input type="hidden" name="name1" value="<?php echo $_POST['author']; ?>" />
   <input type="hidden" name="email1" value="<?php echo $_POST['email']; ?>" />
   <input type="hidden" name="url1" value="<?php echo $_POST['url']; ?>" />
   <textarea style="display:none;" name="comment1"><?php $trans = array("\\" => '', "\\\\" =>"\\");echo strtr($_POST['comment'], $trans); ?></textarea>
   </form>
   <script type="text/javascript">
	 <!--
	 document.forms[0].submit();
	//-->
   </script>
	    </body>
	    </html>
<?php

      }
  
  }
}


?>
