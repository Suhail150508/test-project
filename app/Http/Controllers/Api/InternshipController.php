<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Seo;
use App\Models\User;
use App\Models\Internship;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use App\Http\Controllers\Controller;
use App\Interfaces\InternshipInterface;
use App\Http\Resources\internshipResource;
use App\Http\Resources\InternshipCollection;
use App\Http\Requests\Admin\InternshipRequest;

class InternshipController extends Controller
{
    protected $internship;

    public function __construct(InternshipInterface $internship) {
        $this->internship = $internship;
    }
    public function index()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        if(request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $query =  $this->internship->query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate(6);
                // return response()->json($query);
            return new InternshipCollection($query);
        } else {
            $query =  $this->internship->query()->where('end_date', ">=", $current_date)->orderBy('id', 'asc')->paginate(6);
            return response()->json($query);
            // return new InternshipCollection($query);
        }
    }


    public function userInternshipApplication($auth_id) {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $from_date = request()->selectedDate['from_date'];
            $to_date = request()->selectedDate['to_date'];
            $keyword = request()->keyword;

            $query = UserApplication::query()
            ->where('user_id',$auth_id)
            ->where('application_type',"Internship")
            ->with(['user','internship'])
            ->when(request()->selectedDate['from_date'] != null && request()->selectedDate['to_date'] != null, function($query) use($from_date,$to_date) {
                $query->whereBetween('applyed_date', [$from_date, $to_date]);
            })
            // ->whereHas('training', function($query) use($keyword)
            // {
            //     $query->where('title', 'LIKE', "%$keyword%");
            // })
            // ->where('withdraw_status',false)
            ->paginate($perPage);
            return new InternshipCollection($query);
        }
    }

    // public function show($id)
    // {
    //     $internship = $this->internship->findOrFail($id);
    //     return response()->json($internship);
    // }

    public function show($slug)
    {
        $internship = $this->internship->where('slug', $slug)->firstOrFail();
        return response()->json($internship);
    }

    public function store(InternshipRequest $request)
    {
        $data = $request;

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $internship = $this->internship->create($data);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\Internship';
        $seo->model_id = $internship->id;
        $seo->site = 'ccc';
        $seo->page_url = '/internships/' . $internship->slug;
        $seo->title = $internship->title;
        $seo->keywords = 'internship';
        $seo->description = Str::limit(strip_tags($internship->description), 100);
        $seo->save();

        return response()->json($internship);
    }

    public function InternshipApplicationStore(Request $request) {
        $TrainingApplication = UserApplication::where('internship_id', $request->internship_id
        )->where('user_id', $request->user_id)->exists();

        $authUser = User::where('id', $request->user_id)->exists();
        if(!$authUser) {
            $response = ['status' => 'error', 'message' => 'You are not logged in'];
        }
        elseif($TrainingApplication) {
            $response = ['status' => 'error', 'message' => 'You Already Applyed for this Internship'];
        }else {
            $request['applyed_date'] = Carbon::now()->format('Y-m-d');
            $TrainingApplication = UserApplication::create($request->all());
            $response = ['status' => 'success', 'message' => 'You Applyed for this Internship successfully',200];
        }
        return response()->json($response);
    }

    public function edit($id)
    {
        $internship = $this->internship->findOrFail($id);
        return response()->json($internship);
    }

    public function update(InternshipRequest $request, Internship $internship)
    {
        $data = $request;

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $internship = $this->internship->update($internship->id, $data);
        $request['update'] = "update";

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\Internship', 'model_id' => $internship->id],
            [
                'site' => 'ccc',
                'page_url' => '/internships/' . $internship->slug,
                'title' => $internship->title,
                'keywords' => 'internship',
                'description' => Str::limit(strip_tags($internship->description), 100),
            ]
        );

        return response()->json($internship);
    }

    public function destroy(internship $internship)
    {
        $internship = $this->internship->delete($internship->id);
        return response()->json([
            'message' => trans('internship.deleted'),
        ], 200);
    }

    public function userInternShipApplicationShow($internship_application_id) {
        $userTrainingApplicationView = UserApplication::with(['user','internship'])->findOrFail($internship_application_id);
        return response()->json($userTrainingApplicationView);
    }

}
