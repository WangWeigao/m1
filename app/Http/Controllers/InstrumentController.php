<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Instrument;
use App\Http\Requests\StoreInstrumentPostRequest;
use App\Http\Requests\UpdateInstrumentPutRequest;

class InstrumentController extends Controller
{
    /**
     * use auth middleware
     * @method __construct
     */
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
        $instruments = Instrument::all();
        return view('instrument.index')->with('instruments', $instruments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('instrument.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstrumentPostRequest $request)
    {
      $instrument = new Instrument;
      $instrument->name = $request->input('name');
      $instrument->save();
      return redirect('/instrument');
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
        $instrument = Instrument::find($id);
        $name = $instrument->name;
        return view('instrument.edit')->with(['name' => $name, 'id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstrumentPutRequest $request, $id)
    {
        $instrument = Instrument::find($id);
        $instrument->name = $request->name;
        return redirect('/instrument');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
