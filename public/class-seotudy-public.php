<?php ob_start();

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.webtures.com.tr
 * @since      1.0.0
 *
 * @package    Seotudy
 * @subpackage Seotudy/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Seotudy
 * @subpackage Seotudy/public
 * @author     Webtures A.Ş <hasan.yuksektepe@webtures.com>
 */
class Seotudy_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		//GOOGLE ANALYTIC CODE ADD
		if(get_option( 'seotudy_googleAnalyticCode')){
            add_action('wp_footer', [$this,'seotudy_googleAnalyticCode']);
        }
		//GOOGLE ANALYTIC CODE ADD
		
		//GOOGLE SEARCH CONSOLE ADD
		if(get_option( 'seotudy_googleSCCode')){
            add_action('wp_head', [$this,'seotudy_googleSCCode']);
        }
		//GOOGLE SEARCH CONSOLE ADD
		
		//YANDEX METRIKA ADD
		if(get_option( 'seotudy_yandexMetrica' )){
            add_action('wp_footer', [$this,'seotudy_yandexMetrica']);
        }
		//YANDEX METRIKA ADD
		
		//WPJSON SECURITY
		if(get_option( 'seotudy_wpjson' )){
			if ( version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {
				require_once( plugin_dir_path( __FILE__ ) . '../includes/class-seotudy-disable-rest-api.php' );
				new Disable_REST_API( __FILE__ );
			} else {
				remove_action( 'wp_head','rest_output_link_wp_head');
				remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
				remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
				remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
				add_filter( 'json_enabled', '__return_false' );
				add_filter( 'json_jsonp_enabled', '__return_false' );
			}
		}
		//WPJSON SECURITY
		
		//AUTO ALT TAG
		if(get_option( 'seotudy_autoAlt' )){
			add_filter('image_send_to_editor', array( $this, 'seotudy_image_alt_public'), 10, 2);
			add_filter('wp_get_attachment_image_attributes', array( $this, 'seotudy_image_alt_public'), 10, 2);
		}
		//AUTO ALT TAG
		
		
		//OPEN GRAPH ADD
		if(get_option( 'seotudy_ogTag' )){
			add_action( 'wp_head', array(&$this, 'seotudy_ogTag' ) );
		}
		//OPEN GRAPH ADD
		
		
		//AUTO IMAGE SEF NAME
		if(get_option( 'seotudy_autoSefName' )){
			add_filter( 'sanitize_file_name', 'seotudy_filename', 10 );
			function seotudy_filename( $filename ){
				$info = pathinfo( $filename );
				$ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
				$name = basename( $filename, $ext );
				return sanitize_title($name).$ext;
			}
		}
		//AUTO IMAGE SEF NAME
		
		//DETECT
        //add_action( 'wp_loaded', array($this,'seldos_seo_404_detect'));
        add_action( 'wp_enqueue_scripts', array($this,'seotudy_404_detect'));
        add_action( 'wp_enqueue_scripts', array($this,'seotudy_redirects_detect'));
        add_action( 'wp_enqueue_scripts', array($this,'seotudy_backlink_detect'));
        //DETECT
		
		//TITLE AND DESC ACTIVE
		if(get_option( 'seotudy_titleAndDescActive' )){
			add_filter( 'wp_title', array($this, 'seotudy_titleChange' ),99,1); 
			add_filter( 'pre_get_document_title', array($this, 'seotudy_titleChange' ),99,1); 
			add_action( 'wp_head', array(&$this, 'seotudy_descChange' ) );
        }
		//TITLE AND DESC ACTIVE
		
		//ADD CANONICAL
		remove_action('template_redirect', 'redirect_canonical');
		remove_action('wp_head', 'rel_canonical');
		add_action( 'wp_head', array(&$this, 'seotudy_canonical_link' ) );
		//ADD CANONICAL
		
	}
	
	//OPEN GRAPH ADD
	function seotudy_ogTag(){
		$title = $this->seotudy_titleChange();
		$desc  = $this->seotudy_descChange(null,true);
		$url   = $_SERVER['REQUEST_URI']=='/'?get_home_url():get_home_url().$_SERVER['REQUEST_URI'];
		echo '
		<meta property="og:title" content="'.$title.'" />
		<meta property="og:description" content="'.$desc.'" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="'.$url.'" />
		';
	}
	//OPEN GRAPH ADD
	
	//ADD CANONICAL
	function seotudy_canonical_link(){
		global $post;
		
		if(is_page() or is_single()){
			echo '<link rel="canonical" href="'.get_permalink($post->ID).'" />';
		}else{
			echo '<link rel="canonical" href="'.get_bloginfo('url').$_SERVER['REQUEST_URI'].'" />';
		}
	}
	//ADD CANONICAL
	
	//TITLE CHANGE
	public function seotudy_titleChange($title=null){
		global $post;
		
		if(is_front_page()){
			/* HOME */
			$title = get_option('seotudy_home_title',true);
			/* HOME */
		}if(is_page() or is_single()){
			/* POST TYPE */
			$post_type = get_post_type($post->ID);
			$title = get_post_meta($post->ID,'seotudy_title',true);
			if($title == null or empty($title)){
				$title = get_option( 'seotudy_'.$post_type.'_title' );
			}
			/* POST TYPE */
		}else if(is_tax() or is_category()){
			$title = get_option( 'seotudy_category_title' );
			if(empty($title)){
				$tax = get_queried_object();
				$title = $tax->name;
			}
		}else if(is_tag()){
			$title = get_option( 'seotudy_post_tag_title' );
			if(empty($title)){
				$tax = get_queried_object();
				$title = $tax->name;
			}
		}else if(is_home()){
			$title = get_option( 'seotudy_home_title' );
        }else{
			$title = __('Page Not Found','seotudy');
		}
		
        return $this->seoConverter($title);
    }
	//TITLE CHANGE
    
	//DESC CHANGE
    public function seotudy_descChange($desc=null,$output=false){
        global $post;
		
		if(is_page() or is_single()){
			/* POST TYPE */
			$post_type = get_post_type($post->ID);
			$desc = get_post_meta($post->ID,'seotudy_desc',true);
			if(empty($desc)){
				$desc = get_option( 'seotudy_'.$post_type.'_desc' );
			}
			/* POST TYPE */
		}else if(is_tax() or is_category()){
			$desc = get_option( 'seotudy_category_desc' );
			if(empty($desc)){
				$tax = get_queried_object();
				$desc = $tax->name;
			}
		}else if(is_tag()){
			$desc = get_option( 'seotudy_post_tag_desc' );
			if(empty($desc)){
				$tax = get_queried_object();
				$desc = $tax->name;
			}
		}else if(is_attachment()){
			$desc = get_option( 'seotudy_home_desc' );
        }else if(is_home()){
			$desc = get_option( 'seotudy_home_desc' );
        }else{
			$desc =__('Page Not Found','seotudy');
		}
		
		if($output==false){
			echo '<meta name="description"  content="'.$this->seoConverter($desc).'" />';
		}else{
			return $this->seoConverter($desc);
		}
		
    }
	//DESC CHANGE
	
	function seoConverter($text){
		global $post;
		
		$tax = get_queried_object();
		$p = [
			'%sitename%',
			'%siteslogan%',
			'%title%',
			'%desc%',
			'%page%',
			'%sep%',
			'%termname%',
		];
		
		$c = [
			get_bloginfo('sitename'),
			get_bloginfo('description'),
			isset($post->post_title)?$post->post_title:'',
			isset($post->post_content)?wp_trim_words($post->post_content,40,false):'',
			get_query_var('paged') > 1 ? ' - '.get_query_var('paged') : '' ,
			'-',
			$tax!=null?$tax->name:''
		];
		
		return str_replace($p,$c,$text);
	}
	
	
	
	//404 DETECT
	function seotudy_404_detect(){
        if(is_404()) {
            global $wpdb;
			
			$exclude = [
				'.jpeg',
				'.jpg',
				'.png',
				'.ico',
				'.ttf',
				'.woff',
				'.xml',
				'.svg',
				'.css',
				'.js',
				'.map',
			];
			
			
            if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI'])){
				
				$r = false;
				foreach($exclude as $x){
					if($this->endsWith($x) === true){
						$r = true;
					}
				}
				
				if($r==false){
					$url = trim(strip_tags($_SERVER['REQUEST_URI']));
					$setUrl = get_bloginfo('url');
					
					$control = $wpdb->get_results("SELECT * FROM seotudy_links WHERE link='".$url."' AND status='404'");
					if($wpdb->num_rows == 0){
					   $add = $wpdb->query("INSERT INTO seotudy_links SET link='".$url."',status='404'");
					}else{
						if(!empty($control[0]->new_link)){
							header("HTTP/1.1 301 Moved Permanently"); 
							header("Location: ".rtrim($setUrl,'/').$control[0]->new_link);
							exit;
						}
					}
				
				}
				
            }
        }
    }
	//404 DETECT
	
	//REDIRECT DETECT
	function seotudy_redirects_detect(){
		global $wpdb;
		if(isset($_SERVER['REQUEST_URI'])){
			$url = $_SERVER['REQUEST_URI'];
			$setUrl = get_bloginfo('url');
			
			$control = $wpdb->get_results("SELECT * FROM seotudy_links WHERE link = '".$url."'");
			if($wpdb->num_rows > 0){
				if(!empty($control[0]->new_link)){
					header("HTTP/1.1 301 Moved Permanently"); 
					header("Location: ".rtrim($setUrl,'/').$control[0]->new_link);
					exit;
				}
			}
			
		}
	}
	//REDIRECT DETECT
	
	//BACKLINK DETECT
	function seotudy_backlink_detect(){
		global $wpdb;
		if(isset($_SERVER['HTTP_REFERER'])){
			
			$url = parse_url($_SERVER['HTTP_REFERER']);
			if(!stristr(get_home_url(),$url['host'])){
				$control = $wpdb->get_results("SELECT * FROM seotudy_links WHERE link='".$_SERVER['HTTP_REFERER']."' AND status='backlink'");
				if($wpdb->num_rows == 0){
					$add = $wpdb->query("INSERT INTO seotudy_links SET link='".$_SERVER['HTTP_REFERER']."',new_link='".get_home_url().$_SERVER['REQUEST_URI']."',status='backlink'");
				}
			}
			
		}
		
	}
	//BACKLINK DETECT
	
	//AUTO ALT TAG
	function seotudy_image_alt_public($html, $id){
		return str_replace('alt=""','alt="'.get_the_title($id).'"',$html);
	}
	//AUTO ALT TAG
	
	//GOOGLE ANALYTIC CODE ADD
	function seotudy_googleAnalyticCode(){
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?=get_option( 'seotudy_googleAnalyticCode' )?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?=get_option( 'seotudy_googleAnalyticCode' )?>');
    </script>
    <?php
    }
	//GOOGLE ANALYTIC CODE ADD
	
	//GOOGLE SEARCH CONSOLE ADD
	function seotudy_googleSCCode(){
    ?>
    <meta name="google-site-verification" content="<?=get_option( 'seotudy_googleSCCode' )?>" />
    <?php
    }
	//GOOGLE SEARCH CONSOLE ADD
	
	//YANDEX METRIKA ADD
	function seotudy_yandexMetrica(){
    ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter<?=get_option( 'yandexMetrica' )?> = new Ya.Metrika({ id:<?=get_option( 'yandexMetrica' )?>, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/<?=get_option( 'yandexMetrica' )?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <?php
    }
	//YANDEX METRIKA ADD
	
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function seotudy_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/seotudy-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function seotudy_enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/seotudy-public.js', array( 'jquery' ), $this->version, false );
	}
	
	function startsWith($needle,$haystack = null, $case = true) {
		
		if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI']) and $haystack == null){
			$haystack = $_SERVER['REQUEST_URI'];
		}
		
		if ($case) {
			return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
		}
		return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
	}

	function endsWith($needle,$haystack = null, $case = true) {
		
		if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI']) and $haystack == null){
			$haystack = parse_url($_SERVER['REQUEST_URI']);
			$haystack = $haystack['path'];
		}
		
		if ($case) {
			return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
		}
		return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
	}
		
}
