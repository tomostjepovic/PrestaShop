<?php

namespace PrestaShop\Module\B2BWholesale\Core\Grid\Definition\Factory;

use FOS\JsRoutingBundle\Command\DumpCommand;
use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Type\SimpleGridAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;

use PrestaShop\Module\B2BWholesale\Core\Grid\Query;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\DeleteActionTrait;
use Symfony\Component\HttpFoundation\Request;

final class ActivityTypeGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    use DeleteActionTrait;
    protected function getId(): string
    {
        return 'activity_types';
    }

    protected function getName(): string
    {
        return $this->trans('Activity types', [], 'Admin.ActivityType.Feature');
    }

    protected function getColumns()
    {
        $columns = (new ColumnCollection())
            ->add((new DataColumn('id_activity_type'))
                ->setName($this->trans('ID', [], 'Admin.Global'))
                ->setOptions([
                    'field' => 'id_activity_type',
                ])
            )
            ->add((new DataColumn('name'))
                ->setName($this->trans('Name', [], 'Admin.Global'))
                ->setOptions([
                    'field' => 'name',
                ])
            )
            ->add((new ActionColumn('actions'))
                ->setName($this->trans('Actions', [], 'Admin.Global'))
                ->setOptions([
                    'actions' => (new RowActionCollection())
                        ->add((new LinkRowAction('edit'))
                            ->setName($this->trans('Edit', [], 'Admin.Actions'))
                            ->setIcon('edit')
                            ->setOptions([
                                'route' => 'activity_type_edit',
                                'route_param_name' => 'activityTypeId',
                                'route_param_field' => 'id_activity_type',
                            ])
                        )
                        ->add(
                            $this->buildDeleteAction(
                                'activity_type_delete',
                                'activityTypeId',
                                'id_activity_type',
                                Request::METHOD_DELETE
                            )
                        ),
                ])
            );
        return $columns;
    }

    protected function getGridActions()
    {
        return (new GridActionCollection())
            ->add(
                (new SimpleGridAction('common_refresh_list'))
                    ->setName($this->trans('Refresh list', [], 'Admin.Advparameters.Feature'))
                    ->setIcon('refresh')
            )
            ->add(
                (new SimpleGridAction('common_show_query'))
                    ->setName($this->trans('Show SQL query', [], 'Admin.Actions'))
                    ->setIcon('code')
            )
            ->add(
                (new SimpleGridAction('common_export_sql_manager'))
                    ->setName($this->trans('Export to SQL Manager', [], 'Admin.Actions'))
                    ->setIcon('storage')
            );
    }
}
