<?php

namespace UPFlex\MixUp\Core\Parent;

use UPFlex\MixUp\Core\Base;
use UPFlex\MixUp\Core\Interfaces\ITaxonomy;
use UPFlex\MixUp\Core\Traits\GroupingType;

abstract class Taxonomy extends Base implements ITaxonomy
{
    use GroupingType;

    public static string $tx_name = '';
    protected array $postTypes = [];

    /**
     * @param $instance
     * @return array
     */
    public static function getLabels($instance): array
    {
        return [
            "name" => $instance->getPlural(),
            "singular_name" => $instance->getSingular(),
            "menu_name" => $instance->getPlural(),
            "all_items" => $instance->isMale()
                ? sprintf(__("Todos os %s"), $instance->getPlural())
                : sprintf(__("Todas as %s"), $instance->getPlural()),
            "edit_item" => sprintf(__("Editar %s"), $instance->getSingular()),
            "view_item" => sprintf(__("Ver %s"), $instance->getSingular()),
            "update_item" => $instance->isMale()
                ? sprintf(__("Atualizar nome do %s"), $instance->getSingular())
                : sprintf(__("Atualizar nome da %s"), $instance->getSingular()),
            "add_new_item" => $instance->isMale()
                ? sprintf(__("Adicionar novo %s"), $instance->getSingular())
                : sprintf(__("Adicionar nova %s"), $instance->getSingular()),
            "new_item_name" => $instance->isMale()
                ? sprintf(__("Novo %s"), $instance->getSingular())
                : sprintf(__("Nova %s"), $instance->getSingular()),
            "parent_item" => sprintf(__("%s ascendente"), $instance->getSingular()),
            "parent_item_colon" => sprintf(__("%s ascendente:"), $instance->getSingular()),
            "search_items" => sprintf(__("Pesquisar %s"), $instance->getPlural()),
            "popular_items" => sprintf(__("%s mais populares"), $instance->getPlural()),
            "separate_items_with_commas" => sprintf(__("Separe %s com vírgulas"), $instance->getPlural()),
            "add_or_remove_items" => sprintf(__("Adicionar ou excluir %s"), $instance->getPlural()),
            "choose_from_most_used" => sprintf(
                __("Escolher entre os termos mais usados de %s"),
                $instance->getPlural()
            ),
            "not_found" => $instance->isMale()
                ? sprintf(__("Nenhum %s encontrado"), $instance->getSingular())
                : sprintf(__("Nenhuma %s encontrada"), $instance->getSingular()),
            "no_terms" => $instance->isMale()
                ? sprintf(__("Nenhum %s"), $instance->getSingular())
                : sprintf(__("Nenhuma %s"), $instance->getSingular()),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), $instance->getPlural()),
            "items_list" => sprintf(__("Lista de %s"), $instance->getPlural()),
            "back_to_items" => sprintf(__("Voltar para %s"), $instance->getPlural())
        ];
    }

    public function getPostTypes(): array
    {
        return $this->postTypes;
    }

    public function setPostTypes(array $postTypes): void
    {
        $this->postTypes = $postTypes;
    }

    public static function register(): void
    {
        $class = get_called_class();
        $instance = (new $class);

        $args = [
            "label" => $instance->getPlural(),
            "labels" => self::getLabels($instance),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [
                "slug" => strlen($instance->getSlug()) > 0 ? $instance->getSlug() : $instance->getName(),
                "with_front" => true
            ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => $instance->getName(),
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "show_in_quick_edit" => false,
            "show_in_graphql" => false,
        ];

        register_taxonomy(
            $instance->getName(),
            $instance->getPostTypes(),
            array_merge($args, array_filter($instance->getArgs()))
        );
    }
}
