// Removendo a aba “Opções de Tela”

function wpmidia_remove_screen_options(){
    return false;
}
add_filter('screen_options_show_screen', 'wpmidia_remove_screen_options');
