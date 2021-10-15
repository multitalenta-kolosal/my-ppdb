<?php

namespace Modules\Referal\DataTables;

use Carbon\Carbon;
use Modules\Referal\Repositories\RefereeRepository;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RefereesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(RefereeRepository $refereeRepository)
    {
        $this->module_name = 'referees';

        $this->refereeRepository = $refereeRepository;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('referal::backend.includes.action_column', compact('module_name', 'data'));
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
            ->rawColumns(['name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Referee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $data = $this->refereeRepository->query();

        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $created_at = 7;
        return $this->builder()
                ->setTableId('referees-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom(config('ppdb-datatables.ppdb-dom'))
                ->orderBy($created_at,'desc')
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
            Column::make('name'),
            Column::make('ref_code'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('bank_code')->hidden(),
            Column::make('bank_name'),
            Column::make('bank_account'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Referees_' . date('YmdHis');
    }
}