<?php

Route::get('/', 'Api\V2\Team\AllTeamsController')
    ->name('api.v2.teams.index');

Route::post('/', 'Api\V2\Team\CreateTeamController')
    ->name('api.v2.teams.store');

Route::get('/{team}', 'Api\V2\Team\ReadTeamController')
    ->name('api.v2.team.read');

Route::patch('/{team}', 'Api\V2\Team\UpdateTeamController')
    ->name('api.v2.tea.patch');

Route::delete('/{team}', 'Api\V2\Team\DeleteTeamController')
    ->name('api.v2.team.delete');
