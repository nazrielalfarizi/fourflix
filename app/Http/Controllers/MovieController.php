<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $item = Movie::all();
        return view('single', [
            'item' => $item
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'm_title' => 'required',
            'm_publis' => 'required',
            'm_desc' => 'required',
            'm_tag' => 'required',
            'm_age' => 'required',
            'm_release' => 'required',
            'm_rate' => 'required',
            'm_time' => 'required',
            'filename'=>'required',
            'filename.*'=> 'image|mimes:jpeg,png,jpg|max:2048']);

        $imageName = time().'.'.$request->filename->extension();
        $request->filename->move(public_path().'/image/', $imageName);
        $movie = Movie::create([
            'm_title' => $request['m_title'],
            'm_publis' => $request['m_publis'],
            'm_desc' => $request['m_desc'],
            'm_tag' => $request['m_tag'],
            'm_age' => $request['m_age'],
            'm_release' => $request['m_release'],
            'm_rate' => $request['m_rate'],
            'm_time' => $request['m_time'],
            'filename'=>$request['filename'],
            'filename'=>$imageName]);

        return redirect('/movie')->with('success', 'Movie has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $item = Movie::findorFail($id);
        $items = Movie::all();
        $username = Auth::user()->name;
        return view('single', [
            'title' => 'Movie',
            'username' => $username,
            'item' => $item,
            'items' => $items

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Movie::findorfail($id);
        $username = Auth::user()->name;
        return view('edit', [
            'title' => 'Movie',
            'username' => $username,
            'item' => $item,

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

        $request->validate([
            'm_title' => 'required',
            'm_publis' => 'required',
            'm_desc' => 'required',
            'm_tag' => 'required',
            'm_rate' => 'required',
            'm_time' => 'required',
            'filename'=>'required',
            'filename.*'=> 'image|mimes:jpeg,png,jpg|max:2048']);

        $imageName = time().'.'.$request->filename->extension();
        $request->filename->move(public_path().'/image/', $imageName);

        $movie = Movie::find($id)->update(([
            'm_title' => $request['m_title'],
            'm_publis' => $request['m_publis'],
            'm_desc' => $request['m_desc'],
            'm_tag' => $request['m_tag'],
            'm_rate' => $request['m_rate'],
            'm_time' => $request['m_time'],
            'filename'=>$imageName])
        );

        return redirect('single/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $item = Movie::find($id);
        $item->delete();
        return redirect('dashboard')->with('success', 'Movie has been deleted.');
    }
}
