<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExperienceRequest;
use App\Http\Resources\ExperienceCollection;
use App\Http\Resources\ExperienceResource;
use App\Interfaces\ExperienceInterface;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    protected $experience;

    public function __construct(ExperienceInterface $experience)
    {
        $this->experience = $experience;
    }

    public function index()
    {
        // return request()->all();
        $query = Experience::query()
            ->with('country', 'district')
            ->where('user_id', request()->user_id)
            ->where('user_type', request()->user_type)
            ->orderBy('is_current', 'ASC')
            ->get();

        return new ExperienceCollection($query);
    }

    public function recentPlacement()
    {
        $query = Experience::query()
        ->with(['alumni' => function ($query) {
            $query->with('alumni')->select('id', 'first_name', 'middle_name', 'last_name');
        }])
        ->select('id', 'user_id', 'user_type', 'company_name', 'designation_department', 'start_date', 'end_date', 'is_current')
        ->groupBy('user_id')
        ->where('is_current', 'Yes')
        ->orderBy('updated_at', 'DESC')->take(12)->get();

        return response()->json($query);
    }

    public function create()
    {
        //
    }

    public function store(ExperienceRequest $request)
    {
        // dd($request->all());
        $experience = $this->experience->create($request);
        return new ExperienceResource($experience);
    }

    public function show(Experience $experience)
    {
        //
    }

    public function edit(Experience $experience)
    {
        //
    }

    public function update(ExperienceRequest $request, Experience $experience)
    {
        // dd($request->all());
        $experience = $this->experience->update($experience->id, $request);
        $request['update'] = "update";
        return new ExperienceResource($experience);
    }

    public function destroy(Experience $experience)
    {
        // dd($education->id);
        $experience = $this->experience->delete($experience->id);
        return response()->json($experience);
    }
}
