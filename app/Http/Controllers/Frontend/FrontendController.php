<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\Registrant\Services\RegistrantService;

class FrontendController extends Controller
{
    protected $registrantService;
   
    public function __construct(
        RegistrantService $registrantService
    )
    {
        $this->registrantService = $registrantService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $body_class = '';

        $options = $this->registrantService->prepareOptions();

        $unit_options = $options['unit'];
        $type_options = $options['type'];

        return view('frontend.index', compact('body_class','unit_options','type_options'));
    }

    /**
     * Privacy Policy Page
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        $body_class = '';

        return view('frontend.privacy', compact('body_class'));
    }

    /**
     * Terms & Conditions Page
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        $body_class = '';

        return view('frontend.terms', compact('body_class'));
    }
}
