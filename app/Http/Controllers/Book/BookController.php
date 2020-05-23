<?php 

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{      
    /**
     * @var Book Model de livros.
     */
    protected $bookModel;

    const INPUT_FLTER = [
        'title', 'loan_amount', 
        'remaining_amount', 'total'
    ];

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }
    
    /**
     * Retorna todos os livros da base de dados.
     * @return string Json Listando os livros.
     */
    public function showAllBooks()
    {
        try {
            $books = $this->bookModel->all();
            $jsonResponse = response()->json(
                $books, 200, self::HEADERS, JSON_UNESCAPED_UNICODE 
            );
            
            return $jsonResponse;
            
        } catch (\Throwable $th) {
            return response()->json(self::SERVER_ERROR_MESSAGE, 500);
        }
        
    }

    public function newBook(Request $request)
    {
        try {
            $newBook = $request->only(self::INPUT_FLTER);
            $newBookQueryResult = $this->bookModel->create($newBook);
           
            // TODO: CRIAR UM VALIDADOR
            if (!$newBookQueryResult) {
                return response()->json(self::CLIENT_ERROR_MESSAGE, 400);  
            }
            
            $feedback = "Livro '{$request->title}' registrado com sucesso.";
            
            return response()->json($feedback, 200);

        } catch(\Throwable $th) {
            return response()->json(self::SERVER_ERROR_MESSAGE, 500);
        }
    }

    public function returnValidBooksToLoan()
    {
        $books = $this->bookModel->where('remaining_amount', '>', 0)->get();
        return response()->json($books, 200);
    }

    public function editBook(Request $request, $id)
    {
        try {
            // TODO: VALIDAÇÃO ID
            $book = $this->bookModel->find($id);
            
            if (is_null($book)) {
                return response()->json("Não existe nenhum livro com o id = {$request->id}", 404);
            }

            $newBookData = $request->only(self::INPUT_FLTER);
            $updateResult = $book->update($newBookData);

            if (!$updateResult) {
                return response()->json(self::CLIENT_ERROR_MESSAGE, 404);
            }

            return response()->json("Livro atualizado com sucesso.", 200);
        
        } catch (\Throwable $th) {
            return response()->json(self::SERVER_ERROR_MESSAGE, 500);
        }
    }

    public function deleteBook(Request $request, $id)
    {
        try {
            // TODO: VALIDAÇÃO ID
            $book = $this->bookModel->find($id);
            if (is_null($book)) {
                return response()->json("Não existe nenhum livro com o id = {$request->id}", 404);
            }

            
            $deleteResult = $book->delete();

            if (!$deleteResult) {
                return response()->json(self::CLIENT_ERROR_MESSAGE, 404);
            }

            return response()->json("Livro deletado com sucesso.", 200);
        
        } catch (\Throwable $th) {
            return response()->json(self::SERVER_ERROR_MESSAGE, 500);
        }
    }

}