<?php

namespace UPFlex\MixUp\Core;

use UPFlex\MixUp\Core\Interfaces\ITaxonomy;

abstract class Taxonomy extends Base implements ITaxonomy
{
    private static array $args = [];
    private static bool $male = true;
    private static string $name;
    private static string $plural;
    private static array $postTypes = [];
    private static string $singular;
    private static string $slug = '';

    public static function getArgs(): array
    {
        return self::$args;
    }

    public static function getName(): string
    {
        return self::$name;
    }

    public static function getPlural(): string
    {
        return self::$plural;
    }

    public static function getPostTypes(): array
    {
        return self::$postTypes;
    }

    public static function getSingular(): string
    {
        return self::$singular;
    }

    public static function getSlug(): string
    {
        return self::$slug;
    }

    public static function isMale(): bool
    {
        return self::$male;
    }

    public static function setArgs(array $args): void
    {
        self::$args = $args;
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

    public static function setPostTypes(array $postTypes): void
    {
        self::$postTypes = $postTypes;
    }

    public static function setSingular(string $singular): void
    {
        self::$singular = $singular;
    }

    public static function setSlug(string $slug): void
    {
        self::$slug = $slug;
    }

    public static function register(): void
    {
        $labels = [
            "name" => self::getPlural(),
            "singular_name" => self::getSingular(),
            "menu_name" => self::getPlural(),
            "all_items" => self::isMale() ? sprintf(__("Todos os %s"), self::getPlural()) : sprintf(__("Todas as %s"), self::getPlural()),
            "edit_item" => sprintf(__("Editar %s"), self::getSingular()),
            "view_item" => sprintf(__("Ver %s"), self::getSingular()),
            "update_item" => self::isMale() ? sprintf(__("Atualizar nome do %s"), self::getSingular()) : sprintf(__("Atualizar nome da %s"), self::getSingular()),
            "add_new_item" => self::isMale() ? sprintf(__("Adicionar novo %s"), self::getSingular()) : sprintf(__("Adicionar nova %s"), self::getSingular()),
            "new_item_name" => self::isMale() ? sprintf(__("Novo %s"), self::getSingular()) : sprintf(__("Nova %s"), self::getSingular()),
            "parent_item" => sprintf(__("%s ascendente"), self::getSingular()),
            "parent_item_colon" => sprintf(__("%s ascendente:"), self::getSingular()),
            "search_items" => sprintf(__("Pesquisar %s"), self::getPlural()),
            "popular_items" => sprintf(__("%s mais populares"), self::getPlural()),
            "separate_items_with_commas" => sprintf(__("Separe %s com vírgulas"), self::getPlural()),
            "add_or_remove_items" => sprintf(__("Adicionar ou excluir %s"), self::getPlural()),
            "choose_from_most_used" => sprintf(__("Escolher entre os termos mais usados de %s"), self::getPlural()),
            "not_found" => self::isMale() ? sprintf(__("Nenhum %s encontrado"), self::getSingular()) : sprintf(__("Nenhuma %s encontrada"), self::getSingular()),
            "no_terms" => self::isMale() ? sprintf(__("Nenhum %s"), self::getSingular()) : sprintf(__("Nenhuma %s"), self::getSingular()),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), self::getPlural()),
            "items_list" => sprintf(__("Lista de %s"), self::getPlural()),
            "back_to_items" => sprintf(__("Voltar para %s"), self::getPlural())
        ];

        $args = [
            "label" => self::getPlural(),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [
                "slug" => strlen(self::getSlug()) > 0 ? self::getSlug() : self::getName(),
                "with_front" => true
            ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => self::getName(),
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "show_in_quick_edit" => false,
            "show_in_graphql" => false,
        ];

        register_taxonomy(self::getName(), self::getPostTypes(), array_merge($args, array_filter(self::getArgs())));
    }
}
