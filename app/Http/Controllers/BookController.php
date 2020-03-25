<?php

namespace App\Http\Controllers;


use App\Book;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    use ApiResponse;

    /**
     * list of books
     * @return JsonResponse
     */
    public function index()
    {
        $books = Book::all();
        return $this->successResponse($books, 'List of books');
    }

    /**
     *  create new book
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());
        return $this->successResponse($book, 'Book created', 201);
    }

    /**
     *  show book profile
     * @param $book
     * @return JsonResponse
     */
    public function show($book)
    {
        $book = Book::findOrFail($book);
        return $this->successResponse($book, 'Showing book profile');
    }

    /**
     * update book info
     * @param Request $request
     * @param $book
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $book)
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::findOrFail($book);
        $book->fill($request->all());

        if ($book->isClean())
            return $this->errorResponse('At least one value must change', 422);

        $book->save();

        return $this->successResponse($book, 'Updated book profile');
    }

    /**
     * remove book
     * @param $book
     * @return JsonResponse
     */
    public function destroy($book)
    {
        $bookProfile = Book::findOrFail($book);
        $bookProfile->delete();
        return $this->successResponse(['id' => $book], 'Book deleted');
    }
}
