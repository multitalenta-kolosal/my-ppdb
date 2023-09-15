<?php

namespace Modules\Registrant\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Registrant\Services\RegistrantStageService;
use Modules\Registrant\Repositories\RegistrantStageRepository;

use Modules\Registrant\Entities\Registrant;

use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

class CreateVaBySFTP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $registrant;
    protected $registrantStageRepository;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Registrant $registrant
        )
    {
        $this->registrant = $registrant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RegistrantStageRepository $registrantStageRepository,RegistrantStageService $registrantStageService)
    {

        $sftp_push = \Storage::disk('sftp')->put('89955_'.$this->registrant->va_number.'.txt', $this->composeTxtContent($this->registrant));
        
        DB::beginTransaction();

        try{
            if($sftp_push){
                $registrantstage_check = $registrantStageRepository->findBy('registrant_id',$this->registrant->registrant_id);

                if($registrantstage_check){
                    $registrantStage = $registrantStageRepository->makeModel();
                    $registrantStage->va_pass = true;
                    $registrantStage->status_id = $registrantStageService->getSetStatus($registrantStage);

                    $registrant_stage = $registrantStageRepository->update($registrantStage->toArray(),$registrantstage_check->id);
    
                    \Log::info(label_case('CreateVaBySFTP AT '.Carbon::now().' | Function: Store to MFT for: '.$registrantstage_check->registrant_id.' | Msg: '.json_encode($sftp_push)));
                }  
            }else{
                Log::critical(label_case('CreateVaBySFTP AT '.Carbon::now().' | Function: Store to MFT for: '.$registrantstage_check->registrant_id.' ERROR | Msg: Cannot Create'));
            }
        }catch(Exception $e){
            DB::rollBack();
            Log::critical(label_case('CreateVaBySFTP AT '.Carbon::now().' | Function: Store to MFT for: '.$registrantstage_check->registrant_id.' | Msg: '.$e->getMessage().' path_id: '.$registrantStage->registrant_id));
        }

        DB::commit();
            
    }

    public function composeTxtContent($registrant){

        $va = $registrant->va_number;
        $name = $registrant->name;
        $unit_name = $registrant->unit->name;
        $open_date = Carbon::now()->format('Ymd');
        $close_date = Carbon::now()->addYears(7)->format('Ymd'); //change to year
        $bill = $this->getBillRecapAnnualized($registrant);

        $composed= 
        'NO VA|Bill Key 2|Bill Key 3|Currency|NAMA|UNIT|KET|Bill Info 4|Bill Info 5|Bill Info 6|Bill Info 7|Bill Info 8|Bill Info 9|Bill Info 10|Bill Info 11|Bill Info 12|Bill Info 13|Bill Info 14|Bill Info 15|Bill Info 16|Bill Info 17|Bill Info 18|Bill Info 19|Bill Info 20|Bill Info 21|Bill Info 22|Bill Info 23|Bill Info 24|Bill Info 25|Periode Open|Periode Close|Tagihan 1|Tagihan 2|Tagihan 3|Tagihan 4|Tagihan 5|Tagihan 6|Tagihan 7|Tagihan 8|Tagihan 9|Tagihan 10|Tagihan 11|Tagihan 12|Tagihan 13|Tagihan 14|Tagihan 15|Tagihan 16|Tagihan 17|Tagihan 18|Tagihan 19|Tagihan 20|Tagihan 21|Tagihan 22|Tagihan 23|Tagihan 24|Tagihan 25|'.
        "\n".$va.'|||IDR|'.$name.'|'.$unit_name.' WARGA|SPP|||||||||||||||||||||||'.$open_date.'|'.$close_date.'|01\\TOTAL\\TOTAL\\'.$bill."|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|\\\\\|~";
         
        return $composed;
    }

    public function getBillRecapAnnualized($registrant){
        $unit_name = $registrant->unit->name;

        switch($unit_name){
            case 'KB/TK':
                    return '8650000';
                break;
            case 'SD':
                    return '7786500';
                break;
            case 'SMP':
                    return '10550000';
                break;
            case 'SMA':
                    return '12600000';
                break;
            case 'SMK':
                    if($registrant->unit->have_major){
                        $tier_name = $registrant->tier->tier_name;
                        switch($tier_name){
                            case 'Teknik Pemesinan':
                                    return '13150000';
                                break;
                            case 'Teknik Elektronika Industri':
                                    return '8150000';
                                break;
                            case 'Teknik Kendaraan Ringan':
                                    return '13150000';
                                break;
                            default:
                                    return '10';
                                break;
                        }
                    }else{
                        return '10';
                    }
                break;
            default:
                    return '10';
                break;
        }
    }
}
