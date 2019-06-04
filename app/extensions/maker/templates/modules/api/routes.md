<?php

use app\extensions\http\routing\Router;

return Router::group('{{module}}')->routes([

    Router::get('/', 'main/index'),
    // module routes config should be here ...

]);