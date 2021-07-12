<?php

namespace Modules\Registrant\DataTables;

use Carbon\Carbon;
use Modules\Registrant\Repositories\RegistrantRepository;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RegistrantsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(RegistrantRepository $registrantRepository)
    {
        $this->module_name = 'registrants';

        $this->registrantRepository = $registrantRepository;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('unit', function ($model) {
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
            ->rawColumns(['name', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Registrant $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $data = $this->registrantRepository->query();

        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $created_at = 5;
        return $this->builder()
                ->setTableId('registrants-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom('Blfrtip')
                ->orderBy($created_at)
                ->buttons(
                    Button::make('export'),
                    Button::make('print'),
                    Button::make('reset')
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
            Column::make('registrant_id'),
            Column::make('name'),
            Column::make('phone'),
            Column::make('unit_id'),
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
        return 'Registrants_' . date('YmdHis');
    }
}