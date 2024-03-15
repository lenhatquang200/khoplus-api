<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\DistrictModel;
use App\Models\Province;
use App\Models\ProvinceModel;
use App\Models\Ward;
use App\Models\WardModel;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getProvince(Request $request)
    {
        $data = Province::orderBy('name', 'asc');
        if ($request->name) {
            $data = $data->where('name', 'like', "%$request->name%");
        }
        $data = $data->get();
        return $this->success($data, 'Load thành công');
    }

    public function getDistrict(Request $request)
    {

        $district = District::where('provinceid', $request->provinceid)->orderBy('name', 'asc');
        if ($request->name) {
            $district = $district->where('name', 'like', "%$request->name%");
        }
        $district = $district
                ->get([
                        'districtid',
                        'name'
                ]);

        return $this->success($district, 'Load thành công');;
    }

    public function getWard(Request $request)
    {
        $ward = Ward::where('districtid', $request->districtid)->orderBy('name', 'asc');
        if ($request->name) {
            $ward = $ward->where('name', 'like', "%$request->name%");
        }
        $ward = $ward
                ->get();
        return $this->success($ward, 'Load thành công');
    }
}
