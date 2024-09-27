<?php

namespace App\Http\Controllers;

use App\models\Livro;
use App\models\Autores;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function graph(){
        $livros= Autores::with('livros')->orderBy('nome')->get();
        $data= [["autores", "numeros de livros"]];
        $count=1;
        foreach($livros as $item){
            $data[$count] = [$item->nome, count($item->livros)];
            $count++;
        }
        //dd($data);
        $data = json_encode($data);
        return view('home', compact('data'));
    }
}
