<?php

namespace Modules\Registrant\Charts;

use Modules\Registrant\Services\RegistrantStageService;
use Modules\Message\Services\RegistrantMessageService;
use Modules\Message\Services\MessageService;

use Modules\Registrant\Repositories\RegistrantRepository;
use Modules\Registrant\Repositories\RegistrantStageRepository;
use Modules\Message\Repositories\RegistrantMessageRepository;
use Modules\Finance\Repositories\InstallmentRepository;
use Modules\Core\Repositories\UnitRepository;
use Modules\Core\Repositories\PeriodRepository;
use Modules\Core\Repositories\PathRepository;
use Modules\Core\Repositories\TierRepository;

use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegistrantInsight{

    protected $registrantMessageService;
    protected $registrantStageService;
    protected $messageService;

    protected $registrantRepository;
    protected $unitRepository;
    protected $periodRepository;
    protected $pathRepository;
    protected $tierRepository;
    protected $installmentRepository;

    public function __construct(
        /**
         * Services Parameter
         * 
         */
        RegistrantMessageService $registrantMessageService,
        RegistrantStageService $registrantStageService,
        MessageService $messageService,
        /**
         * Repositories Parameter
         * 
         */
        PathRepository $pathRepository,
        RegistrantRepository $registrantRepository,
        RegistrantStageRepository $registrantStageRepository,
        RegistrantMessageRepository $registrantMessageRepository,
        UnitRepository $unitRepository,
        PeriodRepository $periodRepository,
        TierRepository $tierRepository,
        InstallmentRepository $installmentRepository
    ) {
        /**
         * Services Declaration
         * 
         */
        $this->registrantMessageService = $registrantMessageService;
        $this->registrantStageService = $registrantStageService;
        $this->messageService = $messageService;
        /**
         * Repositories Declaration
         * 
         */
        $this->pathRepository = $pathRepository;
        $this->registrantRepository = $registrantRepository;
        $this->registrantStageRepository = $registrantStageRepository;
        $this->registrantMessageRepository = $registrantMessageRepository;
        $this->unitRepository = $unitRepository;
        $this->periodRepository = $periodRepository;
        $this->tierRepository = $tierRepository;
        $this->installmentRepository = $installmentRepository;

        $this->module_title = Str::plural(class_basename($this->registrantRepository->model()));

    }

    public function build(){
        $register = $this->collectRegistrant();
        $hereg = $this->collectHeregistrant();
        $units = $this->unitRepository->query()->orderBy('id', 'asc')->get();
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'units'=> $units,
            'register'=> $register,
            'hereg'=> $hereg,
        );
    }

    public function collectRegistrant(){

        $units_raw = $this->unitRepository->query()->orderBy('id', 'asc')->get();
        
        $units = [];
        foreach($units_raw as $unit_raw){
            $units += [$unit_raw->name => 0];
        }
        
        $groups = $this->registrantRepository->query()->join('units', 'registrants.unit_id','=','units.id')
        ->select('units.id as unit_no', 'registrants.id','registrants.name','units.name as unit_name','registrants.created_at')
        ->where('period_id',my_period())
        ->get()
        ->groupBy([
            function($date) {
                return Carbon::parse($date->created_at)->format('F');
                },
            'unit_name'])
        ->sortBy('unit_no');

        $registrantCounter = [];

        foreach($groups as $keyM => $valueM){
            $unitCounter = [];
            foreach($valueM as $keyUnit => $valueUnit){
                $unitCounter += [$keyUnit => count($valueUnit)];
            }
            $trueUnitCounter = array_replace($units, $unitCounter);
            $registrantCounter += [$keyM => $trueUnitCounter];
        }

        return $registrantCounter;
    }

    public function collectHeregistrant(){

        $units_raw = $this->unitRepository->query()->orderBy('id', 'asc')->get();
        
        $units = [];
        foreach($units_raw as $unit_raw){
            $units += [$unit_raw->name => 0];
        }
        
        $groups = $this->registrantRepository->query()->join('units', 'registrants.unit_id','=','units.id')->join('registrant_stages', 'registrants.progress_id','=','registrant_stages.id')
        ->select('units.id as unit_no', 'registrants.id','registrants.name','units.name as unit_name','accepted_pass','registrants.created_at')
        ->where('period_id',my_period())
        ->where('accepted_pass', 1)
        ->get()
        ->groupBy([
            function($date) {
                return Carbon::parse($date->created_at)->format('F');
                },
            'unit_name'])
        ->sortBy('unit_no');

        $registrantCounter = [];

        foreach($groups as $keyM => $valueM){
            $unitCounter = [];
            foreach($valueM as $keyUnit => $valueUnit){
                $unitCounter += [$keyUnit => count($valueUnit)];
            }
            $trueUnitCounter = array_replace($units, $unitCounter);
            $registrantCounter += [$keyM => $trueUnitCounter];
        }
        $emptyMonths = $this->generateEmptyMonth();

        $trueResult = array_replace($emptyMonths, $registrantCounter);

        return $trueResult;
    }

    private function generateEmptyMonth(){

        $units_raw = $this->unitRepository->pluck('name');
        
        $units = [];
        foreach($units_raw as $unit_raw){
            $units += [$unit_raw => 0];
        }
        
        $groups = $this->registrantRepository->query()->join('units', 'registrants.unit_id','=','units.id')
        ->select('units.id as unit_no', 'registrants.id','registrants.name','units.name as unit_name','registrants.created_at')
        ->where('period_id',my_period())
        ->get()
        ->groupBy([
            function($date) {
                return Carbon::parse($date->created_at)->format('F');
                },
            'unit_name'])
        ->sortBy('unit_no');

        $registrantCounter = [];

        foreach($groups as $keyM => $valueM){
            $unitCounter = [];
            foreach($valueM as $keyUnit => $valueUnit){
                $unitCounter += [$keyUnit => 0];
            }
            $trueUnitCounter = array_replace($units, $unitCounter);
            $registrantCounter += [$keyM => $trueUnitCounter];
        }
        return $registrantCounter;
    }
}