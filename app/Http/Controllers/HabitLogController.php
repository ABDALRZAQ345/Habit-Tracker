<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Exceptions\ServerErrorException;
use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HabitLogController extends Controller
{
    /**
     * @throws ServerErrorException
     */
    public function update(Request $request, Habit $habit,HabitLog $habitLog): JsonResponse
    {

        $validated=$request->validate([
            'status' => ['required','boolean']
        ]);

        try {
           $user = \Auth::user();
           $habit=$user->habits()->findOrFail($habit->id);
           $habitLog=$habit->habit_logs()->findOrFail($habitLog->id);
           if($habitLog->status===null || ($habitLog->date > now($user->timezone)->format('Y-m-d')) ){
               $message =($habitLog->date > now($user->timezone)->format('Y-m-d')) ? "future day" : "day off";
               throw  new BadRequestException("you cant edit habit log for this day its " . $message);
           }
            $habitLog->update([
                'status'=>$validated['status']
            ]);
           return response()->json([
               'status'=> true,
               'message'=>'log updated successfully'
           ]);
        }
        catch (\Exception $e) {
            throw new ServerErrorException($e->getMessage());
        }



    }
}
