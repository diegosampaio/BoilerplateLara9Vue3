<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBooksRequest;
use App\Http\Requests\UpdateBooksRequest;
use App\Models\Books;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Books::query()->paginate(20);

        return Inertia::render('Books', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBooksRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBooksRequest $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required'
        ])->validate();

        Books::create($request->all());

        return redirect()->back()->with('message', 'Book criado com sucesso!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBooksRequest  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBooksRequest $request, Books $books)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', 'Erro na validação')->withInput()->withErrors($validator);
        }
        $books = $books->find($request->id);
        $response = $books->update($request->all());

        if (!$response) {
            return redirect()->route('books')->with('errors', 'Erro na atualização')->withInput()->withErrors(['message' => 'aqui ta o erro']);
        }


        return redirect()->back()
            ->with('message', 'Book atualizado mesmo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, Books $books)
    {
        $books = $books->find($id);
        $response = $books->delete();

        if (!$response) {
            return redirect()->route('books')->with('errors', 'Erro ao deletar Book')->withInput()->withErrors(['message' => 'aqui ta o erro']);
        }


        return redirect()->back()
                    ->with('message', 'Book deletado mesmo!');
    }
}
