<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    /**
     * Create Local Cart
     * add Items
     * */
    public function cart(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product)
        {
            $json_data = array(
                'message'     => 'cant get this product',
            );

        }else {
            $session = new Session();

            $oldCart = $session->has('cart')? $session->get('cart') : null;

            $cart = new Cart($oldCart);

            $cart->add($product, $product->id);

            $session->set('cart', $cart);

            $json_data = array(
                'message'     => 'add product to cart success!',
                'cart'     => $cart,
            );
        }

        return response()->json($json_data);
    }

    /**
     * Get Old Cart items
     * */
    public function old_cart(Request $request)
    {
        $session = new Session();
        $cart = $session->get('cart');

        $json_data = array(
            'message'   => 'old Cart!',
            'cart'      => $cart
        );

        return response()->json($json_data);
    }

    /**
     * Reduce item at cart by one
     * if item count zero remove from cart
     * @Newcart() it's Class
     * */
    public function getReduceByOne($id){
        $session = new Session();

        $oldCart = $session->has('cart')? $session->get('cart') : null;

        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if(count($cart->items) > 0){
            $session->set('cart', $cart);
        } else {
            $session->clear('cart');
        }

        $json_data = array(
            'message'   => 'reduce item success!',
            'cart'      => $cart
        );

        return response()->json($json_data);
    }

    /**
     * Increase item at cart by one
     * @Newcart() it's Class
     * */
    public function getIncreaseByOne($id){
        $session = new Session();

        $oldCart = $session->has('cart')? $session->get('cart') : null;

        $cart = new Cart($oldCart);
        $cart->increaseByOne($id);

        if(count($cart->items) > 0){
            $session->set('cart', $cart);
        } else {
            $session->clear('cart');
        }

        $json_data = array(
            'message'   => 'reduce item success!',
            'cart'      => $cart
        );

        return response()->json($json_data);
    }

    /**
     * remove item from cart
     * @Newcart() it's Class
     * */
    public function getRemoveItem($id){
        $session = new Session();

        $oldCart = $session->has('cart')? $session->get('cart') : null;

        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if(count($cart->items) > 0){
            $session->set('cart', $cart);
        } else {
            $session->clear('cart');
        }

        $json_data = array(
            'message'   => 'remove item from cart!',
            'cart'      => $cart
        );

        return response()->json($json_data);
    }
}
