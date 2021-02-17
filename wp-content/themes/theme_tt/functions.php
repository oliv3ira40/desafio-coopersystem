<?php

add_theme_support('post-thumbnails');

function create_posttype() {
    $label = [
        'name'                  => __('Anúncios'),
        'singular_name'         => __('Anúncio'),
        'add_new_item'          => __('Adicionar novo anúncio'),
        'all_items'             => __('Todos os anúncios'),
        'view_item'             => __('Ver anúncio'),
        'edit_item'             => __('Editar anúncio'),
        'update_item'           => __('Atualizar anúncio'), 
        'search_items'          => __('Procurar anúncio'),
        'not_found'             => __('Nenhum anúncio encontrado'),
        'not_found_in_trash'    => __('Nenhum anúncio na lixeira'),
    ];
    $args = [
        'label'         => __('Anúncios'),
        'labels'        => $label,
        'supports'      => ['title', 'editor', 'thumbnail'],
        'taxonomies'    => ['post_tag'],
        'hierarquical'  => false,
        'public'        => true,
        'rewrite'       => ['slug' => 'ad'],
        'has_archive'   => true,
    ];
    
    register_post_type( 'adverts', $args);
}
add_action('init', 'create_posttype');



function validating_custom_fields($post_id, $post) {
    $errors = false;
    if (!empty($_POST) AND $_POST['post_type'] == 'adverts' AND !in_array($_REQUEST['action'], ['trash', 'untrash'])) {
        $data = [
            'post_title'    => $_POST['post_title'],
            'content'       => $_POST['content'],
            'post_tag'      => $_POST['tax_input']['post_tag'],
            'thumbnail'     => $_POST['_thumbnail_id'],
        ];
        if ($data['thumbnail'] == -1) unset($data['thumbnail']);
        $data = array_filter($data);

        if ($_POST['post_status'] == 'publish' AND count($data) != 4) {
            global $wpdb;
            $wpdb->query("UPDATE `wp_posts` SET `post_status` = 'draft' WHERE `ID` = $post_id");
    
            $errors .= 'Campos obrigatórios: título, descrição, tag e imagem';
            update_option('my_admin_errors', $errors);
            
            wp_redirect(admin_url('post.php?post='.$post_id.'&action=edit'));
            exit;
        }
    }
    return;
}
add_action('save_post','validating_custom_fields', 1, 2);

function admin_notice_handler() {
    $errors = get_option('my_admin_errors');

    if ($errors != false) {
        echo '<div class="error"><p>'.$errors.'</p></div>';
    }
}
add_action('admin_notices', 'admin_notice_handler');

function clear_errors() {
    update_option('my_admin_errors', false);
}
add_action('admin_footer', 'clear_errors');