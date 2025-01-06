<?php

namespace App\Http\Controllers;

use App\Models\SaveCards;
use Illuminate\Http\Request;

class SaveCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json([
        //     'status'=>'success', 'savedcards'=>SaveCards::where('saved_card_id',1)->get()

        // ]);
        return  SaveCards::get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $savecards= new SaveCards;
        $savecards->saved_card_id=$request->saved_card_id;
        $savecards->card_holder=$request->card_holder;
        $savecards->city=$request->city;
        $savecards->card_name=$request->card_name;
        $savecards->card_no=$request->card_no;
        $savecards->save();
        return response()->json([
            'message'=>'Address Created',
            'status'=>'success',
            'data'=>$savecards
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SaveCards $saveCards)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaveCards $saveCards)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaveCards $saveCards)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaveCards $saveCards)
    {
        $deleteCards=$saveCards->delete();
        if($deleteCards){
            return response()->json([
                'message'=> 'Saved Cards Deleted',
                'status'=> 'success'
            ]);
        }
        return response()->json([
            'message'=> 'Failed',
            'status'=> 'error'
        ]);
    }
}
