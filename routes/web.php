<?php

// api
$router->group(['prefix' => 'api'], function() use ($router) {
    
    $router->group(['prefix' => 'book'], function() use ($router){
        $router->get('', 'Book\BookController@showAllBooks');
        $router->post('new', 'Book\BookController@newBook');
        $router->put('edit/{id}', 'Book\BookController@editBook');
        $router->delete('delete/{id}', 'Book\BookController@deleteBook');
    });

});


// view (singlepage)
$router->get('/{route:.*}/', function ()  {
    return view('app');
});
