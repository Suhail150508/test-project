<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Auth;

class AddressController extends Controller
{
    public function index()
    {

    }
    public function store(Request $request)
    {
        $address = Address::create($request->all());
        return response()->json('success');
    }

    public function useraddress($user_id)
    {
       $data = Address::with(['division','district','thana'])->where('user_id',$user_id)->get();
       return response()->json($data);
    }
    
    public function update(Request $request, $id)
    {
        $address = Address::where('id',$id)->update($request->all());
        return response()->json('success');
    }

    public function destroy($id)
    {
        $address = Address::where('id',$id)->delete();
        return response()->json('success');
    }

}
