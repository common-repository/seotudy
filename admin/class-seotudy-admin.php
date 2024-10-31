<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.webtures.com.tr
 * @since      1.0.0
 *
 * @package    Seotudy
 * @subpackage Seotudy/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Seotudy
 * @subpackage Seotudy/admin
 * @author     Webtures A.Ş <hasan.yuksektepe@webtures.com>
 */
class Seotudy_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		
		global $notice_text,$notice_type;
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		//POST UPDATE
		add_action( 'post_updated', array(&$this, 'seotudy_post_update') , 10, 3);
		//POST UPDATE
		
		//AUTO SAVE
		add_action( 'save_post', array(&$this, 'seotudy_save') );
		//add_action( 'edit_tags', array(&$this, 'seotudy_save') );
		//add_action( 'edited_category', array(&$this, 'seotudy_save'));
		//add_action( 'edit_term', array(&$this, 'seotudy_save') );
		//add_action( 'category_edit_form', array(&$this, 'seotudy_save') );
		//add_action( 'edit_tax', array(&$this, 'seotudy_save') );
		//AUTO SAVE
		
		//ADD MENU
		add_action( 'admin_menu', array(&$this, 'register_seotudy_seo_menu'));
		//ADD MENU
		
        //TAG DENSTY META BOX ADD
        add_action( 'add_meta_boxes', array(&$this, 'seotudy_tag_density_add_meta_box') );
        //TAG DENSTY META BOX ADD
		
        //H TAG PROPOSAL META BOX ADD
		if(get_option( 'seotudy_autoHtag')){
			add_action( 'add_meta_boxes', array(&$this, 'seotudy_auto_h_tag_add_meta_box') );
		}
        //H TAG PROPOSAL META BOX ADD
		
        //SEO SETTINGS META BOX ADD
		if(get_option( 'seotudy_titleAndDescActive')){
			add_action( 'add_meta_boxes', array(&$this, 'seotudy_seo_settings_add_meta_box') );
			//add_action( "category_edit_form_fields", array(&$this, 'seotudy_seo_settings_html'));
		}
        //SEO SETTINGS META BOX ADD
        
		//AJAX POST
		add_action( 'wp_ajax_seotudy_ajax_post', array($this, 'seotudy_ajax_post'));
		//AJAX POST
		
		//ALL IN ONE SEO AND YOAST CONTROL
		include_once( ABSPATH . 'wp-admin/includes/plugin.php');
		if(is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php') and get_option('seotudy_titleAndDescActive',true)){
			$notice_text = 'You are using the "All in one SEO Pack" plugin. This may prevent Seotudy from working. <a href="admin.php?page=seotudy-settings">Please make your settings.</a>';
			$notice_type = 'error';
			add_action( 'admin_notices',  array($this, 'seotudy_notice'));
		}else if(is_plugin_active('wordpress-seo/wp-seo.php') and get_option('seotudy_titleAndDescActive',true)){
			$notice_text = 'You are using the "Yoast" plugin. This may prevent Seotudy from working. <a href="admin.php?page=seotudy-settings">Please make your settings.</a>';
			$notice_type = 'error';
			add_action( 'admin_notices',  array($this, 'seotudy_notice'));
		}
		//ALL IN ONE SEO AND YOAST CONTROL
		
	}
	
	//AUTO H TAG META BOX
    function seotudy_auto_h_tag_add_meta_box() {
        
        $post_types = get_post_types('','names');
		//print_r($post_types);
        unset($post_types['attachment']);
        unset($post_types['revision']);
        unset($post_types['nav_menu_item']);
        unset($post_types['custom_css']);
        unset($post_types['customize_changeset']);
        unset($post_types['oembed_cache']);
        $post_types['category'] = 'category';
        foreach ( $post_types as $post_type ) {
            
            add_meta_box(
                'seotudy-auto-h-tag-proposal',
                __( 'Seotudy - Auto H Proposal (BETA)', 'seotudy' ),
                array(&$this,'seotudy_auto_h_tag_add_meta_box_html'),
                $post_type,
                'advanced',
                'core'
            );
           
        }        
    }
    function seotudy_auto_h_tag_add_meta_box_html( $post) {
        wp_nonce_field( '_seotudy_nonce', 'seotudy_nonce' ); 
        require (__DIR__).'/partials/seotudy-auto_h_tag-meta-box.php';
    }
	//AUTO H TAG META BOX
	
	//AUTO SAVE
	function seotudy_save( $post_id ) {
		global $post;
		
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! isset( $_POST['seotudy_nonce'] ) || ! wp_verify_nonce( $_POST['seotudy_nonce'], '_seotudy_nonce' ) ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		
		//SAVE
		if(isset($post->ID)){
			//POST TITLE AND DESC SAVE
			if ( isset( $_POST['seotudy_title'] ) ){
				$title = trim($_POST['seotudy_title']);
				if(empty($title)){
					$title = get_option( 'seotudy_'.get_post_type($post_id).'_title' );
				}
				update_post_meta( $post_id, 'seotudy_title', $title );
			}
			if ( isset( $_POST['seotudy_description'] ) ){
				$desc = trim($_POST['seotudy_description']);
				if(empty($desc)){
					$desc = get_option( 'seotudy_'.get_post_type($post_id).'_desc' );
				}
				update_post_meta( $post_id, 'seotudy_description', $desc );
			}
			//POST SEOTUDY TITLE AND DESC SAVE
		}else if(isset($_POST['tag_ID'])){
			/*
			$term_id = $_POST['tag_ID'];
			
			update_term_meta( 1, 'seotudy_title', 3 );
			
			if ( isset( $_POST['seotudy_title'] ) ){
				$title = trim($_POST['seotudy_title']);
				if(empty($title)){
					$title = get_option( 'seotudy_'.$_POST['taxonomy'].'_title' );
				}
				update_term_meta( 1, 'seotudy_title', 3 );
			}
			if ( isset( $_POST['seotudy_description'] ) ){
				$desc = trim($_POST['seotudy_description']);
				if(empty($desc)){
					$desc = get_option( 'seotudy_'.$_POST['taxonomy'].'_desc' );
				}
				update_term_meta( 1, 'seotudy_description', 2 );
			}
			*/
		}
		//SAVE
		
    }
	//AUTO SAVE
	
	//POST UPDATE
	function seotudy_post_update($post_ID, $np, $op){
		global $wpdb;
		
		if($op->post_name != $np->post_name and !empty($op->post_name) and !stristr($np->post_name,'trashed')){
			$add = $wpdb->query("INSERT INTO seotudy_links SET link='/".$op->post_name."',new_link='/".$np->post_name."',status='change'");
		}else if(stristr($np->post_name,'trashed')){
			$add = $wpdb->query("INSERT INTO seotudy_links SET link='/".$op->post_name."',new_link='/',status='404'");
		}
		
	}
	//POST UPDATE
    
	//ADD CUSTOM TYPE SEO SETTING METABOX
	function seotudy_seo_settings_add_meta_box() {
        
        $post_types = get_post_types('','names');
        unset($post_types['attachment']);
        unset($post_types['revision']);
        unset($post_types['nav_menu_item']);
        unset($post_types['custom_css']);
        unset($post_types['customize_changeset']);
        unset($post_types['oembed_cache']);
		$post_types['category'] = 'category';
        foreach ( $post_types as $post_type ) {
            
            add_meta_box(
                'seotudy-seo-settings',
                __( 'Seotudy - SEO Settings', 'seotudy' ),
                array(&$this,'seotudy_seo_settings_html'),
                $post_type,
                'advanced',
                'core'
            );
           
        }  
		
    }
	function seotudy_seo_settings_html($post) {
        //wp_nonce_field( '_seotudy_nonce', 'seotudy_nonce' ); 
        require (__DIR__).'/partials/seotudy-seo-settings-meta-box.php';
    }
	//ADD CUSTOM TYPE SEO SETTING METABOX
	
	//NOTICE
	function seotudy_notice(){
        global $notice_text,$notice_type;
        ?>
        <div class="notice notice-<?=$notice_type?> is-dismissible">
            <p><?=__( $notice_text, 'seotudy' );?></p>
        </div>
        <?php
    }
	//NOTICE
	
	//AJAX POST
	public function seotudy_ajax_post(){
        global $wpdb;
        $post = $this->seotudy_postSecurty($_POST);
        extract($post);	
		switch($type){
			case 'seotudy-error-link-save':
			   
			   $postName = ['errorID','errorNewLink'];
			   if($this->seotudy_postControl($postName)){
				   $save = $wpdb->query("UPDATE seotudy_links SET new_link = '".$errorNewLink."' WHERE id='".$errorID."'");
				   if($save){
					   _e('Success','seotudy');
				   }else{
					   _e('Error','seotudy');
				   }
			   }else{
				   wp_die(__('Error Save Error','seotudy'));
			   }
			break;

			case 'seotudy-error-link-delete':
			   
			   $postName = ['errorID'];
			   if($this->seotudy_postControl($postName)){
				   $save = $wpdb->query("DELETE FROM seotudy_links WHERE id='".$errorID."'");
				   if($save){
					   _e('Success','seotudy');
				   }else{
					   _e('Error','seotudy');
				   }
			   }else{
				   wp_die(__('Error Save Error','seotudy'));
			   }
			break;


			case 'seotudy-redirects-link-save':
			   
			   $postName = ['redirectsID','redirectsNewLink'];
			   if($this->seotudy_postControl($postName)){
				   $save = $wpdb->query("UPDATE seotudy_links SET new_link = '".$redirectsNewLink."' WHERE id='".$redirectsID."'");
				   if($save){
					   _e('Success','seotudy');
				   }else{
					   _e('Error','seotudy');
				   }
			   }else{
				   wp_die(__('Error Save Error','seotudy'));
			   }
			break;

			case 'seotudy-redirects-link-delete':
			   
			   $postName = ['redirectsID'];
			   if($this->seotudy_postControl($postName)){
				   $save = $wpdb->query("DELETE FROM seotudy_links WHERE id='".$redirectsID."'");
				   if($save){
					   _e('Success','seotudy');
				   }else{
					   _e('Error','seotudy');
				   }
			   }else{
				   wp_die(__('Error Save Error','seotudy'));
			   }
			break;
			
			case 'seotudy-general-settings-save':
			    
				parse_str($form,$output);
				extract($output);
				
			    //SAVE
				$r = ['step']; //REQUIRED POST
				if(isset($step) and $step == 'general'){
					
					update_option( 'seotudy_googleAnalyticCode', $googleAnalyticCode,false);
					update_option( 'seotudy_googleSCCode', $googleSCCode,false);
					update_option( 'seotudy_yandexMetrica', $yandexMetrica,false);
					update_option( 'seotudy_wordpressSsl', (isset($wordpressSsl)?$wordpressSsl:''),false);
					update_option( 'seotudy_wpjson', (isset($wpjson)?$wpjson:''),false);
					update_option( 'seotudy_wordpressSsl', (isset($wordpressSsl)?$wordpressSsl:''),false);
					update_option( 'seotudy_autoSefName', (isset($autoSefName)?$autoSefName:''),false);
					update_option( 'seotudy_autoHtag', (isset($autoHtag)?$autoHtag:''),false);
					update_option( 'seotudy_titleAndDescActive', (isset($titleAndDescActive)?$titleAndDescActive:''),false);
					update_option( 'seotudy_autoAlt', (isset($autoAlt)?$autoAlt:''),false);
					update_option( 'seotudy_ogTag', (isset($ogTag)?$ogTag:''),false);
					
					echo __('Save','seotudy');
					
				}else if(isset($step) and $step == 'filemanagers'){
					
					$htaccessFile = ABSPATH.'.htaccess';
					if ( file_exists( $htaccessFile ) ) {
						$htaccess = stripslashes( $output['htaccess'] );
						if ( is_writeable( $htaccessFile ) ) {
							$f = fopen( $htaccessFile, 'w+' );
							fwrite( $f, $htaccess );
							fclose( $f );
						}
					}
					
					$robotsFile = ABSPATH.'robots.txt';
					if ( file_exists( $robotsFile ) ) {
						$robotstxt = stripslashes( $output['robotstxt'] );
						if ( is_writeable( $robotsFile ) ) {
							$f = fopen( $robotsFile, 'w+' );
							fwrite( $f, $robotstxt );
							fclose( $f );
						}
					}
					
					echo __('Save','seotudy');
					
					//file_put_contents(ABSPATH.'.htaccess',$htaccess);
					//file_put_contents(ABSPATH.'robots.txt',$robotstxt);
					
				}else{
					echo 33;
				}
				//SAVE
			   
			break;
			
			case 'seotudy-title-desc-save':
				
				parse_str($form,$output);
				extract($output);
				
				//SAVE
				$r = ['step']; //REQUIRED POST
				if(isset($step) and  $step == 'home'){
					
					update_option( 'seotudy_home_title', $seotudy_home_title,false);
					update_option( 'seotudy_home_desc', $seotudy_home_desc,false);
					
				}else if(isset($step) and  $step == 'titles'){
					
					$post_types = get_post_types('','names');
					unset($post_types['attachment']);
					unset($post_types['revision']);
					unset($post_types['nav_menu_item']);
					unset($post_types['custom_css']);
					unset($post_types['customize_changeset']);
					unset($post_types['oembed_cache']);
					foreach($post_types as $post_type){
						$a = get_post_type_object($post_type);
						$postName = (string) $a->name;
						update_option( 'seotudy_'.$postName.'_title', ${'seotudy_'.$postName.'_title'},false);
						update_option( 'seotudy_'.$postName.'_desc',  ${'seotudy_'.$postName.'_desc'},false);
					}
					
				}else if(isset($step) and  $step == 'taxonomy'){
					
					$post_types = get_post_types('','names');
					$taxonomy = get_object_taxonomies($post_types,'objects');
					foreach ($taxonomy as $t) {
						if($t->rewrite != null){
							
							update_option( 'seotudy_'.$t->name.'_title', ${'seotudy_'.$t->name.'_title'},false);
							update_option( 'seotudy_'.$t->name.'_desc',  ${'seotudy_'.$t->name.'_desc'},false);
						}
					}
					
				}else if(isset($step) and  $step == 'media'){
					update_option( 'seotudy_attachment_title', $seotudy_attachment_title,false);
					update_option( 'seotudy_attachment_desc', $seotudy_attachment_desc,false);
				}
				//SAVE
				
				echo __('Save','seotudy');
			break;
			
			default:
			   _e('hahahaha :)','seotudy');
			break;
        }
        exit;
    }
	//AJAX POST
	
    //TAG DENSITY META BOX
    function seotudy_tag_density_add_meta_box() {
        
        $post_types = get_post_types('','names');
		//print_r($post_types);
        unset($post_types['attachment']);
        unset($post_types['revision']);
        unset($post_types['nav_menu_item']);
        unset($post_types['custom_css']);
        unset($post_types['customize_changeset']);
        unset($post_types['oembed_cache']);
        $post_types['category'] = 'category';
        foreach ( $post_types as $post_type ) {
            
            add_meta_box(
                'seotudy-tag-densty',
                __( 'Seotudy - Tags Density', 'seotudy' ),
                array(&$this,'seotudy_tag_density_html'),
                $post_type,
                'advanced',
                'core'
            );
           
        }        
    }
    function seotudy_tag_density_html( $post) {
        wp_nonce_field( '_seotudy_nonce', 'seotudy_nonce' ); 
        require (__DIR__).'/partials/seotudy-tag-density-meta-box.php';
    }
	
	function ___register_term_meta_text() {
		register_meta( 'term', '__term_meta_text', array(&$this,'seotudy_tag_density_html'));
	}
	//TAG DENST META BOX
    
	//ADD MENU
	function register_seotudy_seo_menu(){
        add_menu_page(__('Seotudy','seotudy'), __('Seotudy','seotudy'), 'manage_options', 'seotudy-settings',array(&$this, 'seotudy_settings'),plugins_url( '/img/icon.png' , __FILE__),2);
		add_submenu_page( 'seotudy-settings', __('Settings','seotudy'), __('Settings','seotudy'), 'manage_options', 'seotudy-settings');
        if(get_option( 'seotudy_titleAndDescActive')){
			add_submenu_page( 'seotudy-settings', __('Title & Desc','seldos'), __('Title & Desc','seotudy'), 'manage_options', 'seotudy-title-desc',array(&$this, 'seotudy_title_desc'));
        }
        //add_submenu_page( 'seotudy-settings', __('Error (404) Page','seldos'), __('Error (404) Page','seotudy'), 'manage_options', 'seotudy-error-page',array(&$this, 'seotudy_error_page'));
        add_submenu_page( 'seotudy-settings', __('Redirects','seldos'), __('Redirects','seotudy'), 'manage_options', 'seotudy-redirects-page',array(&$this, 'seotudy_redirects_page'));
        add_submenu_page( 'seotudy-settings', __('Backlink List','seldos'), __('Backlink List','seotudy'), 'manage_options', 'seotudy-backlink-list-page',array(&$this, 'seotudy_backlink_list_page'));
        //add_submenu_page( 'seotudy-settings', __('SEO Appearance','seldos'), __('SEO Appearance','seldos'), 'manage_options', 'seotudy-apperance',array(&$this, 'seotudy_apperance'));
        //add_submenu_page( 'seotudy-settings', __('SEO Redirects','seldos'), __('SEO Redirects','seldos'), 'manage_options', 'seotudy-redirects',array(&$this, 'seotudy_redirects'));
    }
	//ADD MENU
	
	//SETTINGS MENU CONTENT
	function seotudy_title_desc(){
        require plugin_dir_path(__FILE__).'partials/seotudy-title-desc.php';
    }
	//SETTINGS MENU CONTENT
	
	//SETTINGS MENU CONTENT
	function seotudy_settings(){
        require plugin_dir_path(__FILE__).'partials/seotudy-setting.php';
    }
	//SETTINGS MENU CONTENT
	
	//SETTINGS MENU CONTENT
	function seotudy_error_page(){
        require plugin_dir_path(__FILE__).'partials/seotudy-error-page.php';
    }
	//SETTINGS MENU CONTENT
	
	//SETTINGS MENU CONTENT
	function seotudy_redirects_page(){
        require plugin_dir_path(__FILE__).'partials/seotudy-redirects-page.php';
    }
	//SETTINGS MENU CONTENT
	
	//SETTINGS MENU CONTENT
	function seotudy_backlink_list_page(){
        require plugin_dir_path(__FILE__).'partials/seotudy-backlink-list-page.php';
    }
	//SETTINGS MENU CONTENT
	
	//POST SECTURTY
	function seotudy_postSecurty($post){
		global $mysqli;
		$degerler = array();
		foreach($post as $p => $d){
			if(is_string($_POST[$p]) === true){
				$degerler[$p] = addslashes(trim(strip_tags(($d))));
			}
		}
		return $degerler;
	}
	//POST SECTURTY
	
	//REQUIRED POST CONTROL
	function seotudy_postControl($post){
		
		$kontrol = 0;
		foreach($post as $parametre){
			if(isset($_POST[$parametre]) and !empty($_POST[$parametre])){
				$kontrol ++;
			}else{
				return false;
				break;
			}
		}
		
		if(count($post)==$kontrol){
			return true;
		}else{
			return false;
		}
		
	}
	//REQUIRED POST CONTROL
	
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function seotudy_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name.'-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-fontawesome', plugin_dir_url( __FILE__ ) . 'css/fontawesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/seotudy-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function seotudy_enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/seotudy-admin.js', array( 'jquery' ), $this->version, false );
	}

}
