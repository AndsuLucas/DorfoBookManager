<?php

// api
$router->group(['prefix' => 'api'], function() use ($router) {    
    $router->group(['prefix' => 'book'], function() use ($router){
        $router->get('', 'Book\BookController@showAllBooks');
        $router->get('getBooksToLoan', 'Book\BookController@returnValidBooksToLoan');
        $router->post('new', 'Book\BookController@newBook');
        $router->put('edit/{id}', 'Book\BookController@editBook');
        $router->delete('delete/{id}', 'Book\BookController@deleteBook');
    });

    $router->group(['prefix' => 'loan'], function() use ($router){
        $router->get('', 'Loan\LoanController@getLoans');
        $router->post('newLoan/{bookId}', ['middleware' => 'newLoanMiddleware', 'uses' => 'Loan\LoanController@newLoan']);
        $router->put('checkout/{loanId}', ['middleware' => 'returnLoanMiddleware','uses' =>'Loan\LoanController@loanCheckout']);
        $router->get('filter', 'Loan\LoanController@filterLoan');
    });


    $router->group(['prefrix' => 'auth'], function() use ($router){
        $router->post('/login', 'User\UserController@login');
        $router->post('/register', 'User\UserController@register');
    });
});

// view (singlepage)
$router->get('/{route:.*}/', function ()  {
    return view('app');
});
