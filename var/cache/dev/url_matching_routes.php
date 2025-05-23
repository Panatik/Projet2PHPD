<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/login_check' => [[['_route' => 'api_login_check'], null, ['POST' => 0], null, false, false, null]],
        '/_wdt/styles' => [[['_route' => '_wdt_stylesheet', '_controller' => 'web_profiler.controller.profiler::toolbarStylesheetAction'], null, null, null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/api/tournaments' => [
            [['_route' => 'get_all_tournament', '_controller' => 'App\\Controller\\TournamentController::index_tournament'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_tournament', '_controller' => 'App\\Controller\\TournamentController::createTournament'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/players' => [[['_route' => 'get_all', '_controller' => 'App\\Controller\\UserController::index'], null, ['GET' => 0], null, false, false, null]],
        '/register' => [[['_route' => 'create', '_controller' => 'App\\Controller\\UserController::add_player'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/(?'
                        .'|font/([^/\\.]++)\\.woff2(*:98)'
                        .'|([^/]++)(?'
                            .'|/(?'
                                .'|search/results(*:134)'
                                .'|router(*:148)'
                                .'|exception(?'
                                    .'|(*:168)'
                                    .'|\\.css(*:181)'
                                .')'
                            .')'
                            .'|(*:191)'
                        .')'
                    .')'
                .')'
                .'|/api/(?'
                    .'|tournaments/([^/]++)(?'
                        .'|/(?'
                            .'|registrations(?'
                                .'|(*:253)'
                                .'|/([^/]++)(*:270)'
                            .')'
                            .'|sport\\-matchs(?'
                                .'|(*:295)'
                                .'|/([^/]++)(?'
                                    .'|(*:315)'
                                .')'
                            .')'
                        .')'
                        .'|(*:326)'
                    .')'
                    .'|players/([^/]++)(?'
                        .'|(*:354)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        98 => [[['_route' => '_profiler_font', '_controller' => 'web_profiler.controller.profiler::fontAction'], ['fontName'], null, null, false, false, null]],
        134 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        148 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        168 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        181 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        191 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        253 => [
            [['_route' => 'get_all_register', '_controller' => 'App\\Controller\\RegistrationController::get_register'], ['id'], ['GET' => 0], null, false, false, null],
            [['_route' => 'create_register', '_controller' => 'App\\Controller\\RegistrationController::add_register'], ['id'], ['POST' => 0], null, false, false, null],
        ],
        270 => [[['_route' => 'delete_register', '_controller' => 'App\\Controller\\RegistrationController::delete_register'], ['idTournament', 'idRegistration'], ['DELETE' => 0], null, false, true, null]],
        295 => [
            [['_route' => 'get_all_match', '_controller' => 'App\\Controller\\SportMatchController::get_matches'], ['id'], ['GET' => 0], null, false, false, null],
            [['_route' => 'create_match', '_controller' => 'App\\Controller\\SportMatchController::create_match'], ['id'], ['POST' => 0], null, false, false, null],
        ],
        315 => [
            [['_route' => 'get_match', '_controller' => 'App\\Controller\\SportMatchController::get_match'], ['idTournament', 'idSportMatchs'], ['GET' => 0], null, false, true, null],
            [['_route' => 'delete_match', '_controller' => 'App\\Controller\\SportMatchController::delete_match'], ['idTournament', 'idSportMatchs'], ['DELETE' => 0], null, false, true, null],
        ],
        326 => [
            [['_route' => 'get_tournament', '_controller' => 'App\\Controller\\TournamentController::get_tournament'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'edit_tournament', '_controller' => 'App\\Controller\\TournamentController::edit_tournament'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_tournament', '_controller' => 'App\\Controller\\TournamentController::delete_tournament'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        354 => [
            [['_route' => 'get', '_controller' => 'App\\Controller\\UserController::get_player'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'edit', '_controller' => 'App\\Controller\\UserController::edit_player'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete', '_controller' => 'App\\Controller\\UserController::delete_player'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
