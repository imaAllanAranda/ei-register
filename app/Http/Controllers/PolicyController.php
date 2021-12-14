<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use niklasravnsborg\LaravelPdf\Facades\Pdf;


class PolicyController extends Controller
{


	public function index()
	{
		auth()->user()->tokens()->delete();

		auth()->user()->createToken('cir');

		$token = auth()->user()->tokens()->first();

		return redirect()->away(config('services.pap.url') . '?token=' . $token->token . '&type=2');
	}

}
