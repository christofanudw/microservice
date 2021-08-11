<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lessons = Lesson::query();
        if(!$lessons){
            return response()->json([
                'status' => 'error',
                'message' => 'Lessons data not available.'
            ], 404);
        }

        $chapterId = $request->query('chapterId');
        $lessons->when($chapterId, function($query) use ($chapterId){
            return $query->where('chapter_id', '=', $chapterId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $lessons->get()
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
            'video' => 'required|url',
            'chapter_id' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        $chapterId = $data['chapter_id'];
        $chapter = Chapter::find($chapterId);
        if(!$chapter){
            return response()->json([
                'status' => 'success',
                'message' => 'Chapter data not available.'
            ], 404);
        }

        $lesson = Lesson::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $lesson
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
        $lesson = Lesson::find($id);
        if(!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => 'Lesson data not available.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $lesson
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
        $lesson = Lesson::find($id);
        if(!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => 'Lesson data not available.'
            ], 404);
        }
        
        $data = $request->all();

        $rules = [
            'name' => 'string',
            'video' => 'url',
            'chapter_id' => 'integer'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        $chapterId = $request->input('chapter_id');
        if($chapterId){
            $chapter = Chapter::find($chapterId);
            if(!$chapter){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Chapter data not available.'
                ], 404);
            }
        }

        $lesson->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $lesson
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
        $lesson = Lesson::find($id);
        if(!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => 'Lesson data not available.'
            ], 404);
        }

        $lesson->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson data successfully deleted.'
        ]);
    }
}
