<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function sections(){
        return [
            'sec_ccc_home_sliders' => 'Sliders (CCC Home)',
            'sec_ccc_home_whoWeAre' => 'WhoWeAre (CCC Home)',
            'sec_ccc_home_news' => 'News (CCC Home)',
            'sec_ccc_home_notice_events' => 'Notice-Events (CCC Home)',
            'sec_ccc_home_recent_placements' => 'Recent Placements (CCC Home)',
            'sec_ccc_home_career_tips_tricks' => 'Career Tips & Tricks (CCC Home)',
            'sec_ccc_home_resources' => 'Resources (CCC Home)',
            'sec_ccc_home_company_partners' => 'Company Partners (CCC Home)',

            'sec_alumni_home_slider' => 'Sliders (Alumni Home)',
            'sec_alumni_home_welcome' => 'Welcome (Alumni Home)',
            'sec_alumni_home_feature_alumni' => 'Feature Alumni (Alumni Home)',
            'sec_alumni_home_news_room' => 'News Room (Alumni Home)',
            'sec_alumni_home_latest_member' => 'Latest Member (Alumni Home)',
            'sec_alumni_home_notice_events' => 'Notice Event (Alumni Home)',


        ];
    }
}
