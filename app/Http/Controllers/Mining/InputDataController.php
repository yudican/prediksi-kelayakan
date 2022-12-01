<?php

namespace App\Http\Controllers\Mining;

use Algorithm\C45\DataInput;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InputDataController extends DataInput
{
    public function __construct($data = [])
    {
        $this->parseFileData($data);
        $this->populateClasses();
    }

    /**
     * Parse file
     * 
     * @param  mixed  $Spreadsheet 	instance of \PhpOffice\PhpSpreadsheet\Spreadsheet or null
     * @param  integer $sheet      	set current sheet
     * @return array
     */
    public function parseFileData($data = [])
    {
        $result = array();

        if ($data) {
            if (empty($this->attributes)) {
                $this->attributes = $data[0];
                array_shift($data);
            }

            foreach ($data as $value) {
                $temp = array();

                for ($i = 0; $i < count($this->attributes); $i++) {
                    $value[$i] = (is_bool($value[$i])) ? ($value[$i]) ? 'True' : 'False' : $value[$i];
                    $attribute_name = $this->attributes[$i];

                    $temp[$attribute_name] = trim($value[$i]);
                }

                $result[] = $temp;
            }
        }

        $this->data = $result;

        return $result;
    }
}
