<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courseId = $request->query('courseId');

        $chapters = Chapter::query();
        if(!$chapters){
            return response()->json([
                'status' => 'error',
                'message' => 'Chapters data not available.'
            ], 404);
        }

        $chapters->when($courseId, function($query) use ($courseId){
            return $query->where('course_id', '=', $courseId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $chapters->get()
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
        $data = $request->all();

        $rules = [
            'name' => 'required|string',
            'course_id' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $courseId = $data['course_id'];

        $course = Course::find($courseId);

        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'Course data not available.'
            ], 404);
        }

        $chapter = Chapter::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $chapter
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
        $chapter = Chapter::find($id);
        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'Chapter data not available.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $chapter
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
        $chapter = Chapter::find($id);
        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'Chapter data not available.'
            ], 404);
        }

        $data = $request->all();

        $rules = [
            'name' => 'string',
            'course_id' => 'integer',
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $courseId = $request->input('course_id');
        if($courseId){
            $course = Course::find($courseId);
            if(!$course){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Course data not available.'
                ], 404);
            }
        }

        $chapter->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $chapter
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
        $chapter = Chapter::find($id);
        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'Chapter data not available.'
            ], 404);
        }
        
        $chapter->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Chapter data deleted successfully.'
        ]);
    }
}
