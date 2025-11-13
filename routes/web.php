<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    abort(
        403,
        'Forbidden.  If you have been navigated here from a browser, someone has made a mistake. :('
    );
});
