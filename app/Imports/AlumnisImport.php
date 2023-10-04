<?php

namespace App\Imports;

use App\Models\Alumni;

use DOMDocument;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumnisImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        /*if ($row['photograph']){
            $response = Http::get($row['photograph']); //get drive url
            $html = (string) $response->body();
            $dom = new DOMDocument;
            $dom->loadHTML($html);
            $links = $dom->getElementsByTagName('meta');
            $imageName = $links[3]->getAttribute('content'); //get image name
            $imageURL = $links[6]->getAttribute('content'); //get image url
            $imageID =substr($imageURL, 32, -39); // drive url ID

            $directory = 'uploads/images/alumnis/' . $imageName;
            copy('https://drive.google.com/uc?export=download&id='.$imageID, $directory);
            response()->download(public_path($directory));
        } else{
            $directoryAvatar = 'uploads/images/alumnis/' . 'avatar-1.png';
        }*/


         return new Alumni([
             'convocation_year'       =>  $row['convocation_year'] ? $row['convocation_year'] : '',
             'ewu_id_no'              =>  $row['ewu_id_no'] ? $row['ewu_id_no'] : '',
             'name'                   =>  $row['name'] ? $row['name'] : '',
             'occupation'             =>  $row['occupation'] ? $row['occupation'] : '',
             'designation_department' =>  $row['designation_department'] ? $row['designation_department'] : '',
             'organization'           =>  $row['organization'] ? $row['organization'] : '',
             'photograph'             =>  $row['photograph'] ? $row['photograph'] : '',
             'photo'                  =>  $row['photograph'] ? $row['photograph'] : '',
             'contact_no'             =>  $row['contact_no'] ? $row['contact_no'] : '',
             'program_degree'         =>  $row['program_degree'] ? $row['program_degree'] : '',
             'email'                  =>  $row['email'] ? $row['email'] : '',
             'linkdin_profile_url'    =>  $row['linkdin_profile_url'] ? $row['linkdin_profile_url'] : '',
             'doj'                    =>  $row['doj'] ? $row['doj'] : '',
             'gender'                 =>  $row['gender'] ? $row['gender'] : '',
             'industry'               =>  $row['industry'] ? $row['industry'] : '',
         ]);
    }
}
