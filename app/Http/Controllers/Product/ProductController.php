<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $request['store_id'] = Auth::user()->store->id;
        $request['slug'] = make_slug($request->name);

        $product = Product::create($request->all());

        if ($product)
        {
            $message = 'Your product insert success!';
            $type = 'success';
        }else
        {
            $message = 'product insert failed !';
            $type = 'alert-danger';
        }

        Session::flash('message', $message);
        Session::flash('alert-type', $type);

        return redirect()->route("products");
    }

    public function edit($id)
    {
        $product = Product::find($id);

        return view('products.edit',compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product)
        {
            abort(404);
        }

        $product->destroy($id);

        if ($product)
        {
            $message = 'Your product Delete success!';
            $type = 'success';
        }else
        {
            $message = 'product Delete failed !';
            $type = 'alert-danger';
        }

        Session::flash('message', $message);
        Session::flash('alert-type', $type);

        return redirect()->route("products");
    }

    public function update(UpdateProductRequest $request,$slug)
    {
        $product = Product::where('slug',$slug)->first();

        $product = $product->update([
            'name'      => $request->name,
            'price'     => $request->price,
            'slug'      => make_slug($request->name),
        ]);

        if ($product)
        {
            $message = 'Your product Update success!';
            $type = 'success';
        }else
        {
            $message = 'store product failed !';
            $type = 'alert-danger';
        }

        Session::flash('message', $message);
        Session::flash('alert-type', $type);

        return redirect()->route("products");
    }

    /**
     * get products with Datatable through Ajax Request Script
     * */
    public function get_products(Request $request)
    {
        $columns = array(
            'name'   => 'name',
            'price'  => 'price',
            'slug'   => 'slug',
        );

        $totalData   = Product::where('store_id',Auth::user()->store->id)->count();
        $totalFilter = $totalData;

        if (isset($columns[$request->input('order.0.column')]))
        {
            $order = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');
        }

        if (empty($request->input('search.value')))
        {
            $products = Product::where('store_id',Auth::user()->store->id)->offset($request->input('start'))->limit($request->input('length'));

            if (isset($columns[$request->input('order.0.column')]))
            {
                $products = $products->orderBy($order,$dir);
            } else
            {
                $order = 'id';
                $dir   = 'desc';
                $products = $products->orderBy($order,$dir);
            }

        } else
        {
            $search = $request->input('search.value');

            $products = Product::where('store_id',Auth::user()->store->id)->where('name','like',"%{$search}%")
                ->orwhere('slug','like',"%{$search}%");

            $totalFilter = $products->count();

            $products = $products->offset($request->input('start'))->limit($request->input('length'));

            if (isset($columns[$request->input('order.0.column')]))
            {

                $products = $products->orderBy($order,$dir);
            }

        }

        $products = $products->get();

        $data = array();

        if ($products)
        {
            foreach ($products as $product)
            {
                $nestedData['name']             = $product->name ;
                $nestedData['slug']             = $product->slug ;
                $nestedData['price']           = $product->price;

                $edit = '<a class="btn btn-primary" href="'.route('products.edit',['id' => $product->id]).'">'.__('Edit').'</a>';

                $delete = '<button href="javascript:;" title="Delete" class="btn btn-sm btn-danger btn-modern btn-modern-small pull-left delete" data-id="' . $product->id . '" id="delete-1">
                                '.__('Delete').'
                            </button>';

                $nestedData['action'] = $edit . $delete;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFilter),
            "data"            => $data
        );

        echo json_encode($json_data);
    }
}
