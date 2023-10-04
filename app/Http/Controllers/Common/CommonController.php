<?php

namespace App\Http\Controllers\Common;

use App\Helpers\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Employee;
use App\Models\District;
use App\Models\Thana;
use App\Rules\LocalizedNumber;
use Illuminate\Http\Request;

class CommonController extends Controller
{


    public function GetDistrict()
    {
        $district = District::query()->where('division_id', request('division_id'))->where('status','Active')->get();
        return $district;
    }

    public function GetThana()
    {
        $thana = Thana::query()->where('district_id', request('district_id'))->where('status','Active')->get();
        return $thana;
    }

    public function contact()
    {
        $data['content'] = Content::query()->where('name','contact')->first();

        return view('guest.contact.show')->with($data);
    }

    public function GetDistrictFromDivision()
    {
        return District::query()->where('division_id', request('division_id'))->where('status','Active')->pluck('bn_name','id');
    }


    public function GetEmployee()
    {
        return Employee::query()->findOrFail(request('id'));
    }

    public function GetEmployeeFromPin()
    {
        return Employee::query()
            ->where('old_pin',request('pin'))
            ->orWhere('new_pin',request('pin'))
            ->firstOrFail();
    }

    public function NumberValidation(Request $request)
    {
        $request->validate([
            'input_number' => [new LocalizedNumber],
        ]);

        return true;
    }

    public function GetDistricts(Request $request)
    {
       $districts = District::query()->where('division_id',$request->key)->pluck('bn_name','id');
       $data = HtmlHelper::dropdownOptions($districts);
       return $data['options'];
    }


    public function GetThanas(Request $request)
    {
       $thanas = Thana::query()->where('district_id',$request->key)->pluck('bn_name','id');
       $data = HtmlHelper::dropdownOptions($thanas);
       return $data['options'];
    }

}
