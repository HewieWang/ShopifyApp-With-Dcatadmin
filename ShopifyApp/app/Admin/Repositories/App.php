<?php

namespace App\Admin\Repositories;

use App\Models\App as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class App extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
