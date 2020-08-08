<?php

namespace App\Http\Controllers\Loan;

use App\Http\Controllers\Controller;
use App\Book;
use App\Loan;
use Illuminate\Http\Request;
use App\Filters\Loan\Client\FilterLoanClient;

class LoanController extends Controller
{
    protected $loanModel;
    protected $bookModel;

    const INPUT_FILTER = [
        'note', 'recipient', 'returned', 'id_book'
    ];

    const SUCCESS_LOAN = "Empréstimo registrado com sucesso";

    const SUCCESS_RETURNED = "Empréstimo retornado com sucesso";

    public function __construct(Loan $loanModel, Book $bookModel, FilterLoanClient $filter)
    {
        $this->loanModel = $loanModel;
        $this->bookModel = $bookModel;
        $this->loanFilter = $filter;
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
                    self::CLIENT_ERROR_MESSAGE, 404,$this->getHeaders()
                );

                return $jsonResponse;
            }

            $book->save();
            $jsonResponse = response()->json(
                self::SUCCESS_LOAN, 200,$this->getHeaders()
            );

            return $jsonResponse;

        } catch (\Throwable $th) {
            $jsonResponse = response()->json(
                self::SERVER_ERROR_MESSAGE, 500,$this->getHeaders()
            );

            return $jsonResponse;
        }
    }

    public function getLoans()
    {
        try {

            $loan = $this->loanModel;
            $loans = $loan->orderBy('loan_date', 'desc')->with('book')->get();

            $jsonResponse = response()->json(
                $loans, 200,$this->getHeaders(), JSON_UNESCAPED_UNICODE
            );

            return $jsonResponse;

        } catch (\Throwable $th) {

            $jsonResponse = response()->json(
                self::SERVER_ERROR_MESSAGE, 500,$this->getHeaders()
            );
            return $jsonResponse;
        }
    }

    public function loanCheckout(Request $request)
    {
        try {

            $loan = $request->requested_loan;
            $loan->returned = true;
            $loan->save();
            $loan->book->save();

            $jsonResponse = response()->json(self::SUCCESS_RETURNED, 200,$this->getHeaders());

            return $jsonResponse;

        } catch (\Throwable $th) {

            $jsonResponse = response()->json(
                self::SERVER_ERROR_MESSAGE, 500,$this->getHeaders()
            );
            return $jsonResponse;
        }
    }

    public function filterLoan(Request $request)
    {
        try {

            $result = $this->loanFilter->filter($this->loanModel, $request->all());
            $jsonResponse = response()->json($result, 200,$this->getHeaders());

            return $jsonResponse;

        } catch (\Throwable $th) {

            $jsonResponse = response()->json(
                self::SERVER_ERROR_MESSAGE, 500,$this->getHeaders()
            );

            return $jsonResponse;
        }


    }

}
