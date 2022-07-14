<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GuzzleHttp\Client;
use DataTables;

class CovidCaseController extends Controller
{
    public function listStateCases()
    {
        return View('listCovidCases');
    }

    public function listDistrictCases($state)
    {
        return View('listDistrictCovidCases')->with('state',$state);
    }


    public function apiCall(){

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.covid19india.org/state_district_wise.json');
        $result = $res->getBody();
        $result = json_decode($result, TRUE);
        return $result;
    }

    public function fetchStateCases()
    {
        $result = $this->apiCall();
        $stateWiseListCount = [];
        foreach($result as $states => $districts) 
        {
            $sumStateWiseConfirmed = $sumStateWiseRecovered = $sumStateWiseDeceased = 0;
            $deltaConfirmed = $deltaRecovered = $deltaDeceased = 0;
            foreach($districts["districtData"] as $district => $values) {
                $sumStateWiseConfirmed = $sumStateWiseConfirmed+$values['confirmed'];
                $deltaConfirmed = $deltaConfirmed+$values['delta']['confirmed'];

                $sumStateWiseRecovered = $sumStateWiseRecovered+$values['recovered'];
                $deltaRecovered = $deltaRecovered+$values['delta']['recovered'];

                $sumStateWiseDeceased = $sumStateWiseDeceased+$values['deceased'];
                $deltaDeceased = $deltaDeceased+$values['delta']['deceased'];
            }
            $confirmedCount = $sumStateWiseConfirmed+$deltaConfirmed;
            $recoveredCount = $sumStateWiseRecovered+$deltaRecovered;
            $deceasedCount = $sumStateWiseDeceased+$deltaDeceased;

            $stateWiseList = array('states' => $states,
                                'confirmedCount'=>$confirmedCount,
                                'recoveredCount'=>$recoveredCount,
                                'deceasedCount'=> $deceasedCount);

            array_push($stateWiseListCount,$stateWiseList);
        }

        $stateWiseList = json_encode($stateWiseListCount);
        // \Log::info("Result*********************",[$stateWiseListCount]);
        return DataTables::of($stateWiseListCount)
                        ->addIndexColumn()
                        ->make(true);

    }

    public function fetchDistrictCases($state)
    {
        $result = $this->apiCall();
        $districtWiseListCount = array();
        foreach($result as $states =>$districts) 
        {
           if($states == $state){
            $sumDistrictWiseConfirmed = $sumDistrictWiseRecovered = $sumDistrictWiseDeceased = 0;
            $deltaConfirmed = $deltaRecovered = $deltaDeceased = 0;
            foreach($districts["districtData"] as $district => $values) {

                $sumDistrictWiseConfirmed = $values['confirmed']+$values['delta']['confirmed'];

                $sumDistrictWiseRecovered = $values['recovered']+$values['delta']['recovered'];

                $sumDistrictWiseDeceased = $values['deceased']+$values['delta']['deceased'];
                
                $districtWiseList = array('district' => $district,
                                'confirmedCount'=>$sumDistrictWiseConfirmed,
                                'recoveredCount'=>$sumDistrictWiseRecovered,
                                'deceasedCount'=> $sumDistrictWiseDeceased);


            array_push($districtWiseListCount,$districtWiseList);
            }
            
           }

        }

        return DataTables::of($districtWiseListCount)
                        ->addIndexColumn()
                        ->make(true);

    }
  
}
