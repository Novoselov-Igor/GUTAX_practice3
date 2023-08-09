<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{
    public function gotoCreate()
    {
        return view('feedbackCreate', ['cities' => City::all()]);
    }

    public function gotoChange(Request $request)
    {
        return view('feedbackChange', ['oldFeedback' => $request->all(), 'cities' => City::all()]);
    }

    public function gotoUserFeedbacks(Request $request)
    {
        return view('usersFeedbacks', ['feedbacks' => Feedback::where('id_author', $request->input('id'))->get()]);
    }

    public function getCityFeedbacks(Request $request)
    {
        try {
            Session::put('idCity', $request->input('id'));
            $feedbacks = Feedback::where('id_city', $request->input('id'))->get();
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

        if ($request->input('case') === 'change') {
            $this->updateFeedback($request->input('id'), $validatedData, $request->input('cityId'));
        } elseif ($request->input('case') === 'create') {
            if ($request->input('cities') === null) {
                $this->addFeedbackToAll($validatedData);
            } else {
                $this->addFeedbackToSome($validatedData, $request->input('cities'));
            }
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

    public function getSession()
    {
        return response()->json(['session' => Session::get('idCity')]);
    }

    protected function updateFeedback($id, $data, $cityId)
    {
        Feedback::find($id)->update([
            'id_city' => $cityId,
            'title' => $data['name'],
            'text' => $data['text'],
            'rating' => $data['rating'],
            'img' => $data['image'],
            'id_author' => $data['id_author']
        ]);
    }
}
