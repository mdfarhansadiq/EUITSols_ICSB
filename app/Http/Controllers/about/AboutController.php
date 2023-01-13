<?php

namespace App\Http\Controllers\about;

use App\Http\Controllers\Controller;
use App\Models\AboutModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AboutController extends Controller
{
    public function about()
    {
        // return 1;
        $data  = AboutModel::all();
        // dd($data);
        return view('pages.about.index', compact('data'));
        // return View::make('pages.about.index1');
    }

    public function aboutPost(Request $req)
    {
        // dd("hello");
        // $validated = $req->validate(
        //     [
        //         'title' => 'required|unique:abouts,title|max:255',
        //         'description' => 'required|string',
        //     ],
        //     [],
        //     [
        //         "title" => "Title",
        //         "description" => "Description"
        //     ]
        // );

        $data = new AboutModel();
        $data->title = $req->input('title');
        $data->details = $req->input('description');

        $path = '';
        if ($req->hasFile('image')) {


            $file = $req->file('image');
            $filename = $file->getClientOriginalName();
            $folder = 'public/' . $data->title;
            $file->storeAs($folder, $filename);
            $path = $folder . "/" . $filename;
        }
        $data->img = $path;
        // dd($data);

        $data->save();

        return redirect('/about/view');
    }
}