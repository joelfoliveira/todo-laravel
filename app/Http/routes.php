<?php


Route::get('/', ['uses' => 'TodoController@showIndex']);
Route::get('/todo', ['uses' => 'TodoController@getTodoList']);
Route::post('/todo', ['uses' => 'TodoController@createTodo']);
Route::post('/todo/order', ['uses' => 'TodoController@orderTodoList']);
Route::post('/todo/{id}', ['uses' => 'TodoController@updateTodo']);
Route::delete('/todo/{id}', ['uses' => 'TodoController@deleteTodo']);