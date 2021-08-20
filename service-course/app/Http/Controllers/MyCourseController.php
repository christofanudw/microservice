<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        $myCourses = MyCourse::with('course')->get();
        $myCourses->when($userId, function($query) use ($userId){
            return $query->where('user_id', '=', $userId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $myCourses
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
            'course_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $course = Course::find($data['course_id']);
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'Course data not available.'
            ], 404);
        }

        $user = getUser($data['user_id']);
        if($user['status'] === 'error'){
            return response()->json([
                'status' => $user['status'],
                'message' => $user['message']
            ], $user['http_code']);
        }

        $ifExistsMyCourse = MyCourse::where('course_id', '=', $data['course_id'])
                                    ->where('user_id', '=', $data['user_id'])
                                    ->first();
        if($ifExistsMyCourse){
            return response()->json([
                'status' => 'error',
                'message' => 'User has already taken this course.'
            ], 409);
        }

        if($course->type === 'premium'){
            $order = postOrder([
                'user' => $user['data'],
                'course' => $course->toArray()
            ]);

            if($order['status'] === 'error'){
                return response()->json([
                    'status' => $order['status'],
                    'message' => $order['message']
                ], $order['http_code']);
            }

            return response()->json([
                'status' => 'success',
                'data' => $order['data']
            ]);
        } else{
            $myCourse = MyCourse::create($data);

            return response()->json([
                'status' => 'success',
                'data' => $myCourse
            ]);
        }

        
    }

    public function createPremiumAccess(Request $request){
        $data = $request->all();
        $myCourse = MyCourse::create($data);
        
        return response()->json([
            'status' => 'success',
            'data' => $myCourse
        ]);
    }
}
