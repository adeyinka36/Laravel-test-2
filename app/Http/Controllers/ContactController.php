<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'telephone' => 'required|integer'
            ]);
            Contacts::create($data);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
        return redirect('/');
    }

    public function list(Request $request)
    {
        $request->page = (int) $request->page;
        $pageLowerLimit = ( $request->page - 1 ) * 10 ;
        $pageUpperLimit = ( $request->page ) * 10;


        return response(Contacts::whereBetween('id',[$pageLowerLimit, $pageUpperLimit])->get(), 200);
    }

    public function search(Request $request)
    {
        return response(Contacts::where('first_name','like', "%$request->inputPhrase%")->orWhere('last_name','like', "%$request->inputPhrase%")->get(), 200);
    }

}
