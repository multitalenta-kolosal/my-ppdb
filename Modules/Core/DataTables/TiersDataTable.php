<?php

namespace Modules\Core\DataTables;

use Carbon\Carbon;
use Modules\Core\Repositories\TierRepository;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TiersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(TierRepository $tierRepository)
    {
        $this->module_name = 'tiers';

        $this->tierRepository = $tierRepository;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column_admin', compact('module_name', 'data'));
            })
            ->editColumn('unit_id',function ($model){
                if($model->unit)
                {
                    return $model->unit->name;
                }else{
                    return 'Unit Not Available';
                }
            })
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('LLLL');
                }
            })
            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;

                $formated_date = Carbon::parse($data->created_at)->format('d-m-Y, H:i:s');

                return $formated_date;
            })
            ->rawColumns(['tier_name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Tier $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $data = $this->tierRepository->query()->orderBy('order','asc');

        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                ->setTableId('tiers-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom(config('ppdb-datatables.ppdb-dom'))
                ->buttons(
                    Button::make('export'),
                    Button::make('print'),
                    Button::make('reset')->className('rounded-right'),
                    Button::make('colvis')->text('Kolom')->className('m-2 rounded btn-info'),
                )->parameters([
                    'paging' => true,
                    'searching' => true,
                    'info' => true,
                    'responsive' => true,
                    'autoWidth' => false,
                    'searchDelay' => 350,
                ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
            Column::make('tier_name'),
            Column::make('unit')->data('unit_id')->name('unit_id'),
            Column::make('contact_number')->hidden(),
            Column::make('contact_email')->hidden(),
            Column::make('tier_requirements')->hidden(),
            Column::make('entrance_test_url')->hidden(),
            Column::make('dpp')->hidden(),
            Column::make('dp')->hidden(),
            Column::make('spp')->hidden(),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Tiers_' . date('YmdHis');
    }
}