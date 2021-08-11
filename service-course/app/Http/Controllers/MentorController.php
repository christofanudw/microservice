<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentors = Mentor::all();

        if(!$mentors){
            return response()->json([
                'status' => 'error',
                'data' => 'Mentors data not available.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mentors
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email',
        ];
    
        $data = $request->all();
    
        $validator = Validator::make($data, $rules);
    
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
    
        $mentor = Mentor::create($data);
    
        return response()->json([
            'status' => 'success',
            'data' => $mentor,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor data not available.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
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
        $rules = [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor not found.',
            ], 404);
        }

        $mentor->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor data not available.'
            ], 404);
        }

        $mentor->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Mentor data deleted successfully.'
        ]);
    }
}
