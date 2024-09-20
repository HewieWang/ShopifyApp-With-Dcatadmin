<?php

namespace App\Admin\Repositories;

use App\Models\Extension as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Extension extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
