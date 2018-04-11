<?php

namespace TrainingTracker\Http\Test\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\Requests\StoreUsersSpreadsheet;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store()
    {
        request()->validate([
            'myfile' => 'required|file|mimes:xlsx,xls,csv,txt'
        ]);

        $file = request()->file('myfile')->store('public');

        $validations = new StoreUsersSpreadsheet(
            "storage\\app\\public\\" . basename($file)
        );

        if (count($validations->validate())) {
            return back()
                ->with('error', $validations)
                ->with('headers', [
                    'Test', 'Username', 'Password', 'First name', 'Last name', 'Email'
                ]);
        }

        return back();
        
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
    public function update($id)
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
        //
    }
}
