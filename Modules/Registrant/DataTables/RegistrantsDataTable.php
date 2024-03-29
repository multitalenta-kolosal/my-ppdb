<?php

namespace Modules\Registrant\DataTables;

use Carbon\Carbon;

use Modules\Registrant\Repositories\RegistrantRepository;
use Modules\Core\Repositories\PeriodRepository;
use Modules\Finance\Repositories\InstallmentRepository;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use Illuminate\Support\Arr;

class RegistrantsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(
        RegistrantRepository $registrantRepository,
        PeriodRepository $periodRepository,
        InstallmentRepository $installmentRepository    
    )
    {
        $this->module_name = 'registrants';

        $this->registrantRepository = $registrantRepository;
        $this->periodRepository = $periodRepository;
        $this->installmentRepository = $installmentRepository;
        
        $this->stages = array_merge(config('stages.progress'),config('stages.special-status'));

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                $installment = $this->installmentRepository->query()->whereIn('id',json_decode($data->unit->installment_ids ?? "[]",true))->orderBy('order','asc')->pluck('name','id');

                return view('registrant::backend.includes.action_column', compact('module_name', 'data','installment'));
            })
            ->editColumn('registrant_id', function ($model) {
                $colors = config('tag-color.code');
               
                return '<i class="fas fa-sm fa-circle" style="color:'.$colors[$model->tag_color ?? 0].';"></i> '.$model->registrant_id;
                
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
            ->editColumn('registrant_stage.status_id', function ($data) {
                $selected = Arr::where($this->stages, function ($value, $key) use ($data) {
                    return $value['status_id'] == $data->registrant_stage->status_id;
                });

                $value_array = array_values($selected);

                if($value_array){
                    return "(".$value_array[0]['status_id'].") ".$value_array[0]['pass-title'];
                }else{
                    return "Status Loading...";
                }
            })
            ->editColumn('phone', function ($model) {
                if($model->phone)
                {
                    return '<a href="https://wa.me/'.$model->formatted_phone_parent.'" target="blank">'.$model->phone.'</a>';
                }else{
                    return '-';
                }
            })
            ->editColumn('phone2', function ($model) {
                if($model->phone2)
                {
                    return '<a href="https://wa.me/'.$model->formatted_phone_child.'" target="blank">'.$model->phone2.'</a>';
                }else{
                    return '-';
                }
            })
            ->rawColumns(['name','registrant_id', 'status', 'action','phone','phone2']);
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
     
        $data = $this->registrantRepository->query()
                ->select('registrants.*')
                ->ThisPeriod(my_period())
                ->with(['unit','tier','registrant_stage','path','period']);

        if(!$user->isSuperAdmin() && !$user->hasAllUnitAccess()){
            $unit_id = $user->unit_id;
            $data = $this->registrantRepository->getRegistrantsByUnitQuery($data, $unit_id);
        }

        //START APPLY FILTERING

        if($this->request()->get('name')){
            $data->where('name', 'LIKE', "%".$this->request()->get('name')."%");
        }

        if($this->request()->get('phone')){
            $data->where('phone', 'LIKE', "%".$this->request()->get('phone')."%");
        }

        if($this->request()->get('email')){
            $data->where('email', 'LIKE', "%".$this->request()->get('email')."%");
        }

        if($this->request()->get('former_school')){
            $data->where('former_school', 'LIKE', "%".$this->request()->get('former_school')."%");
        }

        if($this->request()->get('unit_name')){
            $data->where('unit_id', $this->request()->get('unit_name'));
        }

        if($this->request()->get('path')){
            $data->where('type', $this->request()->get('path'));
        }

        if($this->request()->get('tier')){
            $data->whereHas('tier', function($query){
                $query->where('id', 'LIKE', "%".$this->request()->get('tier')."%");
            });
        }

        if($this->request()->get('status') != null){
            $data->whereHas('registrant_stage', function($query){
                $query->where('status_id', $this->request()->get('status'));
            });
        }

        if($this->request()->get('dpp_pass')){
            $data->whereHas('registrant_stage', function($query){
                $query->where('dpp_pass', $this->request()->get('dpp_pass'));
            });
        }

        if($this->request()->get('dp_pass')){
            $data->whereHas('registrant_stage', function($query){
                $query->where('dp_pass', $this->request()->get('dp_pass'));
            });
        }

        if($this->request()->get('spp_pass')){
            $data->whereHas('registrant_stage', function($query){
                $query->where('spp_pass', $this->request()->get('spp_pass'));
            });
        }

        if($this->request()->get('installment')){
            $data->whereHas('registrant_stage', function($query){
                $query->where('installment_id', $this->request()->get('installment'));          
            });
        }
        
        if($this->request()->get('tag_color')){
            $data->where('tag_color', 'LIKE', "%".$this->request()->get('tag_color')."%");
        }

        if($this->request()->get('has_scholarship') != null){
            $data->where('has_scholarship',$this->request()->get('has_scholarship'));
        }
        
        if ($this->request()->get('start_month') != null) {
            $startMonth = $this->request()->get('start_month');
            $data->whereYear('created_at', substr($startMonth, 0, 4))
                 ->whereMonth('created_at', substr($startMonth, 5, 2));
        }
        //END APPLY FILTERING

        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $created_at = 1;
        return $this->builder()
                ->setTableId('registrants-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom(config('ppdb-datatables.ppdb-dom'))
                ->orderBy($created_at,'desc')
                ->buttons(
                    Button::make('export'),
                    Button::make('print'),
                    Button::make('reset')->className('rounded-right'),
                    Button::make('colvis')->text('Kolom')->className('m-2 rounded btn-info'),
                    Button::raw('filterData')->text('Filter')->className('m-2 rounded btn-warning')
                            ->attr([
                                "data-toggle" => "modal",
                                "data-target" => "#filterModal",
                            ])
                            ->text('<i class="fas fa-filter"></i>Filter'),
                )->parameters([
                    'paging' => true,
                    'searching' => true,
                    'info' => true,
                    'responsive' => false,
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

            Column::make('id')->title('data-id')->hidden(),

            Column::make('registrant_id')
                    ->title(__("registrant::$this->module_name.datatable.registrant_id")),

            Column::make('name')
                    ->title(__("registrant::$this->module_name.datatable.name")),

            Column::make('va_number')->hidden()
                    ->title(__("registrant::$this->module_name.datatable.va_number")),

            Column::make('path.name')->data('path.name')->name('path.name')
                    ->title(__("registrant::$this->module_name.datatable.type")),

            Column::make('phone')
                    ->title(__("registrant::$this->module_name.datatable.phone")),

            Column::make('phone2')
                    ->title(__("registrant::$this->module_name.datatable.phone2")),
                   
            // Column::make('info')
            //         ->title(__("registrant::$this->module_name.datatable.info")),

            Column::make('period.period_name')->data('period.period_name')->name('period.period_name')->title('Tahun')->hidden()
                    ->title(__("registrant::$this->module_name.datatable.year")),

            Column::make('email')->hidden()
                    ->title(__("registrant::$this->module_name.datatable.email")),

            Column::make('email_2')->hidden()
            ->title(__("registrant::$this->module_name.datatable.email_2")),

            Column::make('unit.name')->data('unit.name')->name('unit.name')
                    ->title(__("registrant::$this->module_name.datatable.unit")),

            Column::make('tier.tier_name')->data('tier.tier_name')->name('tier.tier_name')->title('Kelas / Jurusan')->hidden()
                    ->title(__("registrant::$this->module_name.datatable.tier")),

            Column::make('former_school')->title('Asal Sekolah')->hidden()
                    ->title(__("registrant::$this->module_name.datatable.former_school")),

            Column::make('has_scholarship')->title('Status Beasiswa')->hidden()
                    ->title(__("registrant::$this->module_name.datatable.has_scholarship")),

            Column::make('scholarship_amount')->title('Nominal Beasiswa')->hidden()
                    ->title(__("registrant::$this->module_name.datatable.scholarship_amount")),

            Column::make('registrant_stage.va_pass_checked_date')->title('Tgl Verif VA')->hidden(),
            Column::make('registrant_stage.entrance_fee_pass_checked_date')->title('Tgl Verif Biaya Pendaftaran')->hidden(),
            Column::make('registrant_stage.requirements_pass_checked_date')->title('Tgl Verif Berkas')->hidden(),
            Column::make('registrant_stage.test_pass_checked_date')->title('Tgl Verif Tes Masuk')->hidden(),
            Column::make('registrant_stage.installment_id_checked_date')->title('Tgl Verif Konfirmasi Angsuran')->hidden(),
            Column::make('registrant_stage.accepted_pass_checked_date')->title('Tgl Verif Heregistrasi')->hidden(),

            Column::make('created_at'),
            Column::make('updated_at')->hidden(),
            Column::make('ref_code')->title('Referee')->hidden(),
            Column::make('register_ip')->title('IP')->hidden(),

            Column::computed('registrant_stage.status_id')->data('registrant_stage.status_id')->name('registrant_stage.status_id')
            ->title(__("registrant::$this->module_name.datatable.status")),
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