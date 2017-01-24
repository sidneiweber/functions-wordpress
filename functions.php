<?php
// Removendo a aba “Opções de Tela”

function wpmidia_remove_screen_options(){
    return false;
}
add_filter('screen_options_show_screen', 'wpmidia_remove_screen_options');

// Alterando a frase “Digite o título aqui” (“Enter the title here”, em instalações em inglês)

function wpmidia_title_text_input( $title ){
     return $title = 'Aqui vai o seu novo título';
}
add_filter( 'enter_title_here', 'wpmidia_title_text_input' );

//  Alterando o texto do rodapé do painel administrativo

function wpmidia_change_footer_admin () {
    echo "<strong>wpmidia lab</strong>";
} 
 
add_filter('admin_footer_text', 'wpmidia_change_footer_admin');

// Desativando a mensagem “[...] Por favor, atualize agora”

if (! current_user_can ('edit_users')) {
  add_action ('init', create_function ('$ a "," remove_action (' init ',' wp_version_check '); "), 2);
  add_filter ('pre_option_update_core', create_function ('$' a "," return null; "));
}

// Alterando a cor da Admin Bar

function wpmidia_custom_colors() {
   echo '<style type="text/css">#wpadminbar {background:#069}</style>';
}
 
add_action('admin_head', 'wpmidia_custom_colors');

// Desativando alguns “Dashboard Widgets”

add_action('wp_dashboard_setup', 'wpmidia_remove_dashboard_widgets' );
function wpmidia_remove_dashboard_widgets() {
 
        global $wp_meta_boxes;
 
        // Remove o widget "Links de entrada" (Incomming links)
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);        
        // remove o widget "Plugins"
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);        
        // remove o widget "Rascunhos recentes" (Recent drafts)
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
        // remove o widget "QuickPress"
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
 
        // remove o widget "Agora" (Right now)
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        // remove o widget "Blog do WordPress" (Primary)
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        // remove o widget "Outras notícias do WordPress" (Secondary)
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);              
}

// Criando um “Dashboard Widget” customizado

add_action('wp_dashboard_setup', 'wpmidia_custom_dashboard_widgets');
 
function wpmidia_custom_dashboard_widgets() {
    global $wp_meta_boxes;
 
    wp_add_dashboard_widget('custom_help_widget', 'wpmidia lab | Suporte', 'wpmidia_custom_dashboard_help');
}
 
function wpmidia_custom_dashboard_help() {
    echo 'Se você tiver qualquer dúvida ou precisar de ajuda, por favor, entre em contato comigo através da minha página de <a href="http://wpmidia.com.br/contato/">contato</a>.';
}

// Removendo alguns itens do menu do painel administrativo

function wpmidia_toggle_custom_menu_order(){
    return true;
}
add_filter( 'custom_menu_order', 'wpmidia_toggle_custom_menu_order' );
 
function wpmidia_remove_some_menu_items( $menu_order ){
    global $menu;
    global $current_user; 
    get_currentuserinfo(); //print_r($current_user);
 
    if( $current_user->data->user_login == 'LOGIN DO USUARIO' )  //  <-- COLOQUE AQUI O LOGIN DO USUARIO QUE DESEJA RESTRINGIR  
    {
      $excludes = array(
          'edit.php', //o usuario nao vai acessar a pagina "posts"
           'upload.php', //o usuario nao vai acessar a pagina "midia"
          'tools.php', //o usuario nao vai acessar a pagina "ferramentas"
          'edit.php?post_type=portfolio' //o usuario nao vai acessar a pagina do custom post type "portfolio"
                  // etc ... etc ...                  
      );
 
      foreach ( $menu as $mkey => $m ) {
 
          foreach( $excludes as $exclude ){
              $key = array_search( $exclude, $m );
              if( $key ) unset( $menu[$mkey] );
          }
 
      }
 
     }
     return $menu_order;
 
     /*
    //-> para mais de um usuário restrito, vamos fazer o seguinte: (http://php.net/manual/en/function.in-array.php)
    $restritos = array('usuario1', 'usuario2', 'usuario3');
    if( in_array($current_user->data->user_login, $restritos ) )
    {
     ///aqui vai o resto do código
    }
    */
 
}
add_filter( 'menu_order', 'wpmidia_remove_some_menu_items' );

// ALTERAR RODAPÉ

function alt_admin_footer ()
{
    echo '<span id="footer-thankyou">Desenvolvido por <a href="http://www.escolasplus.com" target="_blank">Escolas Plus</a></span>';
}
add_filter('admin_footer_text', 'alt_admin_footer');
