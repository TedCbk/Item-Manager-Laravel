<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Grab all the items, than transformed it into a json object that we can use on insomnia or postman
        $items = Item::all();
        return response()->json($items);
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
      $validator = Validator::make($request->all(), [
          'text' => 'required',
      ]); 
      
      if($validator->fails()){
          $response = array('response' => $validator->messages(), 'success' => false);
          return $response;
      } else {
        //   Create Item
        $item = new Item;
        $item->text = $request->input('text');
        $item->body = $request->input('body');
        $item->save();

        return response()->json($item);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get a single Item and returning a json object
        $item = Item::find($id);
        return response()->json($item);
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
        // We can't send a PUT request via Insomnia, but we can add on a POST request a field _method -> PUT
        $validator = Validator::make($request->all(), [
            'text' => 'required',
        ]); 
        
        if($validator->fails()){
            $response = array('response' => $validator->messages(), 'success' => false);
            return $response;
        } else {
          //   Find Item
          $item = Item::find($id);
          $item->text = $request->input('text');
          $item->body = $request->input('body');
          $item->save();
  
          return response()->json($item);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // We can't send a DELETE request via Insomnia, but we can add on a POST request a field _method -> DELETE
        //   Find Item
        $item = Item::find($id);
        $item->delete();

        $response = array('response' => 'Item Deleted', 'success' => true);
            return $response;  
    }
}
