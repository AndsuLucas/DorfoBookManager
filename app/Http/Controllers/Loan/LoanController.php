<?php 

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Book;
use App\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller 
{
    protected $loanModel;
    protected $bookModel;
    
    const INPUT_FILTER = [
        'note', 'recipient', 'returned', 'id_book'
    ];

    const SUCCESS_LOAN = "Empréstimo registrado com sucesso";

    public function __construct(Loan $loanModel, Book $bookModel) 
    {
        $this->loanModel = $loanModel;
        $this->bookModel = $bookModel;
    }

    public function newLoan(Request $request, int $id)
    {   

        $book = $request->requested_book;
        try {
       
            $loanData = $request->only(self::INPUT_FILTER);
            $loanData['id_book'] = $id;
            
            $result = $this->loanModel->create(
                $loanData
            );

            if (!$result) {
                $jsonResponse = response()->json(
                    self::CLIENT_ERROR_MESSAGE, 404, self::HEADERS
                );

                return $jsonResponse;
            }
            
            $book->save();
            $jsonResponse = response()->json(
                self::SUCCESS_LOAN, 200, self::HEADERS
            );

            return $jsonResponse;        
            
        } catch (\Throwable $th) {
            $jsonResponse = response()->json(
                self::SERVER_ERROR_MESSAGE, 500, self::HEADERS
            );

            return $jsonResponse;
        }
    }

    public function getLoans()
    {  
        try {

            $loan = $this->loanModel;
            $loans = $loan->with('book')->get();
                    
            $jsonResponse = response()->json(
                $loans, 200, self::HEADERS, JSON_UNESCAPED_UNICODE 
            );

            return $jsonResponse;

        } catch (\Throwable $th) {
    
            $jsonResponse = response()->json(
                self::SERVER_ERROR_MESSAGE, 500, self::HEADERS
            );
            return $jsonResponse;
        }
    }
}