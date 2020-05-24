<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Image::createOrFail($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $images
     * @return \Illuminate\Http\Response
     */
    public function show(Image $images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $images
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $images
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $images
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $images)
    {
        //
    }
}
