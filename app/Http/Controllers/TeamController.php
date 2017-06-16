<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class TeamController extends Controller
{
	public function index(){
		$positions = [
			['lat' => 50.029306,  'lng' => 19.871053],
			['lat' => 50.029201, 'lng' => 19.871563],
			['lat' => 50.029106, 'lng' => 19.872073],
			['lat' => 50.029001, 'lng' => 19.872583],
			['lat' => 50.028906, 'lng' => 19.873093],
			['lat' => 50.028506, 'lng' => 19.873093],
			['lat' => 50.028006, 'lng' => 19.873093],
			['lat' => 50.027006, 'lng' => 19.873093],
		];
		$positions2 = [
			['lat' => 50.027306, 'lng' => 19.871053],
			['lat' => 50.026201, 'lng' => 19.871563],
			['lat' => 50.025106, 'lng' => 19.872073],
			['lat' => 50.024001, 'lng' => 19.872483],
			['lat' => 50.023906, 'lng' => 19.873393],
			['lat' => 50.023506, 'lng' => 19.872093],
			['lat' => 50.023006, 'lng' => 19.872093],
			['lat' => 50.023006, 'lng' => 19.872093],
		];
		$users = [
			['id' => 1, 'name' => 'echo', 'positions' => $positions, 'color' => '#D34747'],
			['id' => 2, 'name' => 'bravo', 'positions' => $positions2, 'color' => '#2B7E7E']
		];
		return $users;
	}
    public function store(Request $request){

    	$this->validate($request, [
	        'email' => 'required',
	        'name' => 'required',
	    ]);

	    Team::create($request->all());
    }
}
