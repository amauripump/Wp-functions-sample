<?php
/*
 *  Author: Amauri da Silva Junior e Jadson Aires Dorneles
 *  URL: novimagem.com.br
 *  Criado em: 27-06-2018
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        #wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        #wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    //wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    //wp_enqueue_style('normalize'); // Enqueue it!

    #wp_register_style('html5blank', get_template_directory_uri() . '/css/custom.css', array(), '1.0', 'all');
    #wp_enqueue_style('html5blank'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/


/* *********************************************************
 * Função adicionada por Amauri da Silva Junior 
 * para remover os menus que não serão necessários no admin 
 * *********************************************************/
add_action( 'admin_menu', 'byte_gerencia_menu' );
function byte_gerencia_menu() {
	/*remove_menu_page('edit-comments.php');
	remove_menu_page('edit.php');
	remove_menu_page('plugins.php');
    remove_menu_page('tools.php');
    remove_menu_page('themes.php');
    remove_menu_page('upload.php');
	remove_menu_page('options-general.php');
	remove_submenu_page('index.php','update-core.php');
    remove_menu_page('edit.php?post_type=page');
    remove_menu_page('edit.php?post_type=acf');*/
	
	add_menu_page( 'Parâmetros', 'Parâmetros', 'manage_options', 'parametros', 'site_config', 'dashicons-tickets', 6  );
	add_menu_page( 'Exames Agendados', 'Exames Agendados', 'manage_options', 'site_exames', 'site_exames', 'dashicons-tickets', 6  );
    add_menu_page( 'Textos do site', 'Textos do site', 'manage_options', 'site_textos', 'site_textos', 'dashicons-tickets', 6  );
    
    #add_menu_page( 'Parâmetros', 'Parâmetros', 'manage_options', 'parametros', 'site_config', 'dashicons-tickets', 6  );
	#add_menu_page( 'Textos do site', 'Textos do site', 'manage_options', 'site_textos', 'site_textos', 'dashicons-tickets', 6  );

}

#funções criadas por Amauri
include_once( get_theme_root() . "/funcoes.php" );


function site_config(){ 

	//var_dump($_POST);
	if(count($_POST) > 0):
		if(isset($_POST["nn_email"])):
			update_option('site_email', $_POST["nn_email"]);
		endif;
		
		if(isset($_POST["nn_senha"])):
			update_option('site_senha', $_POST["nn_senha"]);
		endif;
		
		if(isset($_POST["mapa"])):
			update_option('site_mapa_contato', $_POST["mapa"]);
		endif;
		
		if(isset($_POST["facebook"])):
			update_option('site_facebook', $_POST["facebook"]);
		endif;
		
		if(isset($_POST["instagram"])):
			update_option('site_instagram', $_POST["instagram"]);
		endif;
		
		if(isset($_POST["telefone"])):
			update_option('site_telefone', $_POST["telefone"]);
		endif;
		
		if(isset($_POST["endereco"])):
			update_option('site_endereco', $_POST["endereco"]);
		endif;
		
		echo '<script type="text/javascript">alert("Informações salvas com sucesso");</script>';
	
	endif;
	?>
	<h1>Configuração de Parâmetros do Site <?= get_bloginfo('name') ?></h1>
	
	<?php 
	$email_envio = get_option('site_email');
	$senha_envio = get_option('site_senha');
	$mapa_contato = get_option('site_mapa_contato');
	$social_facebook = get_option('site_facebook');
	$social_instagram = get_option('site_instagram');
	$telefone = get_option('site_telefone');
	$endereco = get_option('site_endereco');
	?>
	<form method="POST" action="<?php echo admin_url( 'admin.php?page=config%2Fconfig.php' ); ?>">
		<table class="form-table">
		<tr class="config-email-wrap">
			<th><label for="nn_email">E-mail de recebimento</label></th>
			<td><input type="text" name="nn_email" id="nn_email" value="<?php echo $email_envio; ?>" class="regular-text" /></td>
		</tr>
		<tr class="config-senha-wrap">
			<th><label for="nn_senha">Senha de recebimento</label></th>
			<td><input type="password" name="nn_senha" id="nn_senha" value="<?php echo $senha_envio; ?>" class="regular-text" /></td>
		</tr>
		<tr class="config-mapa-wrap">
			<th><label for="mapa">Mapa contato</label></th>
			<td><textarea style="width: 350px; height: 250px;" name="mapa" id="mapa" value="" class="regular-text"><?php echo $mapa_contato; ?></textarea></td>
		</tr>

		<tr class="config-facebook-wrap">
			<th><label for="facebook">Facebook</label></th>
			<td><input type="text" name="facebook" id="facebook" value="<?php echo $social_facebook; ?>" class="regular-text" /></td>
		</tr>

		<tr class="config-instagram-wrap">
			<th><label for="instagram">Instagram</label></th>
			<td><input type="text" name="instagram" id="instagram" value="<?php echo $social_instagram; ?>" class="regular-text" /></td>
		</tr>

		<tr class="config-telefone-wrap">
			<th><label for="telefone">Telefone</label></th>
			<td><input type="text" name="telefone" id="telefone" value="<?php echo $telefone; ?>" class="regular-text" /></td>
		</tr>

		<tr class="config-endereco-wrap">
			<th><label for="endereco">Endereço</label></th>
			<td><input type="text" name="endereco" id="endereco" value="<?php echo $endereco; ?>" class="regular-text" /></td>
		</tr>
		<tr class="config-instagram-wrap">
			<td colspan="2">
				<input type="submit" name="salvar" id="salvar" class="button button-primary button-large" value="Salvar">
			</td>
		</tr>

		</table>
	</form>
	<?php
}

/* *********************************************************
 * Função adicionada por Amauri da Silva Junior 
 * Tela de cadastro de parâmtros ADM
 * *********************************************************/
function site_textos(){ 

	//var_dump($_POST);
	if(count($_POST) > 0):
		
		if(isset($_POST["tit_bloco_1"])):
			update_option('tit_bloco_1', $_POST["tit_bloco_1"]);
		endif;
		
		if(isset($_POST["tit_bloco_2"])):
			update_option('tit_bloco_2', $_POST["tit_bloco_2"]);
		endif;
		
		if(isset($_POST["home_bloco_1"])):
			update_option('home_bloco_1', $_POST["home_bloco_1"]);
		endif;
		
		if(isset($_POST["home_bloco_2"])):
			update_option('home_bloco_2', $_POST["home_bloco_2"]);
		endif;
		
		if(isset($_POST["texto_frase"])):
			update_option('texto_frase', $_POST["texto_frase"]);
		endif;
		
		if(isset($_POST["qs_bloco_1"])):
			update_option('qs_bloco_1', $_POST["qs_bloco_1"]);
		endif;
        
		if(isset($_POST["qs_bloco_2"])):
			update_option('qs_bloco_2', $_POST["qs_bloco_2"]);
		endif;
		
		if(isset($_POST["txt_missao"])):
			update_option('txt_missao', $_POST["txt_missao"]);
		endif;
		
		if(isset($_POST["txt_visao"])):
			update_option('txt_visao', $_POST["txt_visao"]);
		endif;
		
		if(isset($_POST["txt_valores"])):
			update_option('txt_valores', $_POST["txt_valores"]);
        endif;
		
		if(isset($_POST["txt_rodape"])):
			update_option('txt_rodape', $_POST["txt_rodape"]);
        endif;		
		
		
		echo '<script type="text/javascript">alert("Informações salvas com sucesso");</script>';
	
	endif;
	?>
	<h1>Configuração dos textos do site <?= get_bloginfo('name') ?></h1>
	
	<?php 
	$tit_bloco_1 = get_option('tit_bloco_1');
	$tit_bloco_2 = get_option('tit_bloco_2');
	$home_bloco_1 = get_option('home_bloco_1');
    $home_bloco_2 = get_option('home_bloco_2');
	$texto_frase = get_option('texto_frase');
	$qs_bloco_1 = get_option('qs_bloco_1');
    $qs_bloco_2 = get_option('qs_bloco_2');
	$txt_visao = get_option('txt_visao');
    $txt_missao = get_option('txt_missao');
    $txt_valores = get_option('txt_valores');
    $txt_rodape = get_option('txt_rodape');
    
    $settings = array( 'media_buttons' => false );
	?>
	<form method="POST" action="<?php echo admin_url( 'admin.php?page=site_textos' ); ?>">
		<table class="form-table">
            <tr>
                <td><h2>Página Inicial</h2></td>
            </tr>
            <tr class="config-email-wrap">
                <td> Título 1:  <input style="width: 100%" type="text" value="<?php echo $tit_bloco_1; ?>" name="tit_bloco_1" id="tit_bloco_1"> </td>
            </tr>
            <tr class="config-email-wrap">
                <td> Bloco 1:<?php wp_editor( $home_bloco_1, "home_bloco_1", $settings ); ?> </td>
            </tr>
            <tr class="config-email-wrap">
                <td> Título 2:  <input style="width: 100%" type="text" value="<?php echo $tit_bloco_2; ?>" name="tit_bloco_2" id="tit_bloco_2"> </td>
            </tr>
            <tr class="config-mapa-wrap">
                <td> Bloco 2:<?php wp_editor( $home_bloco_2, "home_bloco_2", $settings ); ?> </td>
            </tr>
            <tr class="config-senha-wrap">
                <td>Bloco com foto de fundo:<?php wp_editor( $texto_frase, "texto_frase", $settings ); ?> </td>
            </tr>
        </table>

        <table class="form-table">
            <tr>
                <td><h2>Página Quem Somos</h2></td>
            </tr>
            <tr class="config-email-wrap">
                <td> Quem somos bloco 1:<?php wp_editor( $qs_bloco_1, "qs_bloco_1", $settings ); ?> </td>
            </tr>
            <tr class="config-senha-wrap">
                <td>Quem somos bloco 2:<?php wp_editor( $qs_bloco_2, "qs_bloco_2", $settings ); ?> </td>
            </tr>
            <tr class="config-mapa-wrap">
                <td> Texto Missão:<?php wp_editor( $txt_missao, "txt_missao", $settings ); ?> </td>
            </tr>
            <tr class="config-mapa-wrap">
                <td> Texto Visão:<?php wp_editor( $txt_visao, "txt_visao", $settings ); ?> </td>
            </tr>
            <tr class="config-mapa-wrap">
                <td> Texto Valores:<?php wp_editor( $txt_valores, "txt_valores", $settings ); ?> </td>
            </tr>
            <tr class="config-mapa-wrap">
                <td> Texto Rodapé (Aparece em: Quem somos, Exames e Contato):<?php wp_editor( $txt_rodape, "txt_rodape", $settings ); ?> </td>
            </tr>
        </table>
        <hr />
        <table class="form-table">
            <tr class="config-instagram-wrap">
                <td colspan="2">
                    <input type="submit" name="salvar" id="salvar" class="button button-primary button-large" value="Salvar">
                </td>
            </tr>
		</table>

	</form>
	<?php
}

/* *********************************************************
 * Função adicionada por Amauri da Silva Junior 
 * Tela de cadastro de parâmtros ADM
 * *********************************************************/
function site_exames(){ 

	$json = buscaEventosCalendarioJSON();
    ?>
        <script>
            $(document).ready(function() {
                var initialLocaleCode = 'pt-br';

                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,listMonth'
                    },
                    startParam:'2018-01-01',
                    endParam:'2030-01-01',
                    defaultDate: '<?= date("Y-m-d") ?>',
                    locale: initialLocaleCode,
                    buttonIcons: true, // show the prev/next text
                    weekNumbers: false,
                    navLinks: true, // can click day/week names to navigate views
                    eventLimit: true, // allow "more" link when too many events
                    events: <?= $json ?>,
                    disableDragging: true,
                    editable : false
                });

            });

            </script>

	<h1>Exames Agendados</h1>
	
	<?php 
	
	?>

                <div id='calendar'></div>

	<?php
}


// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

function create_post_type()
{


    register_taxonomy_for_object_type('category', 'exames'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'exames');
    register_post_type('exames', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Exames', 'exames'), // Rename these to suit
            'singular_name' => __('Exames', 'exames'),
            'add_new' => __('Adicionar', 'exames'),
            'add_new_item' => __('Adicionar novo', 'exames'),
            'edit' => __('Editar', 'exames'),
            'edit_item' => __('Editar', 'exames'),
            'new_item' => __('Novo', 'exames'),
            'view' => __('Ver', 'exames'),
            'view_item' => __('visualizar', 'exames'),
            'search_items' => __('Buscar', 'exames'),
            'not_found' => __('Não encontrado', 'exames'),
            'not_found_in_trash' => __('Nenhum registro encontrado na lixeira', 'exames')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));

    register_taxonomy_for_object_type('category', 'consulta'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'consulta');
    register_post_type('consulta', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Consulta', 'consulta'), // Rename these to suit
            'singular_name' => __('Consulta', 'consulta'),
            'add_new' => __('Adicionar', 'consulta'),
            'add_new_item' => __('Adicionar novo', 'consulta'),
            'edit' => __('Editar', 'consulta'),
            'edit_item' => __('Editar', 'consulta'),
            'new_item' => __('Novo', 'consulta'),
            'view' => __('Ver', 'consulta'),
            'view_item' => __('visualizar', 'consulta'),
            'search_items' => __('Buscar', 'consulta'),
            'not_found' => __('Não encontrado', 'consulta'),
            'not_found_in_trash' => __('Nenhum registro encontrado na lixeira', 'consulta')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));

    register_taxonomy_for_object_type('category', 'equipe'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'equipe');
    register_post_type('equipe', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('equipe', 'equipe'), // Rename these to suit
            'singular_name' => __('equipe', 'equipe'),
            'add_new' => __('Adicionar', 'equipe'),
            'add_new_item' => __('Adicionar novo', 'equipe'),
            'edit' => __('Editar', 'equipe'),
            'edit_item' => __('Editar', 'equipe'),
            'new_item' => __('Novo', 'equipe'),
            'view' => __('Ver', 'equipe'),
            'view_item' => __('visualizar', 'equipe'),
            'search_items' => __('Buscar', 'equipe'),
            'not_found' => __('Não encontrado', 'equipe'),
            'not_found_in_trash' => __('Nenhum registro encontrado na lixeira', 'equipe')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array() // Add Category and Post Tags support
    ));


    
	
    register_taxonomy_for_object_type('category', 'banner-home'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'banner-home');
    register_post_type('banner-home', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Banner home', 'banner-home'), // Rename these to suit
            'singular_name' => __('Banner home', 'banner-home'),
            'add_new' => __('Adicionar novo Banner ', 'banner-home'),
            'add_new_item' => __('Adicionar novo banner', 'banner-home'),
            'edit' => __('Editar', 'banner-home'),
            'edit_item' => __('Editar banner', 'banner-home'),
            'new_item' => __('Novo banner', 'banner-home'),
            'view' => __('Vizualizar banner', 'banner-home'),
            'view_item' => __('Vizualizar item de banner', 'banner-home'),
            'search_items' => __('Buscar banner', 'banner-home'),
            'not_found' => __('Nenhum banner encontrado', 'banner-home'),
            'not_found_in_trash' => __('Nenhum banner encontrado na lixeira', 'banner-home')
        ),
        'public' => true,
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'thumbnail',
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
    ));


}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

//Adicionanod o Fullcalendar no admin
function full_calendar() {
    
    wp_register_style( 'fullcalendar_css', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css', false, '1.0.0' );
    wp_enqueue_style( 'fullcalendar_css' );
    
    wp_register_style( 'fullcalendar_print_css', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css', false, '1.0.0' );
    wp_enqueue_style( 'fullcalendar_print_css' );

    wp_register_script('jquery_', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), '1.0'); // Conditionizr
    wp_enqueue_script('jquery_'); // Enqueue it!

    wp_register_script('moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js', array(), '1.0'); // Conditionizr
    wp_enqueue_script('moment'); // Enqueue it!

    wp_register_script('moment_', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/pt-br.js', array(), '1.0'); // Conditionizr
    wp_enqueue_script('moment_'); // Enqueue it!

    wp_register_script('fullcalendar', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js', array(), '1.0'); // Conditionizr
    wp_enqueue_script('fullcalendar'); // Enqueue it!

}
add_action( 'admin_enqueue_scripts', 'full_calendar' );


function buscaEventosCalendarioJSON(){
    //Buscando todos os eventos cadastrados para montar o JSON
    $args = array( 
        'post_type'         => 'consulta', 
        'posts_per_page'    => 99999, 
        'orderby'			=> 'date',
        'order'				=> 'ASC');

    //Busca da data inicial
    $arrEventos = new WP_Query( $args );

    $arrJSON = array();
    //var_dump($arrEventos->posts);


    foreach($arrEventos->posts as $chave => $arrEvento): 
    
        echo $DataInicial = get_field("data", $arrEvento->ID);
        $t1 = strtotime($DataInicial);
        #$dataIniFormatada = date('Y-m-d',$t1);

        $tmp = explode(" - ", $arrEvento->post_title);
        $dataIniFormatada = implode("-", array_reverse(explode("/", $tmp[0])));

        $DataFinal = false;

        #$DataFinal = get_field("data_final_do_evento", $arrEvento->ID);
        #$t2 = strtotime($DataFinal);
        #$dataFimFormatada = date('Y-m-d',$t2);

        //echo "{$arrEvento->post_title} Datainicial $DataInicial Datafinal $DataFinal <hr>";

        if(!$DataFinal):
            $arrJSON[] = array("title" => $arrEvento->post_title, "start" => $dataIniFormatada, "stick" => true);
        else:
            $arrJSON[] = array("title" => $arrEvento->post_title, "start" => $dataIniFormatada, "end" => $dataFimFormatada, "stick" => true);
        endif;

    endforeach; 
    
    return json_encode($arrJSON);
}
