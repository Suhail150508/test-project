<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Seo;
use App\Models\User;
use App\Models\Training;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use App\Models\TrainingApplication;
use App\Http\Controllers\Controller;
use App\Interfaces\TrainingInterface;
use App\Http\Resources\TrainingResource;
use App\Http\Resources\TrainingCollection;
use App\Http\Requests\Admin\TrainingRequest;
use App\Http\Resources\TrainingApplicationCollection;

class TrainingController extends Controller
{
    protected $training;

    public function __construct(TrainingInterface $training)
    {
        $this->training = $training;
    }

    public function index()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        if(request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Training::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->with('training_applications')
                ->orderBy('id', 'asc')
                ->paginate($perPage);
        } else{
            $query = Training::query()->where('status','Active')->where('end_date', ">=", $current_date)->with('training_applications')->paginate(6);
        }
        return new TrainingCollection($query);

        /*$training = $this->training->get();
        return response()->json($training);*/
    }

    public function userTrainingApplication($resume_id) {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $from_date = request()->selectedDate['from_date'];
            $to_date = request()->selectedDate['to_date'];
            $keyword = request()->keyword;

            $query = UserApplication::query()
            ->where('resume_id',$resume_id)
            ->where('application_type',"Training")
            ->with(['user','training'])
            ->when(request()->selectedDate['from_date'] != null && request()->selectedDate['to_date'] != null, function($query) use($from_date,$to_date) {
                $query->whereBetween('applyed_date', [$from_date, $to_date]);
            })
            // ->whereHas('training', function($query) use($keyword)
            // {
            //     $query->where('title', 'LIKE', "%$keyword%");
            // })
            // ->where('withdraw_status',false)
            ->paginate($perPage);
            return new TrainingApplicationCollection($query);
        }
    }

    public function userTrainingApplicationShow($training_application_id) {
        $userTrainingApplicationView = UserApplication::with(['user','training'])->findOrFail($training_application_id);
        return response()->json($userTrainingApplicationView);
    }

    public function trainingApplicationList($training_id) {

        $perPage = request()->per_page;
        $query = UserApplication::query()->with(['user','training'])->where('training_id',$training_id)
        ->orderBy('id', 'desc')
        ->paginate($perPage);
        return new TrainingApplicationCollection($query);
    }

    public function deletedListIndex()
    {
        $training = $this->training->onlyTrashed();
        return response()->json($training);
    }

    public function store(TrainingRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'training_image',
                    'images' => $request->training_image,
                    'directory' => 'training',
                    'input_field' => 'training_image',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $training = $this->training->create($data, $parameters);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\Training';
        $seo->model_id = $training->id;
        $seo->site = 'ccc';
        $seo->page_url = '/single-training/' . $training->slug;
        $seo->title = $training->title;
        $seo->keywords = 'training';
        $seo->description = Str::limit(strip_tags($training->description), 100);
        $seo->save();

        return new TrainingResource($training);
    }

    public function trainingApplicationStore(Request $request) {

        $TrainingApplication = UserApplication::where('training_id', $request->training_id)
        ->where('user_id', $request->user_id)->exists();
        $authUser = User::where('id', $request->user_id)->exists();
        if(!$authUser) {
            $response = ['status' => 'error', 'message' => 'You are not logged in'];
        }
        elseif($TrainingApplication) {
            $response = ['status' => 'error', 'message' => 'You Already Applyed for this Training'];
        }else {
            $TrainingApplication = UserApplication::create($request->all());
            $response = ['status' => 'success', 'message' => 'You Applyed for this Training successfully',200];
        }

        return response()->json($response);
    }

    // public function show(Training $training)
    // {
    //     $training = $this->training->findOrFail($training->id);
    //     $trainingImage = $training->training_image->source;

    //     return response()->json([
    //         'training' => $training,
    //         'training_image' => $trainingImage,
    //     ]);
    // }

    public function show($slug)
    {
        $training = $this->training->where('slug', $slug)->firstOrFail();
        $trainingImage = $training->training_image->source;

        return response()->json([
            'training' => $training,
            'training_image' => $trainingImage,
        ]);
    }

    public function edit($id)
    {
        $training = $this->training->findOrFail($id);
        return response()->json($training);
    }

    public function update(TrainingRequest $request, Training $training)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'training_image',
                    'images' => $request->training_image,
                    'directory' => 'training',
                    'input_field' => 'training_image',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $training = $this->training->update($training->id, $data, $parameters);
        $request['update'] = 'update';

        // Update or create the SEO entry
        Seo::updateOrCreate(
            ['model_name' => 'App\Models\Training', 'model_id' => $training->id],
            [
                'site' => 'ccc',
                'page_url' => '/single-training/' . $training->slug,
                'title' => $training->title,
                'keywords' => 'training',
                'description' => Str::limit(strip_tags($training->description), 100),
            ]
        );

        return new TrainingResource($training);
    }

    public function destroy(Training $training)
    {
        $this->training->delete($training->id);
        return response()->json([
            'message' => trans('training.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->training->restore($id);
        return response()->json([
            'message' => trans('training.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->training->forceDelete($id);
        return response()->json([
            'message' => trans('training.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->training->status($request->id);
        return response()->json([
            'message' => trans('training.status_updated'),
        ], 200);
    }
}
