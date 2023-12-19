<?php 

namespace App\Exports;
  
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\FromArray;

//use Illuminate\Http\Request;
//use App\User;
//use DB;
//use Carbon\Carbon;
  
class leadExport implements FromArray, WithHeadings
{

            use Exportable;

            private $myArray;
            private $myHeadings;

            public function __construct($myArray, $myHeadings){
                $this->myArray = $myArray;
                $this->myHeadings = $myHeadings;
            }

            public function array(): array{
                return $this->myArray;
            }

            public function headings(): array{    
                return $this->myHeadings;
            }

}

?>