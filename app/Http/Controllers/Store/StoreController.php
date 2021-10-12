<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoresRequest;
use App\Http\Requests\UpdateStoresRequest;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Session;

class StoreController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $edit = true;

        if (!isset($store))
        {
            Session::flash('message', 'insert your store data for first time!');
            Session::flash('alert-type', 'alert-danger');
            $edit = false;
        }

        return view('store.index',compact('store','edit'));
    }

    public function store(StoreStoresRequest $request)
    {
        $request['slug'] = make_slug($request->name);
        $request['user_id'] = Auth::id();

        $store = Store::create($request->all());

        if ($store)
        {
            $message = 'Your store insert success!';
            $type = 'success';
        }else
        {
            $message = 'store insert failed !';
            $type = 'alert-danger';
        }

        Session::flash('message', $message);
        Session::flash('alert-type', $type);

        return back();
    }

    public function update(UpdateStoresRequest $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();

        $store = $store->update([
            'name'  => $request->name,
            'slug'  => make_slug($request->name)
        ]);

        if ($store)
        {
            $message = 'Your store Update success!';
            $type = 'success';
        }else
        {
            $message = 'store update failed !';
            $type = 'alert-danger';
        }

        Session::flash('message', $message);
        Session::flash('alert-type', $type);

        return back();
    }
}
