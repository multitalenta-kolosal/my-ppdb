<?php

namespace Modules\Message\DataTables;

use Carbon\Carbon;
use Log;
use Modules\Message\Repositories\RegistrantMessageRepository;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RegistrantMessagesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(RegistrantMessageRepository $registrantMessageRepository)
    {
        $this->module_name = 'registrantmessages';

        $this->registrantMessageRepository = $registrantMessageRepository;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return "action";
            })
            ->editColumn('register_pass_message_sent', function ($data) {
                return $this->convertMessageConfirmation($data->register_pass_message_sent);
            })
            ->editColumn('requirements_pass_message_sent', function ($data) {
                return $this->convertMessageConfirmation($data->requirements_pass_message_sent);
            })
            ->editColumn('test_pass_message_sent', function ($data) {
                return $this->convertMessageConfirmation($data->test_pass_message_sent);
            })
            ->editColumn('accepted_pass_message_sent', function ($data) {
                return $this->convertMessageConfirmation($data->accepted_pass_message_sent);
            })
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $formated_date = Carbon::parse($data->created_at)->format('d-m-Y, H:i:s');

                return $formated_date;
            })
            ->rawColumns([
                'code',
                'message', 
                'action',
                'register_pass_message_sent',
                'requirements_pass_message_sent',
                'test_pass_message_sent',
                'accepted_pass_message_sent',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Message $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $user = auth()->user();
        if(!$user->isSuperAdmin() && !$user->hasAllUnitAccess()){
            $unit_id = $user->unit_id;
            $data = $this->registrantMessageRepository->getRegistrantMessagesByUnitQuery($unit_id)->with('registrant');
        }else{
            $data = $this->registrantMessageRepository->query()->with('registrant');
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
        $updated_at = 7;
        return $this->builder()
                ->setTableId('messages-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom(config('ppdb-datatables.ppdb-dom'))
                ->orderBy($updated_at)
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
            Column::make('registrant_id')->title('Registrant ID'),
            Column::make('registrant.name')->title('Name')->data('registrant.name')->name('registrant.name'),
            Column::make('register_pass_message_sent')->title('Reg.'),
            Column::make('requirements_pass_message_sent')->title('Req.'),
            Column::make('test_pass_message_sent')->title('Test'),
            Column::make('accepted_pass_message_sent')->title('Accepted'),
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
        return 'Message_Trackers_' . date('YmdHis');
    }

    protected function convertMessageConfirmation($value){
        $failed = 'GAGAL';
        $null = '--';
        $success = 'OK';

        switch($value){
            case '-1':
                return '<span class="text-danger">'.$failed.'</span>';
                break;
            case '0':
                return '<span class="text-warning">'.$null.'</span>';
                break;
            case '1':
                return '<span class="text-success">'.$success.'</span>';
                break;
        }
    }
}