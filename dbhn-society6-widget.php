<?php
/*
Plugin Name: Society6 Widget
Plugin URI: http://www.designbyhn.se/
Description: Easily add a store banner to your site
Version: 1.1
Author: Henrik Norberg
Author URI: http://www.designbyhn.se/
License: GPL2
*/

add_action("widgets_init", array('Society6_banner', 'register'));
register_activation_hook( __FILE__, array('Society6_banner', 'activate'));
register_deactivation_hook( __FILE__, array('Society6_banner', 'deactivate'));
class Society6_banner {
  function activate(){
    $data = array('titlestore' => 'My Society6 store', 'option1' => 'dbhn', 'option2' => '250x250', 'option3' => 'Yes');
    if ( ! get_option('society6_banner')){
      add_option('society6_banner' , $data);
    } else {
      update_option('society6_banner' , $data);
    }
  }
  
 function control(){
  $data = get_option('society6_banner');
  ?>
  
  <!-- SETTINGS -->
  
    <p><label>Title: <input name="society6_banner_titlestore"
type="text" value="<?php echo $data['titlestore']; ?>" /></label></p>

  <p><label>Your Society6 Username:<br /><input name="society6_banner_option1"
type="text" value="<?php echo $data['option1']; ?>" /></label></p>

<p><label>Choose ad size to Display:</label> 
<select name="society6_banner_option2">
  <option <?php if ($data['option2'] == "250x250"){echo 'selected="selected"';} ?>>250x250</option>
  <option <?php if ($data['option2'] == "150x150"){echo 'selected="selected"';} ?>>150x150</option>
  <option <?php if ($data['option2'] == "125x125"){echo 'selected="selected"';} ?>>125x125</option>
</select></p>

<p><label>Credit Me? (I'll Love You!)</label>
  <select name="society6_banner_option3">
  <option <?php if ($data['option3'] == "Yes"){echo 'selected="selected"';} ?>>Yes</option>
  <option <?php if ($data['option3'] == "No"){echo 'selected="selected"';} ?>>No</option>
</select></p>

  <?php
   if (isset($_POST['society6_banner_option1'])){
   	$data['titlestore'] = attribute_escape($_POST['society6_banner_titlestore']);
    $data['option1'] = attribute_escape($_POST['society6_banner_option1']);
    $data['option2'] = attribute_escape($_POST['society6_banner_option2']);
    $data['option3'] = attribute_escape($_POST['society6_banner_option3']);
    update_option('society6_banner', $data);
  }
}


  function deactivate(){
    delete_option('society6_banner');
  }
  function widget($args){
  	$data = get_option('society6_banner');
    echo $args['before_widget'];
    echo $args['before_title'] . $data['titlestore'] . $args['after_title'];
    echo '	<div id="store_update_list">
			<script type="text/javascript">
			<!--
				s6_user = "'.$data['option1'].'";
				s6_format = "'.$data['option2'].'"; 
			//-->
			</script>
			<script type="text/javascript" src="http://society6.com/js/show_banner.js"></script></div>';

if ($data['option3'] == "Yes"){
echo '<p>Widget by: <a href=" http://www.designbyhn.se/">Design by HN</a></p>';} else {}

echo $args['after_widget'];
  }
function register(){
    register_sidebar_widget('Society 6 Widget', array('society6_banner', 'widget'));
    register_widget_control('Society 6 Widget', array('society6_banner', 'control'));
  }
}

//tested

?>