<?php

namespace UPFlex\MixUp\Core;

use UPFlex\MixUp\Core\Interfaces\IPostTypes;

abstract class PostType extends Base implements IPostTypes
{
    private static array $args = [];
    private static string $icon = '';
    private static bool $male = true;
    private static string $name;
    private static string $plural;
    private static string $singular;
    private static string $slug = '';
    private static array $supports = ["title", "thumbnail"];

    public static function getArgs(): array
    {
        return self::$args;
    }

    public static function getIcon(): string
    {
        return self::$icon;
    }

    public static function getName(): string
    {
        return self::$name;
    }

    public static function getPlural(): string
    {
        return self::$plural;
    }

    public static function getSingular(): string
    {
        return self::$singular;
    }

    public static function getSlug(): string
    {
        return self::$slug;
    }

    public static function getSupports(): array
    {
        return self::$supports;
    }

    public static function isMale(): bool
    {
        return self::$male;
    }

    public static function setArgs(array $args): void
    {
        self::$args = $args;
    }

    public static function setIcon(string $icon): void
    {
        self::$icon = $icon;
    }

    public static function setMale(bool $male): void
    {
        self::$male = $male;
    }

    public static function setName(string $name): void
    {
        self::$name = $name;
    }

    public static function setPlural(string $plural): void
    {
        self::$plural = $plural;
    }

    public static function setSingular(string $singular): void
    {
        self::$singular = $singular;
    }

    public static function setSlug(string $slug): void
    {
        self::$slug = $slug;
    }

    public static function setSupports(array $supports): void
    {
        self::$supports = $supports;
    }

    public static function register(): void
    {
        $labels = [
            "name" => self::getPlural(),
            "singular_name" => self::getSingular(),
            "menu_name" => self::getPlural(),
            "all_items" => self::isMale() ? sprintf(__("Todos os %s"), self::getPlural()) : sprintf(__("Todas as %s"), self::getPlural()),
            "add_new" => self::isMale() ? __("Adicionar novo") : __("Adicionar nova"),
            "add_new_item" => self::isMale() ? sprintf(__("Adicionar novo %s"), self::getSingular()) : sprintf(__("Adicionar nova %s"), self::getSingular()),
            "edit_item" => sprintf(__("Editar %s"), self::getSingular()),
            "new_item" => self::isMale() ? sprintf(__("Novo %s"), self::getSingular()) : sprintf(__("Nova %s"), self::getSingular()),
            "view_item" => sprintf(__("Ver %s"), self::getSingular()),
            "view_items" => sprintf(__("Ver %s"), self::getPlural()),
            "search_items" => sprintf("Pesquisar %s", self::getPlural()),
            "not_found" => self::isMale() ? sprintf(__("Nenhum %s encontrado"), self::getSingular()) : sprintf(__("Nenhuma %s encontrada"), self::getSingular()),
            "not_found_in_trash" => self::isMale() ? sprintf(__("Nenhum %s encontrado na lixeira"), self::getSingular()) : sprintf("Nenhuma %s encontrada na lixeira", self::getSingular()),
            "parent" => sprintf(__("%s ascendente"), self::getSingular()),
            "featured_image" => self::isMale() ? sprintf(__("Imagem destacada para esse %s"), self::getSingular()) : sprintf(__("Imagem destacada para essa %s"), self::getSingular()),
            "set_featured_image" => self::isMale() ? sprintf(__("Definir imagem destacada para esse %s"), self::getSingular()) : sprintf(__("Definir imagem destacada para essa %s"), self::getSingular()),
            "remove_featured_image" => self::isMale() ? sprintf(__("Remover imagem destacada para esse %s"), self::getSingular()) : sprintf(__("Remover imagem destacada para essa %s"), self::getSingular()),
            "use_featured_image" => self::isMale() ? sprintf(__("Usar como imagem destacada para esse %s"), self::getSingular()) : "Usar como imagem destacada para essa {self::getSingular()}",
            "archives" => self::isMale() ? sprintf(__("Arquivos do %s"), self::getSingular()) : sprintf(__("Arquivos da %s"), self::getSingular()),
            "insert_into_item" => self::isMale() ? sprintf(__("Inserir no %s"), self::getSingular()) : sprintf(__("Inserir na %s"), self::getSingular()),
            "uploaded_to_this_item" => self::isMale() ? sprintf(__("Enviar para esse %s"), self::getSingular()) : sprintf(__("Enviar para essa %s"), self::getSingular()),
            "filter_items_list" => sprintf(__("Filtrar lista de %s"), self::getPlural()),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), self::getPlural()),
            "items_list" => sprintf(__("Lista de %s"), self::getPlural()),
            "attributes" => sprintf(__("Atributos de %s"), self::getPlural()),
            "name_admin_bar" => self::getSingular(),
            "item_published" => self::isMale() ? sprintf(__("%s publicado"), self::getSingular()) : sprintf(__("%s publicada"), self::getSingular()),
            "item_published_privately" => self::isMale() ? sprintf(__("%s publicado de forma privada."), self::getSingular()) : sprintf(__("%s publicada de forma privada."), self::getSingular()),
            "item_reverted_to_draft" => self::isMale() ? sprintf(__("%s revertido para rascunho."), self::getSingular()) : sprintf(__("%s revertida para rascunho."), self::getSingular()),
            "item_scheduled" => self::isMale() ? sprintf(__("%s agendado"), self::getSingular()) : sprintf(__("%s agendada"), self::getSingular()),
            "item_updated" => self::isMale() ? sprintf(__("%s atualizado."), self::getSingular()) : sprintf(__("%s atualizada."), self::getSingular()),
            "parent_item_colon" => sprintf(__("%s ascendente:"), self::getSingular()),
        ];

        $args = [
            "label" => self::getPlural(),
            "labels" => $labels,
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
            "rewrite" => ["slug" => strlen(self::getSlug()) > 0 ? self::getSlug() : self::getName(), "with_front" => true],
            "query_var" => true,
            "menu_icon" => self::getIcon(),
            "supports" => self::getSupports(),
            "show_in_graphql" => false,
        ];

        register_post_type(self::getName(), array_merge($args, array_filter(self::getArgs())));
    }
}
