<?php

namespace App\Http\Middleware;

use Closure;
use App\Book;

class NewLoanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bookId = $request->route('bookId');
        $book = Book::find($bookId);
        
        if (is_null($book)) {
            return response()->json("Este livro não existe.", 400);
        }

        $book->loan_amount += 1;
        $book->remaining_amount = $book->total - $book->loan_amount;
        
        if ($book->remaining_amount < 0) {
            return response()->json("Quantidade de livros insuficiente para empréstimo.", 400);
        }
        
        $request['requested_book'] = $book;
        return $next($request);
    }
}