<?php

namespace UPFlex\MixUp\Core\Parent;

use UPFlex\MixUp\Core\Base;
use UPFlex\MixUp\Core\Interfaces\IPostTypes;
use UPFlex\MixUp\Utils\GroupingType;

abstract class PostType extends Base implements IPostTypes
{
    use GroupingType;

    protected static string $icon = '';
    protected static array $supports = ["title", "thumbnail"];

    /**
     * @param $instance
     * @return array
     */
    public static function getLabels($instance): array
    {
        return [
            "name" => $instance::$plural,
            "singular_name" => $instance::$singular,
            "menu_name" => $instance::$plural,
            "all_items" => $instance::$male
                ? sprintf(__("Todos os %s"), $instance::$plural)
                : sprintf(__("Todas as %s"), $instance::$plural),
            "add_new" => $instance::$male ? __("Adicionar novo") : __("Adicionar nova"),
            "add_new_item" => $instance::$male
                ? sprintf(__("Adicionar novo %s"), $instance::$singular)
                : sprintf(__("Adicionar nova %s"), $instance::$singular),
            "edit_item" => sprintf(__("Editar %s"), $instance::$singular),
            "new_item" => $instance::$male
                ? sprintf(__("Novo %s"), $instance::$singular)
                : sprintf(__("Nova %s"), $instance::$singular),
            "view_item" => sprintf(__("Ver %s"), $instance::$singular),
            "view_items" => sprintf(__("Ver %s"), $instance::$plural),
            "search_items" => sprintf("Pesquisar %s", $instance::$plural),
            "not_found" => $instance::$male
                ? sprintf(__("Nenhum %s encontrado"), $instance::$singular)
                : sprintf(__("Nenhuma %s encontrada"), $instance::$singular),
            "not_found_in_trash" => $instance::$male
                ? sprintf(__("Nenhum %s encontrado na lixeira"), $instance::$singular)
                : sprintf("Nenhuma %s encontrada na lixeira", $instance::$singular),
            "parent" => sprintf(__("%s ascendente"), $instance::$singular),
            "featured_image" => $instance::$male
                ? sprintf(__("Imagem destacada para esse %s"), $instance::$singular)
                : sprintf(__("Imagem destacada para essa %s"), $instance::$singular),
            "set_featured_image" => $instance::$male
                ? sprintf(__("Definir imagem destacada para esse %s"), $instance::$singular)
                : sprintf(__("Definir imagem destacada para essa %s"), $instance::$singular),
            "remove_featured_image" => $instance::$male
                ? sprintf(__("Remover imagem destacada para esse %s"), $instance::$singular)
                : sprintf(__("Remover imagem destacada para essa %s"), $instance::$singular),
            "use_featured_image" => $instance::$male
                ? sprintf(__("Usar como imagem destacada para esse %s"), $instance::$singular)
                : "Usar como imagem destacada para essa {$instance::$singular}",
            "archives" => $instance::$male
                ? sprintf(__("Arquivos do %s"), $instance::$singular)
                : sprintf(__("Arquivos da %s"), $instance::$singular),
            "insert_into_item" => $instance::$male
                ? sprintf(__("Inserir no %s"), $instance::$singular)
                : sprintf(__("Inserir na %s"), $instance::$singular),
            "uploaded_to_this_item" => $instance::$male
                ? sprintf(__("Enviar para esse %s"), $instance::$singular)
                : sprintf(__("Enviar para essa %s"), $instance::$singular),
            "filter_items_list" => sprintf(__("Filtrar lista de %s"), $instance::$plural),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), $instance::$plural),
            "items_list" => sprintf(__("Lista de %s"), $instance::$plural),
            "attributes" => sprintf(__("Atributos de %s"), $instance::$plural),
            "name_admin_bar" => $instance::$singular,
            "item_published" => $instance::$male
                ? sprintf(__("%s publicado"), $instance::$singular)
                : sprintf(__("%s publicada"), $instance::$singular),
            "item_published_privately" => $instance::$male
                ? sprintf(__("%s publicado de forma privada."), $instance::$singular)
                : sprintf(__("%s publicada de forma privada."), $instance::$singular),
            "item_reverted_to_draft" => $instance::$male
                ? sprintf(__("%s revertido para rascunho."), $instance::$singular)
                : sprintf(__("%s revertida para rascunho."), $instance::$singular),
            "item_scheduled" => $instance::$male
                ? sprintf(__("%s agendado"), $instance::$singular)
                : sprintf(__("%s agendada"), $instance::$singular),
            "item_updated" => $instance::$male
                ? sprintf(__("%s atualizado."), $instance::$singular)
                : sprintf(__("%s atualizada."), $instance::$singular),
            "parent_item_colon" => sprintf(__("%s ascendente:"), $instance::$singular),
        ];
    }

    public static function setIcon(string $icon): void
    {
        self::$icon = $icon;
    }

    public static function setSupports(array $supports): void
    {
        self::$supports = $supports;
    }

    public static function register(): void
    {
        $class = get_called_class();
        $instance = (new $class);

        $args = [
            "label" => $instance::$plural,
            "labels" => self::getLabels($instance),
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => [
                "slug" => strlen($instance::$slug) > 0
                    ? $instance::$slug
                    : $instance::$name,
                "with_front" => true
            ],
            "query_var" => true,
            "menu_icon" => $instance::$icon,
            "supports" => $instance::$supports,
            "show_in_graphql" => false,
        ];

        register_post_type($instance::$name, array_merge($args, array_filter($instance::$args)));
    }
}
