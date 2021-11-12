<?php

namespace UPFlex\MixUp\Core;

use UPFlex\MixUp\Core\Interfaces\ITaxonomy;

abstract class Taxonomy extends Base implements ITaxonomy
{
    private array $args = [];
    private bool $male = true;
    private string $name;
    private string $plural;
    private array $postTypes = [];
    private string $singular;
    private string $slug = '';

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPlural(): string
    {
        return $this->plural;
    }

    /**
     * @return array
     */
    public function getPostTypes(): array
    {
        return $this->postTypes;
    }

    /**
     * @return string
     */
    public function getSingular(): string
    {
        return $this->singular;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return bool
     */
    public function isMale(): bool
    {
        return $this->male;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    /**
     * @param bool $male
     */
    public function setMale(bool $male): void
    {
        $this->male = $male;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $plural
     */
    public function setPlural(string $plural): void
    {
        $this->plural = $plural;
    }

    /**
     * @param array $postTypes
     */
    public function setPostTypes(array $postTypes): void
    {
        $this->postTypes = $postTypes;
    }

    /**
     * @param string $singular
     */
    public function setSingular(string $singular): void
    {
        $this->singular = $singular;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function register(): void
    {
        $custom_args = [];

        $labels = [
            "name" => $this->getPlural(),
            "singular_name" => $this->getSingular(),
            "menu_name" => $this->getPlural(),
            "all_items" => $this->isMale() ? sprintf(__("Todos os %s"), $this->getPlural()) : sprintf(__("Todas as %s"), $this->getPlural()),
            "edit_item" => sprintf(__("Editar %s"), $this->getSingular()),
            "view_item" => sprintf(__("Ver %s"), $this->getSingular()),
            "update_item" => $this->isMale() ? sprintf(__("Atualizar nome do %s"), $this->getSingular()) : sprintf(__("Atualizar nome da %s"), $this->getSingular()),
            "add_new_item" => $this->isMale() ? sprintf(__("Adicionar novo %s"), $this->getSingular()) : sprintf(__("Adicionar nova %s"), $this->getSingular()),
            "new_item_name" => $this->isMale() ? sprintf(__("Novo %s"), $this->getSingular()) : sprintf(__("Nova %s"), $this->getSingular()),
            "parent_item" => sprintf(__("%s ascendente"), $this->getSingular()),
            "parent_item_colon" => sprintf(__("%s ascendente:"), $this->getSingular()),
            "search_items" => sprintf(__("Pesquisar %s"), $this->getPlural()),
            "popular_items" => sprintf(__("%s mais populares"), $this->getPlural()),
            "separate_items_with_commas" => sprintf(__("Separe %s com vírgulas"), $this->getPlural()),
            "add_or_remove_items" => sprintf(__("Adicionar ou excluir %s"), $this->getPlural()),
            "choose_from_most_used" => sprintf(__("Escolher entre os termos mais usados de %s"), $this->getPlural()),
            "not_found" => $this->isMale() ? sprintf(__("Nenhum %s encontrado"), $this->getSingular()) : sprintf(__("Nenhuma %s encontrada"), $this->getSingular()),
            "no_terms" => $this->isMale() ? sprintf(__("Nenhum %s"), $this->getSingular()) : sprintf(__("Nenhuma %s"), $this->getSingular()),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), $this->getPlural()),
            "items_list" => sprintf(__("Lista de %s"), $this->getPlural()),
            "back_to_items" => sprintf(__("Voltar para %s"), $this->getPlural())
        ];


        $args = [
            "label" => $this->getPlural(),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => ["slug" => strlen($this->getSlug()) > 0 ? $this->getSlug() : $this->getName(), "with_front" => true],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => $this->getName(),
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "show_in_quick_edit" => false,
            "show_in_graphql" => false,
        ];

        register_taxonomy($this->getName(), $this->getPostTypes(), array_merge($args, array_filter($this->getArgs())));
    }
}