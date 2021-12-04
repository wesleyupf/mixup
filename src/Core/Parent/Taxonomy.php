<?php

namespace UPFlex\MixUp\Core\Parent;

use ReflectionClass;
use UPFlex\MixUp\Core\Base;
use UPFlex\MixUp\Core\Interfaces\ITaxonomy;

abstract class Taxonomy extends Base implements ITaxonomy
{
    protected array $args = [];
    protected bool $male = true;
    protected string $name;
    protected string $plural;
    protected array $postTypes = [];
    protected string $singular;
    protected string $slug = '';

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlural(): string
    {
        return $this->plural;
    }

    public function getPostTypes(): array
    {
        return $this->postTypes;
    }

    public function getSingular(): string
    {
        return $this->singular;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function isMale(): bool
    {
        return $this->male;
    }

    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    public function setMale(bool $male): void
    {
        $this->male = $male;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPlural(string $plural): void
    {
        $this->plural = $plural;
    }

    public function setPostTypes(array $postTypes): void
    {
        $this->postTypes = $postTypes;
    }

    public function setSingular(string $singular): void
    {
        $this->singular = $singular;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public static function register(): void
    {
        $class = get_called_class();
        $instance = (new $class);

        $labels = [
            "name" => $instance->getPlural(),
            "singular_name" => $instance->getSingular(),
            "menu_name" => $instance->getPlural(),
            "all_items" => $instance->isMale() ? sprintf(__("Todos os %s"), $instance->getPlural()) : sprintf(__("Todas as %s"), $instance->getPlural()),
            "edit_item" => sprintf(__("Editar %s"), $instance->getSingular()),
            "view_item" => sprintf(__("Ver %s"), $instance->getSingular()),
            "update_item" => $instance->isMale() ? sprintf(__("Atualizar nome do %s"), $instance->getSingular()) : sprintf(__("Atualizar nome da %s"), $instance->getSingular()),
            "add_new_item" => $instance->isMale() ? sprintf(__("Adicionar novo %s"), $instance->getSingular()) : sprintf(__("Adicionar nova %s"), $instance->getSingular()),
            "new_item_name" => $instance->isMale() ? sprintf(__("Novo %s"), $instance->getSingular()) : sprintf(__("Nova %s"), $instance->getSingular()),
            "parent_item" => sprintf(__("%s ascendente"), $instance->getSingular()),
            "parent_item_colon" => sprintf(__("%s ascendente:"), $instance->getSingular()),
            "search_items" => sprintf(__("Pesquisar %s"), $instance->getPlural()),
            "popular_items" => sprintf(__("%s mais populares"), $instance->getPlural()),
            "separate_items_with_commas" => sprintf(__("Separe %s com vírgulas"), $instance->getPlural()),
            "add_or_remove_items" => sprintf(__("Adicionar ou excluir %s"), $instance->getPlural()),
            "choose_from_most_used" => sprintf(__("Escolher entre os termos mais usados de %s"), $instance->getPlural()),
            "not_found" => $instance->isMale() ? sprintf(__("Nenhum %s encontrado"), $instance->getSingular()) : sprintf(__("Nenhuma %s encontrada"), $instance->getSingular()),
            "no_terms" => $instance->isMale() ? sprintf(__("Nenhum %s"), $instance->getSingular()) : sprintf(__("Nenhuma %s"), $instance->getSingular()),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), $instance->getPlural()),
            "items_list" => sprintf(__("Lista de %s"), $instance->getPlural()),
            "back_to_items" => sprintf(__("Voltar para %s"), $instance->getPlural())
        ];

        $args = [
            "label" => $instance->getPlural(),
            "labels" => $labels,
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
