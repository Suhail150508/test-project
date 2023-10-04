<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use App\Models\Club;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Interfaces\ClubInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClubCollection;
use App\Http\Requests\Admin\ClubRequest;

class ClubController extends Controller
{
    protected $club;

    public function __construct(ClubInterface $club)
    {
        $this->club=$club;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Club::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new ClubCollection($query);
        }else{
            $club = Club::query()->with('clubMainLogo')->select('id','title','short_name')->where('status','Active')->get();
            return response()->json($club);
        }
    }

    public function deletedListIndex()
    {
        $club = $this->club->onlyTrashed();

        return response()->json($club);
    }


    public function store(ClubRequest $request)
    {
        /*$club = $this->club->create($request);
        return response()->json(['data' => $club, 'message' => trans('club.created'),], 200);*/

        $data = $request;
        $socialLinks = $request->social_link_inputs;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'club_main_logo',
                    'images' => $data->main_logo,
                    'directory' => 'club',
                    'input_field' => 'main_logo',
                    'width' => '483',
                    'height' => '344',
                ],
                [
                    'type' => 'club_header_logo',
                    'images' => $data->header_logo,
                    'directory' => 'club',
                    'input_field' => 'header_logo',
                    'width' => '315',
                    'height' => '65',
                ],
            ],
            'create_many' => [
                [
                    'relation' => 'linkDetails',
                    'data' => $socialLinks
                ],
            ],
        ];

        $club = $this->club->create($data, $parameters);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\Club';
        $seo->model_id = $club->id;
        $seo->site = 'ccc';
        $seo->page_url = '/clubs/' . $club->short_name;
        $seo->title = $club->title;
        $seo->keywords = 'club';
        $seo->description = Str::limit(strip_tags($club->description), 100);
        $seo->save();

        return response()->json([
            'data' => $club,
            'message' => 'Club Created Successfully',
        ], 200);
    }

    public function viewClub($clubId)
    {
        $club = Club::with(['linkDetails','clubMedias','clubModerators','clubCommittees'])->find($clubId);

        $club['main_logo'] =  $club->clubMainLogo ? $club->clubMainLogo->source : '';
        $club['header_logo'] =  $club->clubHeaderLogo ? $club->clubHeaderLogo->source : '';
        return response()->json($club);
    }

    public function show($shortName)
    {
        $club = Club::with(['linkDetails','clubMedias','clubModerators','clubCommittees'])->where('short_name',$shortName)->first();
        /*$club['deletedListMedias'] = $club->clubMedias()->onlyTrashed()->get();
        $club['deletedListModerators'] = $club->clubModerators()->onlyTrashed()->get();
        $club['deletedListCommittees'] = $club->clubCommittees()->onlyTrashed()->get();*/
        $club['main_logo'] =  $club->clubMainLogo ? $club->clubMainLogo->source : '';
        $club['header_logo'] =  $club->clubHeaderLogo ? $club->clubHeaderLogo->source : '';
        return response()->json($club);
    }

    public function edit($id)
    {
        $club = Club::with(['clubMainLogo','clubHeaderLogo','linkDetails'])->where('id', $id)->first();

        return response()->json($club);
    }

    public function update(ClubRequest $request, Club $club)
    {
        $data = $request;
        $update_parameters = [
            'create_many' => [
                [
                    'relation' => 'linkDetails',
                    'data' => $data->social_link_inputs
                ],
            ],
            'image_info' => [
                [
                    'type' => 'club_main_logo',
                    'images' => $data->main_logo,
                    'directory' => 'club',
                    'input_field' => 'main_logo',
                    'width' => '483',
                    'height' => '344',
                ],
                [
                    'type' => 'club_header_logo',
                    'images' => $data->header_logo,
                    'directory' => 'club',
                    'input_field' => 'header_logo',
                    'width' => '315',
                    'height' => '65',
                ],
            ],

        ];

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\Club', 'model_id' => $club->id],
            [
                'site' => 'ccc',
                'page_url' => '/clubs/' . $data->short_name,
                'title' => $data->title,
                'keywords' => 'club',
                'description' => Str::limit(strip_tags($data->description), 100),
            ]
        );

        $club = $this->club->update($club->id, $data, $update_parameters);
        $request['update'] = 'update';

        return response()->json([
            'data' => $club,
            'message' => trans('club.updated'),
        ], 200);
    }

    public function destroy(Club $club)
    {
        $this->club->delete($club->id);

        return response()->json([
            'message' => trans('club.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->club->restore($id);

        return response()->json([
            'message' => trans('club.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->club->forceDelete($id);

        return response()->json([
            'message' => trans('club.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->club->status($request->id);

        return response()->json([
            'message' => trans('club.status_updated'),
        ], 200);
    }
}
