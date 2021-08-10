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

                return view('registrant::backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('name', function ($model) {
                if( ($model->registrant_stage->status_id ?? null) == -1)
                {
                    return '<span class="text-danger">'.$model->name.'</span>';
                }else{
                    return $model->name;
                }
            })
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                \Log::debug(json_encode($data));

                if ($diff < 25) {
                    return $data->updated_at ? $data->updated_at->diffForHumans() : '-';
                } else {
                    return $data->updated_at->isoFormat('LLLL');
                }
            })
            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;

                $formated_date = Carbon::parse($data->created_at)->format('d M Y, H:i:s');

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
        $user = auth()->user();
        if(!$user->isSuperAdmin() && !$user->hasAllUnitAccess()){
            $unit_id = $user->unit_id;
            $data = $this->registrantRepository->query()
                    ->select('registrants.*')
                    ->with(['unit','tier','registrant_stage','path','period'])
                    ->getRegistrantsByUnitQuery($unit_id);
        }else{
            $data = $this->registrantRepository->query()
                    ->select('registrants.*')
                    ->with(['unit','tier','registrant_stage','path','period']);
        }

        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $created_at = 11;
        return $this->builder()
                ->setTableId('registrants-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom('Blfrtip')
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
            Column::make('registrant_id'),
            Column::make('va_number')->hidden(),
            Column::make('path.name')->data('path.name')->name('path.name')->title('Jalur'),
            Column::make('name'),
            Column::make('phone'),
            Column::make('period.period_name')->data('period.period_name')->name('period.period_name')->title('Tahun')->hidden(),
            Column::make('email')->hidden(),
            Column::make('unit.name')->data('unit.name')->name('unit.name')->title('Unit'),
            Column::make('tier.tier_name')->data('tier.tier_name')->name('tier.tier_name')->title('Kelas / Jurusan'),
            Column::make('former_school')->title('Asal Sekolah')->hidden(),
            Column::make('created_at'),
            Column::make('updated_at')->hidden(),
            Column::make('register_ip')->title('IP')->hidden(),
            Column::computed('registrant_stage.status_id')->data('registrant_stage.status_id')->name('registrant_stage.status_id')->title('Status'),
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