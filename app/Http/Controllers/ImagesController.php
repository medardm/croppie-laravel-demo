<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Image $images)
    {
        return view('welcome', ['images' => $images->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Image::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $images
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show(Image $image)
    {
        /*
         * add your policy check here
         * Like only admins and the owner of the image can view
         * That way no one else can access the images */
        return Response::file($image->file);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $images
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Image $image)
    {
        $image->update($request->all());

        return response()->json(
            [
                'message' => 'Image updated',
                'file' => $request->file
            ]
        );
    }
}
