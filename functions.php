<?php

//Load white label custom CSS login page
 
function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}

add_action('login_head', 'my_custom_login');
 
//Login Logo Text updated

function my_login_logo_url() {
	return get_bloginfo( 'url' );
}

add_filter( 'login_headerurl', 'my_login_logo_url' );
	function my_login_logo_url_title() {
	return 'The Hoffman Company';
}

add_filter( 'login_headertitle', 'my_login_logo_url_title' ); 

//Set the Remember Me checked on by default

function login_checked_remember_me() {
add_filter( 'login_footer', 'rememberme_checked' );
}

add_action( 'init', 'login_checked_remember_me' );
	function rememberme_checked() {
	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}

// Change the footer text in the dashboard

add_filter('admin_footer_text', 'change_footer_admin');

function change_footer_admin () { 
 
  echo 'The Hoffman Company &copy;. Theme powered by <a href="http://www.zumatech.com" target="_blank">Zuma Technology</a>';
 
}

// Add a custom contact widget to the dashboard

add_action('wp_dashboard_setup', 'zt_add_dashboard_widgets' );
	function zt_add_dashboard_widgets() {
	wp_add_dashboard_widget('wp_dashboard_widget', 'Support Contact', 'zt_theme_info');
}
 
function zt_theme_info() {
  echo "<p>If you have any questions about the backend, please do not hesitate to contact Zuma Technology</p>
  <ul>
  <li><strong>Developed By:</strong> Zuma Technology</li>
  <li><strong>Website:</strong> <a href='http://www.zumatech.com' target='_blank'>www.zumatech.com</a></li>
  <li><strong>Contact:</strong> <a href='mailto:support@zumatech.com?subject=Hoffman Company Website Support'>support@zumatech.com</a></li>
  </ul>";
}

/*  
add_action('wp_dashboard_setup', 'zt_add_dashboard_widgets' );
	function zt_add_dashboard_widgets() {
	wp_add_dashboard_widget('wp_dashboard_widget', 'Helpful Guides', 'zt_theme_info');
}

function zt_theme_info() {
  echo "<p>In order to use your customized content management in an efficient manner, we have provided steps for performing mundane activities.</p>
  		<p><strong>Adding Images</strong><br />
  		<ol>
  			<li>Click on the <strong>Content</strong> link</li>
  			<li>Look for the <strong>Add New</strong> button located at the top</li>
  			<li>A new dropdown menu will appear, you can either <strong>Drag</strong> the image from a folder or click on the <strong>Select Files</strong?</li>
  			<li>If you click on <strong>Select Files</strong> a new window will open were you can locate the file you'd like to upload</li>
  			<li>Select the file and click on <strong>Open</strong></li>
  			<li>The image will be added and you can now name the file, add links to the image, and other customizeable tasks</li>
  		</ol>";
}
*/

/* Add a custom tutorial widget to the dashboard

add_action('wp_dashboard_setup', 'tutorial_add_dashboard_widgets' );
	function tutorial_add_dashboard_widgets() {
	wp_add_dashboard_widget('wp_dashboard_widget', 'Tutorials', 'tutorial_theme_info');

function tutorial_theme_info() {
	echo "<p><strong>Add Image To Blog Post / Website Page</strong><br/>From the Blog Post or Main Pages edit screen look for the Media button. Within the Media window look to the right of “Upload/Insert.” Click on the first Icon and follow the instructions on screen</p>";
} */

/** REMOVE DASHBOARD WIDGETS **/
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
function remove_dashboard_widgets() {

global $wp_meta_boxes;
//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

remove_action( 'wp_version_check', 'wp_version_check' );
remove_action( 'admin_init', '_maybe_update_core' );
add_filter( 'pre_transient_update_core', create_function( '$a', "return null;" ) );

} 
/** END REMOVE DASHBOARD WIDGETS **/

/* Remove at a glance and dashboard activity */
add_action( 'wp_dashboard_setup', 'zt_remove_ataglance' );
	function zt_remove_ataglance() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
}

/** MODAL POPUP LEAD FORM  **/

function HoffmanModalLeadForm(){ ?>

<!-- Trigger/Open The Modal -->
<button id="myBtn" class="hoffmanModalButton lt-button primary">Want to sell your land?</button>
<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onClick="CloseHoffmanPopup()">x</span>
    <p><?php echo do_shortcode('[contact-form-7 id="1492" title="Pop up Lead Form"]'); ?></p>
  </div>
</div>
<script type="text/javascript">
var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
    modal.style.display = "block";
    }
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
function CloseHoffmanPopup(){
modal.style.display = "none";
}
</script>
<?php 

} //close function

/** MODAL POPUP SHORTCODE **/
add_shortcode( 'hoffmanmodal', 'HoffmanModalLeadForm' );




?>