<?php

namespace Helious\SeatAssets\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetsController extends Controller
{
    /**
     * Show the eligibility checker.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('seat-assets::index');
    }


}
