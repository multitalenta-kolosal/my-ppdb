<?php

namespace Modules\Registrant\Services;

use Modules\Registrant\Repositories\RegistrantRepository;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Modules\Registrant\Events\Backend\RegistrantCreated;

class RegistrantService{

    protected $registrantRepository;

    public function __construct(RegistrantRepository $registrantRepository) {

        $this->registrantRepository = $registrantRepository;
    }

    public function getAll(){

        $registrant =$this->registrantRepository->all();

        return $registrant;
    }

    public function getIndexList(Request $request){

        $listData = [];

        $term = trim($request->q);

        if (empty($term)) {
            return $listData;
        }

        $query_data = $this->registrantRepository->findWhere(['name', 'LIKE', "%$term%"]);

        foreach ($query_data as $row) {
            $listData[] = [
                'id'   => $row->id,
                'text' => $row->name,
            ];
        }

        return $listData;
    }

    public function store(Request $request){

        $data = $request->all();

        $registrant = $this->registrantRepository->create($data);

        event(new RegistrantCreated($registrant));

        return $registrant;
    }

    public function show($id){

        return $this->registrantRepository->findOrFail($id);
    }

    public function edit($id){

        return $this->registrantRepository->findOrFail($id);
    }

    public function update(Request $request,$id){

        $data = $request->all();

        $registrants = $this->registrantRepository->findOrFail($id);

        $updated = $this->registrantRepository->update($data,$id);

        return $this->registrantRepository->find($id);

    }

    public function destroy($id){

        $registrants = $this->registrantRepository->findOrFail($id);

        $deleted = $this->registrantRepository->delete($id);

        return $registrants;
    }

    public function trashed(){
        return $this->registrantRepository->trashed();
    }

    public function restore($id){

        $registrants= $this->registrantRepository->restore($id);

        return $registrants;
    }

    public function prepareOptions(){
        
        $unit = [
            'KB/TK',
            'SD',
            'SMP',
            'SMA',
            'SMK',
        ];

        $type = [
            'Prestasi',
            'Reguler',
        ];

        $options = array(
            'unit' => $unit,
            'type' => $type,
        );

        return $options;
    }

    public function generateId(){
        $year = Carbon::now()->format('y');

        $month = Carbon::now()->format('m');

        $response = [
            'id'   => $year.$month,
            'error' => false,
            'message' => '',
        ];
    
        return $response;
    }
}