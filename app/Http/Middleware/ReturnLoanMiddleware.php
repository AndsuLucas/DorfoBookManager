<?php

namespace App\Http\Middleware;

use Closure;
use App\Loan;


class ReturnLoanMiddleware
{
    /**
     * Handle an incoming requestnew.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $loanId = $request->route('loanId');
        $loan = Loan::with('book')->find($loanId);
        
        
        if (is_null($loan)) {
            return response()->json("Esté empréstimo não existe.", 404);
        }
        
        if ($loan->returned) {
            return response()->json("Este empréstimo já foi retornado", 404);
        }

        $acutalLoanAmount = $loan->book->loan_amount;
        $loan->book->loan_amount = $acutalLoanAmount - 1;
        $total = $loan->book->total;
        $loan->book->remaining_amount = $total - $loan->book->loan_amount;

        $request['requested_loan'] = $loan;
        return $next($request);
    }
}