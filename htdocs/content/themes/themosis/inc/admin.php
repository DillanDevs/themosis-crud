<?php

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\PersonController;
use App\Models\Person;


require_once __DIR__ . '/People_List_Table.php';


add_action('admin_menu', function () {
    add_menu_page(
        __('Personas', 'themosis'),
        __('Personas', 'themosis'),
        'manage_options',
        'people-admin',
        'people_list_page',
        'dashicons-groups',
        20
    );

    add_submenu_page(
        'people-admin',
        __('Añadir Persona', 'themosis'),
        __('Añadir nueva', 'themosis'),
        'manage_options',
        'people-add',
        'people_add_page'
    );
});


function people_list_page() {
    echo '<div class="wrap"><h1>'.esc_html__('Personas', 'themosis').'</h1>';
    $table = new People_List_Table();
    $table->prepare_items();
    $table->display();
    echo '</div>';
}

function people_add_page() {
    $id       = isset($_GET['person']) ? intval($_GET['person']) : null;
    $person   = $id ? Person::find($id) : null;
    $action   = $id ? 'update' : 'store';
    $endpoint = admin_url('admin-post.php');

    echo '<div class="wrap">';
    echo view('people.admin-form', compact('person','endpoint','action'))->render();
    echo '</div>';
}

// 3) Procesamiento POST (store, update, delete)
add_action('admin_post_store', function () {
    try {
        $req = HttpRequest::capture();
        (new PersonController)->store($req);

        wp_redirect(admin_url('admin.php?page=people-admin&created=1'));
    }
    catch (ValidationException $e) {
        $messages = $e->validator->errors()->getMessages();
        $args = [
            'page'      => 'people-add',
            'person'    => '',
            'error_rut' => urlencode(implode(', ', $messages['rut'] ?? [])),
        ];
        wp_redirect(admin_url('admin.php?' . http_build_query($args)));
    }
    exit;
});

add_action('admin_post_update', function () {
    $id     = intval($_POST['id']);
    $person = Person::findOrFail($id);

    try {
        $req = HttpRequest::capture();
        (new PersonController)->update($req, $person);

        wp_redirect(admin_url('admin.php?page=people-admin&updated=1'));
    }
    catch (ValidationException $e) {
        $messages = $e->validator->errors()->getMessages();
        $args = [
            'page'      => 'people-add',
            'person'    => $id,
            'error_rut' => urlencode(implode(', ', $messages['rut'] ?? [])),
        ];
        wp_redirect(admin_url('admin.php?' . http_build_query($args)));
    }
    exit;
});

add_action('admin_post_delete', function () {
    $id = intval($_GET['person']);
    check_admin_referer('delete_person_'.$id);
    Person::findOrFail($id)->delete();
    wp_redirect(admin_url('admin.php?page=people-admin&deleted=1'));
    exit;
});


add_action('admin_enqueue_scripts', function() {
    if ( empty($_GET['page']) ) return;
    if ( in_array($_GET['page'], ['people-admin','people-add'], true) ) {
        wp_enqueue_style('themosis-admin-style', get_stylesheet_directory_uri().'/style.css');
        wp_enqueue_script('rut-validate', get_stylesheet_directory_uri().'/assets/js/rut-validate.js', [], null, true);
    }
});
