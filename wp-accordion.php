<?php 
/*
Plugin Name: WP-Accordion
Plugin URI: http://janbee-myjquery.pcriot.com/
Description: Accordion your widget
Version: 1.0
Author: JanBee Angeles
Author URI: http://janbee-myjquery.pcriot.com/
License: GPL2
*/          
error_reporting(E_ALL);  
add_action('widgets_init',  'accordion', 1);
add_action("widgets_init", array('Accordion', 'register'));    

register_activation_hook( __FILE__, array('Accordion', 'activate'));
register_deactivation_hook( __FILE__, array('Accordion', 'deactivate'));

function accordion(){
    if (function_exists('register_sidebar')){
        register_sidebar(array(
            'name' => 'Accordion',
            'id' => 'bee_accordion',
            'description' => 'drop widget that you want to be accordionized'
        ));
    }
}

class Accordion
{
    function activate(){
        $data = array( 
            'title' => '',
            'jq' => 'on',
            'mode' => 'all',
            'default' => 'one' 
        );
        if ( ! get_option('widget_accordionizer')){
            add_option('widget_accordionizer' , $data);
        } 
        else {
            update_option('widget_accordionizer' , $data);
        }
    }     
    function deactivate(){
        delete_option('widget_accordionizer');
    }
    
     
    function widget($args){
        global $wp_registered_widgets;       
        
        $data = get_option('widget_accordionizer'); 
        $jq = $data['jq'] == 'on' ? '<script type="text/javascript" src="wp-content/plugins/wp-accordion/js/jquery-1.4.2.min.js"></script>' : '';
        echo $args['before_widget'];  
        echo $args['before_title'] . $data['title'] . $args['after_title']; 
        echo $jq.'
            
            <script type="text/javascript" src="wp-content/plugins/wp-accordion/js/help.js"></script>
            <link rel="stylesheet" type="text/css" href="wp-content/plugins/wp-accordion/css/help.css"> 
            <ul class="accWidget">';
            dynamic_sidebar('bee_accordion');    
        echo '</ul>
        <form name="hidden">
            <input type="hidden" id="mode" value="'.$data['mode'].'"/>
            <input type="hidden" id="default" value="'.$data['default'].'"/>
        </form>
        ';
        echo $args['after_widget'];     
    }

    function control_admin(){   
        $data = get_option('widget_accordionizer');
        $jqCheck = $data['jq'] == 'on' ? '<input class="" name="jqCheck" type="checkbox" checked />'
                                       : '<input class="" name="jqCheck" type="checkbox"  />';
        $jqDefault = $data['default'] == 'one' ? '<input type="checkbox" name="accDef" value="one" checked>'                   
                                               : '<input type="checkbox" name="accDef" value="one" >';
        $jqMode = $data['mode'] == 'all' ? '<input type="radio" name="accMode" value="one">Slide One 
                                            <input type="radio" name="accMode" value="all" checked>Slide All'
                                         :  '<input type="radio" name="accMode" value="one" checked>Slide One 
                                             <input type="radio" name="accMode" value="all">Slide All' ;  
        
        $html = '
        <div style="text-align:left">
            <label>Title:</label>
            <br>
            <input class="cPanel" name="title" type="text" value="'.$data['title'].'" />
            <label>Open one Widget By Default</label>
            '.$jqDefault.'
            <br>
            <hr>
            <label>Accordion Mode</label>
            <br>
            
            '.$jqMode.'
            <br>
            <hr>
            <label>This plugin requires a jQuery 1.3 or higher if you have a jq already unchecked the checkbox </label><br>
            '.$jqCheck.'
            
        </div>
        
        ';
        echo $html; 
        if (!empty($_POST)){ 
            if(!empty($_POST['jqCheck'])) {
                $data['jq'] = attribute_escape($_POST['jqCheck']);
            }
            else{
                $data['jq'] = 'off';
            }
            if(!empty($_POST['accDef'])) {
                 $data['default'] = attribute_escape($_POST['accDef']);
            }
            else{
                $data['default'] = 'none';
            }
            
            $data['mode'] = attribute_escape($_POST['accMode']);        
            $data['title'] = attribute_escape($_POST['title']);         
            update_option('widget_accordionizer', $data);  
        }
        
    }

    function register(){          
        register_sidebar_widget('WP-Accordion', array('Accordion', 'widget'));
        register_widget_control('WP-Accordion', array('Accordion', 'control_admin'));
    }
}

?>
