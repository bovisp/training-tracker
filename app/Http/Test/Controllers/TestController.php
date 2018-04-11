<?php

namespace TrainingTracker\Http\Test\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Exceptions\TestException;

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
        // dd(User::where('firstname', 'fuzzybutt')->get()->first());

        $validations = [];

        $results = Excel::load("storage\\app\\public\\" . basename($file), function($reader) {})->get();

        foreach ($results as $result) {
            $result = $result->toArray();

            $messages = [
                'username.unique' => 'The username ":input" is already in use',
                'email.unique' => 'The email ":input" is already in use',
                'test.exists' => 'The topic ":input" does not exist'
            ];

            $validator = Validator::make($result, [
                // 'username' => 'unique:users,username,NULL,id,test,' . $result["test"]
                'username' => 'unique:users,username',
                'email' => 'unique:users,email|email',
                'test' => 'exists:topics,id'
            ], $messages);

            if (count($validator->errors()->toArray())) {
                $validations[] = [
                    "errors" => $validator->errors()->toArray(),
                    "data" => $result
                ];
            } else {
                User::create($result);
            }   
        }

        if (count($validations)) {
            return back()
                ->with('errors', $validations)
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
        //
    }
}
