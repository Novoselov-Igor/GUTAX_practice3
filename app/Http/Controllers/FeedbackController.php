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
            setcookie('idCity', $request->input('id'), time() + 7200);
            $feedbacks = Feedback::where('id_city', session('idCity'))->get();
            return response()->json(['feedbacks' => $feedbacks,
                'city' => $feedbacks[0]->city->name,
                'author' => $this->getAuthors($feedbacks)]);
        } catch (\Throwable $exception) {
            return response()->json(['feedbacks' => $exception->getMessage()]);
        }
    }

    protected function getAuthors($feedbacks)
    {
        $authors = [];
        foreach ($feedbacks as $feedback) {
            array_push($authors, $feedback->author);
        }
        return $authors;
    }

    public function sendFeedback(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'text' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'id_author' => ['required'],
            'image' => ['required']
        ]);

        $image = $request->file('image');
        $imageName = $validatedData['id_author'] . '_' . $validatedData['name'] . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/feedback_images', $imageName);

        $validatedData['image'] = $imageName;

        if ($request->input('cities') === null) {
            $this->addFeedbackToAll($validatedData);
        } else {
            $this->addFeedbackToSome($validatedData, $request->input('cities'));
        }

        return redirect('/');
    }

    protected function addFeedbackToAll($data)
    {
        $cities = City::all();
        foreach ($cities as $city) {
            Feedback::create([
                'id_city' => $city->id,
                'title' => $data['name'],
                'text' => $data['text'],
                'rating' => $data['rating'],
                'img' => $data['image'],
                'id_author' => $data['id_author']
            ]);
        }
    }

    protected function addFeedbackToSome($data, $cities)
    {
        foreach ($cities as $city) {
            Feedback::create([
                'id_city' => $city,
                'title' => $data['name'],
                'text' => $data['text'],
                'rating' => $data['rating'],
                'img' => $data['image'],
                'id_author' => $data['id_author']
            ]);
        }
    }
}
