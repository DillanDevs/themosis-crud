<?php

if (!class_exists('People_List_Table')) {

    if (!class_exists('WP_List_Table')) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
    }

    class People_List_Table extends WP_List_Table
    {
        public function __construct()
        {
            parent::__construct([
                'singular' => 'persona',
                'plural' => 'personas',
                'ajax' => false,
            ]);
        }

        /**
         * Obtiene los registros paginados.
         */
        public static function get_people($per_page = 20, $page = 1)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'people';

            $orderby = !empty($_REQUEST['orderby']) ? sanitize_key($_REQUEST['orderby']) : 'created_at';
            $order = !empty($_REQUEST['order']) ? strtoupper($_REQUEST['order']) : 'DESC';

            $offset = ($page - 1) * $per_page;
            return $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM {$table}
             ORDER BY {$orderby} {$order}
             LIMIT %d OFFSET %d",
                    $per_page,
                    $offset
                ),
                ARRAY_A
            );
        }


        /**
         * Cuenta el total de registros.
         */
        public static function record_count()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'people';
            return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
        }

        /**
         * Mensaje cuando no hay ítems.
         */
        public function no_items()
        {
            _e('No hay personas para mostrar.', 'themosis');
        }

        /**
         * Default column renderer.
         */
        public function column_default($item, $column_name)
        {
            switch ($column_name) {
                case 'rut':
                case 'birth_date':
                    return esc_html($item[$column_name]);
                default:
                    return print_r($item, true);
            }
        }

        /**
         * Columna "Nombre completo" con acciones inline.
         */
        public function column_name($item)
        {
            $edit_link = add_query_arg(
                [
                    'page' => 'people-add',
                    'person' => $item['id'],
                ],
                admin_url('admin.php')
            );

            $actions = [
                'edit' => sprintf(
                    '<a href="%s">%s</a>',
                    esc_url($edit_link),
                    __('Editar', 'themosis')
                ),
                'delete' => sprintf(
                    '<a href="%s" onclick="return confirm(\'%s\')">%s</a>',
                    wp_nonce_url(
                        add_query_arg(
                            [
                                'action' => 'delete',
                                'person' => $item['id'],
                            ],
                            admin_url('admin-post.php')
                        ),
                        'delete_person_' . $item['id']
                    ),
                    esc_js(__('¿Seguro que quieres eliminar?', 'themosis')),
                    __('Eliminar', 'themosis')
                ),
            ];

            $full_name = esc_html($item['first_name'] . ' ' . $item['last_name']);
            return sprintf('%1$s %2$s', $full_name, $this->row_actions($actions));
        }

        /**
         * Define columnas de la tabla.
         */
        public function get_columns()
        {
            return [
                'name' => __('Nombre completo', 'themosis'),
                'rut' => __('RUT', 'themosis'),
                'birth_date' => __('Fecha de nacimiento', 'themosis'),
            ];
        }

        /**
         * Columnas ordenables.
         */
        public function get_sortable_columns()
        {
            return [
                'name' => ['first_name', true],
                'birth_date' => ['birth_date', false],
            ];
        }

        /**
         * Prepara los datos para mostrar.
         */
        public function prepare_items()
        {
            $per_page = 10;
            $current_page = $this->get_pagenum();
            $total_items = self::record_count();

            $this->set_pagination_args([
                'total_items' => $total_items,
                'per_page' => $per_page,
            ]);

            $columns = $this->get_columns();
            $hidden = [];
            $sortable = $this->get_sortable_columns();
            $this->_column_headers = [$columns, $hidden, $sortable];

            $this->items = self::get_people($per_page, $current_page);
        }
    }

}