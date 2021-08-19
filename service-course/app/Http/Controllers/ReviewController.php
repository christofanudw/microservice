<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
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
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'rating' => 'integer|between:1,5',
            'note' => 'string'
        ];

        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()
            ], 400);
        }

        $user = getUser($data['user_id']);
        if($user['status'] === 'error'){
            return response()->json([
                'status' => $user['status'],
                'message' => $user['message']
            ], $user['http_code']);
        }

        $course = Course::find($data['course_id']);
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'Course data not available.'
            ], 404);
        }

        $ifExistsReview = Review::where('user_id', '=', $request->input('user_id'))->where('course_id', '=', $request->input('course_id'))->first();
        if($ifExistsReview){
            return response()->json([
                'status' => 'error',
                'message' => 'User has already left a review for this class.'
            ], 409);
        }

        $review = Review::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $review
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
        $review = Review::find($id);
        if(!$review){
            return response()->json([
            'status' => 'error',
            'message' => 'Review data not available.'
            ], 404);
        }
                
        $data = $request->except('user_id', 'course_id');

        $rules = [
            'rating' => 'integer|between:1,5',
            'note' => 'string'
        ];

        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()
            ], 400);
        }

        $review->update($data);

        return response()->json([
            'status' => 'success',
            'data' => $review
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
        $review = Review::find($id);
        if(!$review){
            return response()->json([
                'status' => 'error',
                'message' => 'Review data not available.'
            ], 404);
        }

        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Review data deleted successfully.'
        ]);
    }
}
