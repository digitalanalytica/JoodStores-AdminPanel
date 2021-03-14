<?php

namespace App\Http\Controllers;

use App\DataTables\DeliveryTimeSlotDataTable;
use App\DeliveryTimeSlot;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;

class DeliveryTimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DeliveryTimeSlotDataTable $deliverydataTable)
    {
        //
        return $deliverydataTable->render('delivery_time_slots.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('delivery_time_slots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $package_object = new DeliveryTimeSlot();
        try {
            $request->validate([
                'timeslot' => 'required|max:30',
                'status' => 'required|in:0,1'
            ]);
            $package_object->timeslot =$request->timeslot;
            $package_object->status = $request->status;
            $package_object->save();
            return redirect(route('deliverytimeslot.index'));
        }catch (ValidatorException $e ){
            Flash::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeliveryTimeSlot  $deliveryTimeSlot
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryTimeSlot $deliveryTimeSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeliveryTimeSlot  $deliveryTimeSlot
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryTimeSlot $deliveryTimeSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryTimeSlot  $deliveryTimeSlot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryTimeSlot $deliveryTimeSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeliveryTimeSlot  $deliveryTimeSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryTimeSlot $deliveryTimeSlot)
    {
        //
    }
}
