<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::query();

        $q = $request->query('q');
        $status = $request->query('status');

        $courses->when($q, function($query) use ($q){
            return $query->where('name', 'like', '%'.strtolower($q).'%'); 
        });
        
        $courses->when($status, function($query) use ($status){
            return $query->where('status', '=', $status);
        });

        if(!$courses){
            return response()->json([
                'status' => 'error',
                'message' => 'Courses data not available.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $courses->paginate(10)
        ]);
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
        $data = $request->all();

        $rules = [
            'name' => 'required|string',
            'certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => ['required', Rule::in(['free', 'premium'])],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'price' => 'integer',
            'level' => ['required', Rule::in(['all-levels', 'beginner', 'intermediate', 'advanced'])],
            'mentor_id' => 'required|integer',
            'description' => 'string'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $mentorId = $request->input('mentor_id');
        $mentor = Mentor::find($mentorId);
        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor data not available.'
            ], 404);
        }

        $course = Course::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $course
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
        $course = Course::find($id);

        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'Course data not available.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $course
        ]);
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
        $data = $request->all();

        $rules = [
            'name' => 'string',
            'certificate' => 'boolean',
            'thumbnail' => 'string|url',
            'type' => Rule::in(['free', 'premium']),
            'status' => Rule::in(['draft', 'published']),
            'price' => 'integer',
            'level' => Rule::in(['all-levels', 'beginner', 'intermediate', 'advanced']),
            'mentor_id' => 'integer',
            'description' => 'string'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $course = Course::find($id);
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'Course data not available.'
            ], 404);
        }

        $mentorId = $request->input('mentor_id');
        if($mentorId){
            $mentor = Mentor::find($mentorId);
            if(!$mentor){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mentor data not available.'
                ], 404);
            }
        }

        $course->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $course
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
        $course = Course::find($id);

        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'Course data not available.'
            ], 404);
        }

        $course->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Course deleted successfully.'
        ]);
    }
}
