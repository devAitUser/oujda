<?php

namespace App\Http\Controllers;
use App\Models\Pret;
use Illuminate\Support\Facades\Auth;
use App\Models\Organigramme;
use PDF;
use Carbon\Carbon;

use Illuminate\Http\Request;

class PretsController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        $organigramme =array();

        if($user->projet != null){

            for($i=0;$i<count($user->projet);$i++){

                $organigramme[]=Organigramme::find($user->projet[$i]['organigrammes_id']);
    
               
            }

        }


        $data = array(
            'user' => $user,
            'projets' => $organigramme,

        );


        
        return view('prets.create',$data );
    }


    public function show($id)
    {
        $prets= Pret::find($id);

      

        $createdAt = Carbon::parse($prets['created_at']);

        $date = $createdAt->format("d/m/Y ");

        $data = array(
            'prets' => $prets,
            'date' => $date,
        );

        $pdf = PDF::loadView('prets.show',$data);
        return $pdf->stream();
        return view('prets.show',$data );
        
    }

    public function index()
    {
        return view('prets.index');
        
    }

    public function api_pret()
    {
        $prets= Pret::all();

        return Response()->json($prets);
    }

    public function store(Request $request)
    {
         $user = Auth::user();

         $user = $user->identifiant;

         $new_Pret = new Pret();

         $new_Pret->division = $request->division ;
         $new_Pret->user = $user ;
         $new_Pret->telephone = $request->telephone ;
         $new_Pret->email = $request->email ;
         $new_Pret->save();

         return  redirect()->route('prets');
    }

    public function delete($id)
    {
        $prets= Pret::find($id);
        $prets->delete();

        return  Response()
        ->json(['etat' => true    ]);
        
    }
}
