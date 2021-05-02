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
        return $deliverydataTable->render('dts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dts.create');
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
        $dts = new DeliveryTimeSlot();
        try {
            $request->validate([
                'timeslot' => 'required|max:30',
                'status' => 'required|in:0,1'
            ]);
            $dts->timeslot =$request->timeslot;
            $dts->status = $request->status;
            $dts->save();
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        //
        $dts = DeliveryTimeSlot::findOrfail($id);
        if (empty($dts)) {
            Flash::error('Delivery Time Slot not found');

            return redirect(route('deliverytimeslot.index'));
        }
        return view('dts.edit')->with('dts', $dts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryTimeSlot  $deliveryTimeSlot
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $dts = DeliveryTimeSlot::findOrFail($id);
        try {
            $request->validate([
                'timeslot' => 'required|max:30',
                'status' => 'required|in:0,1'
            ]);
            $dts->timeslot =$request->timeslot;
            $dts->status = $request->status;
            $dts->save();
            return redirect(route('deliverytimeslot.index'));
        }catch (ValidatorException $e ){
            Flash::error($e->getMessage());
        }
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
