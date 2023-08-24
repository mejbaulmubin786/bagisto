<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class TaxRateDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('tax_rates')
            ->addSelect(
                'id',
                'identifier',
                'state',
                'country',
                'zip_code',
                'zip_from',
                'zip_to',
                'tax_rate'
            );

        return $queryBuilder;
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.id'),
            'type'       => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'identifier',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.identifier'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'state',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.state'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($value) {
                if (empty($value->state)) {
                    return '*';
                }

                return $value->state;
            },
        ]);

        $this->addColumn([
            'index'      => 'country',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.country'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'zip_code',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.zip-code'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'zip_from',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.zip-from'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'zip_to',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.zip-to'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'tax_rate',
            'label'      => trans('admin::app.settings.taxes.tax-rates.index.datagrid.tax-rate'),
            'type'       => 'integer',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'icon'   => 'icon-edit',
            'title'  => trans('admin::app.settings.taxes.tax-rates.index.datagrid.edit'),
            'method' => 'GET',
            'url'    => function ($row) {
                return route('admin.tax_rates.edit', $row->id);
            },
        ]);

        $this->addAction([
            'icon'   => 'icon-delete',
            'title'  => trans('admin::app.settings.taxes.tax-rates.index.datagrid.delete'),
            'method' => 'POST',
            'url'    => function ($row) {
                return route('admin.tax_rates.delete', $row->id);
            },
        ]);
    }
}
