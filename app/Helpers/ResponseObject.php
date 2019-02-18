<?php

namespace App\Helpers;

use function dd;
use Illuminate\Support\Collection;
use function is_array;

class ResponseObject {

    public $data;

    /**
     * ResponseObject constructor.
     * @param $data
     */
    public function __construct($obj) {

        if (($obj instanceof Collection) || is_array($obj)) {
            $this->data = $obj;
        } else {
            $this->data[] = $obj;
        }
    }


}
