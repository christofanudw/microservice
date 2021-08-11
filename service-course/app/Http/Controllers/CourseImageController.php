<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseImageController extends Controller
{
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
            'image' => 'required|url',
            'course_id' => 'required|integer'
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

        $courseImage = CourseImage::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $courseImage
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
        $courseImage = CourseImage::find($id);
        if(!$courseImage){
            return response()->json([
                'status' => 'error',
                'message' => 'Image data not available.'
            ], 404);
        }

        $courseImage->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Image data successfully deleted.'
        ]);
    }
}
