<?php

namespace UPFlex\MixUp\Core\Parent;

use UPFlex\MixUp\Core\Base;
use UPFlex\MixUp\Core\Interfaces\IPostTypes;
use UPFlex\MixUp\Core\Traits\GroupingType;

abstract class PostType extends Base implements IPostTypes
{
    use GroupingType;

    protected string $icon = '';
    protected array $supports = ["title", "thumbnail"];

    public function getIcon(): string
    {
        return $this->icon;
    }

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
            "add_new" => $instance->isMale() ? __("Adicionar novo") : __("Adicionar nova"),
            "add_new_item" => $instance->isMale()
                ? sprintf(__("Adicionar novo %s"), $instance->getSingular())
                : sprintf(__("Adicionar nova %s"), $instance->getSingular()),
            "edit_item" => sprintf(__("Editar %s"), $instance->getSingular()),
            "new_item" => $instance->isMale()
                ? sprintf(__("Novo %s"), $instance->getSingular())
                : sprintf(__("Nova %s"), $instance->getSingular()),
            "view_item" => sprintf(__("Ver %s"), $instance->getSingular()),
            "view_items" => sprintf(__("Ver %s"), $instance->getPlural()),
            "search_items" => sprintf("Pesquisar %s", $instance->getPlural()),
            "not_found" => $instance->isMale()
                ? sprintf(__("Nenhum %s encontrado"), $instance->getSingular())
                : sprintf(__("Nenhuma %s encontrada"), $instance->getSingular()),
            "not_found_in_trash" => $instance->isMale()
                ? sprintf(__("Nenhum %s encontrado na lixeira"), $instance->getSingular())
                : sprintf("Nenhuma %s encontrada na lixeira", $instance->getSingular()),
            "parent" => sprintf(__("%s ascendente"), $instance->getSingular()),
            "featured_image" => $instance->isMale()
                ? sprintf(__("Imagem destacada para esse %s"), $instance->getSingular())
                : sprintf(__("Imagem destacada para essa %s"), $instance->getSingular()),
            "set_featured_image" => $instance->isMale()
                ? sprintf(__("Definir imagem destacada para esse %s"), $instance->getSingular())
                : sprintf(__("Definir imagem destacada para essa %s"), $instance->getSingular()),
            "remove_featured_image" => $instance->isMale()
                ? sprintf(__("Remover imagem destacada para esse %s"), $instance->getSingular())
                : sprintf(__("Remover imagem destacada para essa %s"), $instance->getSingular()),
            "use_featured_image" => $instance->isMale()
                ? sprintf(__("Usar como imagem destacada para esse %s"), $instance->getSingular())
                : "Usar como imagem destacada para essa {$instance->getSingular()}",
            "archives" => $instance->isMale()
                ? sprintf(__("Arquivos do %s"), $instance->getSingular())
                : sprintf(__("Arquivos da %s"), $instance->getSingular()),
            "insert_into_item" => $instance->isMale()
                ? sprintf(__("Inserir no %s"), $instance->getSingular())
                : sprintf(__("Inserir na %s"), $instance->getSingular()),
            "uploaded_to_this_item" => $instance->isMale()
                ? sprintf(__("Enviar para esse %s"), $instance->getSingular())
                : sprintf(__("Enviar para essa %s"), $instance->getSingular()),
            "filter_items_list" => sprintf(__("Filtrar lista de %s"), $instance->getPlural()),
            "items_list_navigation" => sprintf(__("Navegação na lista de %s"), $instance->getPlural()),
            "items_list" => sprintf(__("Lista de %s"), $instance->getPlural()),
            "attributes" => sprintf(__("Atributos de %s"), $instance->getPlural()),
            "name_admin_bar" => $instance->getSingular(),
            "item_published" => $instance->isMale()
                ? sprintf(__("%s publicado"), $instance->getSingular())
                : sprintf(__("%s publicada"), $instance->getSingular()),
            "item_published_privately" => $instance->isMale()
                ? sprintf(__("%s publicado de forma privada."), $instance->getSingular())
                : sprintf(__("%s publicada de forma privada."), $instance->getSingular()),
            "item_reverted_to_draft" => $instance->isMale()
                ? sprintf(__("%s revertido para rascunho."), $instance->getSingular())
                : sprintf(__("%s revertida para rascunho."), $instance->getSingular()),
            "item_scheduled" => $instance->isMale()
                ? sprintf(__("%s agendado"), $instance->getSingular())
                : sprintf(__("%s agendada"), $instance->getSingular()),
            "item_updated" => $instance->isMale()
                ? sprintf(__("%s atualizado."), $instance->getSingular())
                : sprintf(__("%s atualizada."), $instance->getSingular()),
            "parent_item_colon" => sprintf(__("%s ascendente:"), $instance->getSingular()),
        ];
    }

    public function getSupports(): array
    {
        return $this->supports;
    }

    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    public function setSupports(array $supports): void
    {
        $this->supports = $supports;
    }

    public static function register(): void
    {
        $class = get_called_class();
        $instance = (new $class);

        $args = [
            "label" => $instance->getPlural(),
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
                "slug" => strlen($instance->getSlug()) > 0
                    ? $instance->getSlug()
                    : $instance->getName(),
                "with_front" => true
            ],
            "query_var" => true,
            "menu_icon" => $instance->getIcon(),
            "supports" => $instance->getSupports(),
            "show_in_graphql" => false,
        ];

        register_post_type($instance->getName(), array_merge($args, array_filter($instance->getArgs())));
    }
}
