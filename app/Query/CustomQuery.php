<?php

namespace App\Query;

use Illuminate\Database\Query\Builder;

class CustomQuery extends Builder {

    public function whereDue()
    {
        $this->where('due', '=', 1);
        return $this;
    }
}
