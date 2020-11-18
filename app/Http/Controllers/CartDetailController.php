<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartDetail;
use App\Models\Cart;

   

   

   

class CartDetailController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = CartDetail::has('productos')->get();
              //dd($pedidos);
             return view('admin.pedidos.index',compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cartDetail = new CartDetail();
        $cartDetail->cart_id = auth()->user()->cart->id;
        $cartDetail->product_id = $request->product_id;
        $cartDetail->quantity = $request->quantity;
        $cartDetail->user_id = auth()->user()->id;
        $cartDetail->save();

        $notification = array(
            'message' => '¡El producto se ha cargado a tu carrito de compras exitosamente!',
            'alert-type' => 'success'
        );
        
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        
        $cartDetail = CartDetail::find($id);
        $cartDetail->delete();

        $notification = array(
            'message' => '¡Pedido eliminado!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pedidos()
    {
     $pedidos = CartDetail::has('productos')->has('cart')->paginate(5);
     //dd($pedidos);

      return view('admin.pedidos.mostrar')->with(compact(
            'pedidos'));
        

        
    }
}
