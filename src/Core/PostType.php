<?php

namespace UPFlex\MixUp\Core;

use UPFlex\MixUp\Core\Interfaces\IPostTypes;

abstract class PostType extends Base implements IPostTypes
{
    private array $args = [];
    private string $icon = '';
    private bool $male = true;
    private string $name;
    private string $plural;
    private string $singular;
    private string $slug = '';
    private array $supports = ["title", "thumbnail"];

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
    public function getIcon(): string
    {
        return $this->icon;
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
     * @return array
     */
    public function getSupports(): array
    {
        return $this->supports;
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
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
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

    /**
     * @param array $supports
     */
    public function setSupports(array $supports): void
    {
        $this->supports = $supports;
    }

    public function register(): void
    {
        $labels = [
            "name" => $this->getPlural(),
            "singular_name" => $this->getSingular(),
            "menu_name" => $this->getPlural(),
            "all_items" => $this->isMale() ? sprintf(__("Todos os %s"), $this->getPlural()) : sprintf(__("Todas as %s"), $this->getPlural()),
            "add_new" => $this->isMale() ? __("Adicionar novo") : __("Adicionar nova"),
            "add_new_item" => $this->isMale() ? sprintf(__("Adicionar novo %s"), $this->getSingular()) : sprintf(__("Adicionar nova %s"), $this->getSingular()),
            "edit_item" => sprintf(__("Editar %s"), $this->getSingular()),
            "new_item" => $this->isMale() ? sprintf(__("Novo %s"), $this->getSingular()) : sprintf(__("Nova %s"), $this->getSingular()),
            "view_item" => sprintf(__("Ver %s"), $this->getSingular()),
            "view_items" => sprintf(__("Ver %s"), $this->getPlural()),
            "search_items" => sprintf("Pesquisar %s", $this->getPlural()),
            "not_found" => $this->isMale() ? sprintf(__("Nenhum %s encontrado"), $this->getSingular()) : sprintf(__("Nenhuma %s encontrada"), $this->getSingular()),
            "not_found_in_trash" => $this->isMale() ? sprintf(__("Nenhum %s encontrado na lixeira"), $this->getSingular()) : sprintf("Nenhuma %s encontrada na lixeira", $this->getSingular()),
            "parent" => sprintf(__("%s ascendente"), $this->getSingular()),
            "featured_image" => $this->isMale() ? sprintf(__("Imagem destacada para esse %s"), $this->getSingular()) : sprintf(__("Imagem destacada para essa %s"), $this->getSingular()),
            "set_featured_image" => $this->isMale() ? sprintf(__("Definir imagem destacada para esse %s"), $this->getSingular()) : sprintf(__("Definir imagem destacada para essa %s"), $this->getSingular()),
            "remove_featured_image" => $this->isMale() ? sprintf(__("Remover imagem destacada para esse %s"), $this->getSingular()) : sprintf(__("Remover imagem destacada para essa %s"), $this->getSingular()),
            "use_featured_image" => $this->isMale() ? sprintf(__("Usar como imagem destacada para esse %s"), $this->getSingular()) : "Usar como imagem destacada para essa {$this->getSingular()}",
            "archives" => $this->isMale() ? sprintf(__("Arquivos do %s"), $this->getSingular()) : sprintf(__("Arquivos da %s"), $this->getSingular()),
            "insert_into_item" => $this->isMale() ? sprintf(__("Inserir no %s"), $this->getSingular()) : sprintf(__("Inserir na %s"), $this->getSingular()),
            "uploaded_to_this_item" => $this->isMale() ? sprintf(__("Enviar para esse %s"), $this->getSingular()) : sprintf(__("Enviar para essa %s"), $this->getSingular()),
            "filter_items_list" => sprintf(__("Filtrar lista de %s"), $this->getPlural()),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), $this->getPlural()),
            "items_list" => sprintf(__("Lista de %s"), $this->getPlural()),
            "attributes" => sprintf(__("Atributos de %s"), $this->getPlural()),
            "name_admin_bar" => $this->getSingular(),
            "item_published" => $this->isMale() ? sprintf(__("%s publicado"), $this->getSingular()) : sprintf(__("%s publicada"), $this->getSingular()),
            "item_published_privately" => $this->isMale() ? sprintf(__("%s publicado de forma privada."), $this->getSingular()) : sprintf(__("%s publicada de forma privada."), $this->getSingular()),
            "item_reverted_to_draft" => $this->isMale() ? sprintf(__("%s revertido para rascunho."), $this->getSingular()) : sprintf(__("%s revertida para rascunho."), $this->getSingular()),
            "item_scheduled" => $this->isMale() ? sprintf(__("%s agendado"), $this->getSingular()) : sprintf(__("%s agendada"), $this->getSingular()),
            "item_updated" => $this->isMale() ? sprintf(__("%s atualizado."), $this->getSingular()) : sprintf(__("%s atualizada."), $this->getSingular()),
            "parent_item_colon" => sprintf(__("%s ascendente:"), $this->getSingular()),
        ];

        $args = [
            "label" => $this->getPlural(),
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
            "rewrite" => ["slug" => strlen($this->getSlug()) > 0 ? $this->getSlug() : $this->getName(), "with_front" => true],
            "query_var" => true,
            "menu_icon" => $this->getIcon(),
            "supports" => $this->getSupports(),
            "show_in_graphql" => false,
        ];

        register_post_type($this->getName(), array_merge($args, array_filter($this->getArgs())));
    }
}