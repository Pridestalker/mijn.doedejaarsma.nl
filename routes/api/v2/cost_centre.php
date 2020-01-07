<?php

Route::get('/', 'Api\V2\CostCentre\AllCostCentresController')
    ->name('api.v2.cost_centres.index');

Route::post('/', 'Api\V2\CostCentre\CreateCostCentreController')
    ->name('api.v2.cost_centres.store');

Route::get('/{cost_centre}', 'Api\V2\CostCentre\ReadCostCentreController')
    ->name('api.v2.cost_centre.read');

Route::patch('/{cost_centre}', 'Api\V2\CostCentre\UpdateCostCentreController')
    ->name('api.v2.cost_centre.read');

Route::delete('/{cost_centre}', 'Api\V2\CostCentre\DeleteCostCentreController')
    ->name('api.v2.cost_centre.delete');
