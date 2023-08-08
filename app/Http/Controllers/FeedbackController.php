<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function gotoCreate()
    {
        return view('feedbackCreate', ['cities' => City::all()]);
    }

    public function getCityFeedbacks(Request $request)
    {
        try {
            session(['idCity' => $request->input('id')]);
            $feedbacks = Feedback::where('id_city', session('idCity'))->get();
            return response()->json(['feedbacks' => $feedbacks,
                'city' => $feedbacks[0]->city->name,
                'author' => $this->getAuthors($feedbacks)]);
        } catch (\Throwable $exception) {
            return response()->json(['feedbacks' => $exception->getMessage()]);
        }
    }

    public function sendFeedback(Request $request)
    {
        dd($request->all(), geoip($request->ip()));
    }

    protected function getAuthors($feedbacks)
    {
        $authors = [];
        foreach ($feedbacks as $feedback) {
            array_push($authors, $feedback->author);
        }
        return $authors;
    }
}
