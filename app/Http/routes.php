<?php

# ------------------ Page Route ------------------------
Route::get('/', 'PagesController@home')->name('home');
Route::get('/about', 'PagesController@about')->name('about');
Route::get('/search', 'PagesController@search')->name('search');
Route::get('/feed', 'PagesController@feed')->name('feed');
Route::get('/sitemap', 'PagesController@sitemap');
Route::get('/sitemap.xml', 'PagesController@sitemap');

# ------------------ User stuff ------------------------

Route::get('/users/{id}/replies', 'UsersController@replies')->name('users.replies');
Route::get('/users/{id}/topics', 'UsersController@topics')->name('users.topics');
Route::get('/users/{id}/favorites', 'UsersController@favorites')->name('users.favorites');
Route::get('/users/{id}/refresh_cache', 'UsersController@refreshCache')->name('users.refresh_cache');
Route::get('/users/{id}/access_tokens', 'UsersController@accessTokens')->name('users.access_tokens');
Route::get('/access_token/{token}/revoke', 'UsersController@revokeAccessToken')->name('users.access_tokens.revoke');
Route::get('/users/regenerate_login_token', 'UsersController@regenerateLoginToken')->name('users.regenerate_login_token');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/favorites/{id}', 'FavoritesController@createOrDelete')->name('favorites.createOrDelete');
    Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
    Route::get('/notifications/count', 'NotificationsController@count')->name('notifications.count');
    Route::post('/attentions/{id}', 'AttentionsController@createOrDelete')->name('attentions.createOrDelete');
});

# ------------------ Authentication ------------------------

Route::get('login', 'Auth\AuthController@login')->name('login');
Route::get('login-required', 'Auth\AuthController@loginRequired')->name('login-required');
Route::get('admin-required', 'Auth\AuthController@adminRequired')->name('admin-required');
Route::get('user-banned', 'Auth\AuthController@userBanned')->name('user-banned');
Route::get('signup', 'Auth\AuthController@create')->name('signup');
Route::post('signup', 'Auth\AuthController@store')->name('signup');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');
Route::get('oauth', 'Auth\AuthController@getOauth');

# ------------------ Categories ------------------------

Route::get('categories/{id}', 'CategoriesController@show')->name('categories.show');

# ------------------ Users ------------------------
Route::get('/users', 'UsersController@index')->name('users.index');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::post('/users', 'UsersController@store')->name('users.store');
Route::get('/users/{id}', 'UsersController@show')->name('users.show');
Route::get('/users/{id}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{id}', 'UsersController@update')->name('users.update');
Route::delete('/users/{id}', 'UsersController@destroy')->name('users.destroy');

# ------------------ Replies ------------------------

Route::post('/replies', 'RepliesController@store')->name('replies.store');
Route::delete('replies/delete/{id}', 'RepliesController@destroy')->name('replies.destroy')->middleware('auth');

# ------------------ Topic ------------------------
Route::get('/topics', 'TopicsController@index')->name('topics.index');
Route::get('/topics/create', 'TopicsController@create')->name('topics.create');
Route::post('/topics', 'TopicsController@store')->name('topics.store');
Route::get('/topics/{id}', 'TopicsController@show')->name('topics.show');
Route::get('/topics/{id}/edit', 'TopicsController@edit')->name('topics.edit');
Route::patch('/topics/{id}', 'TopicsController@update')->name('topics.update');
Route::delete('/topics/{id}', 'TopicsController@destroy')->name('topics.destroy');
Route::post('/topics/{id}/append', 'TopicsController@append')->name('topics.append');

# ------------------ Votes ------------------------

Route::group(['before' => 'auth'], function () {
    Route::post('/topics/{id}/upvote', 'TopicsController@upvote')->name('topics.upvote');
    Route::post('/topics/{id}/downvote', 'TopicsController@downvote')->name('topics.downvote');
    Route::post('/replies/{id}/vote', 'RepliesController@vote')->name('replies.vote');
});

# ------------------ Admin Route ------------------------

Route::group(['before' => 'manage_topics'], function () {
    Route::post('topics/recommend/{id}', 'TopicsController@recommend')->name('topics.recommend');
    Route::post('topics/wiki/{id}', 'TopicsController@wiki')->name('topics.wiki');
    Route::post('topics/pin/{id}', 'TopicsController@pin')->name('topics.pin');
    Route::delete('topics/delete/{id}', 'TopicsController@destroy')->name('topics.destroy');
    Route::post('topics/sink/{id}', 'TopicsController@sink')->name('topics.sink');
});

Route::group(['before' => 'manage_users'], function () {
    Route::post('users/blocking/{id}', 'UsersController@blocking')->name('users.blocking');
});

Route::post('/upload_image', 'TopicsController@uploadImage')->name('upload_image')->middleware('auth');

// Health Checking
Route::get('heartbeat', function () {
    return Category::first();
});

Route::get('/github-api-proxy/users/{username}', 'UsersController@githubApiProxy')->name('users.github-api-proxy');
Route::get('/github-card', 'UsersController@githubCard')->name('users.github-card');

Route::group(['middleware' => ['auth', 'admin_auth']], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
