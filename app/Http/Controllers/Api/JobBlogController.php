<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobBlog;
use App\Http\Resources\JobBlogCollection;
use App\Interfaces\JobBlogInterface;

class JobBlogController extends Controller
{

    protected $job_blog;

    public function __construct(JobBlogInterface $job_blog)
    {
        $this->job_blog = $job_blog;
    }
  
    public function index()
    {
        if (!empty(request()->all())) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = JobBlog::query()
                ->with('job_blog')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new JobBlogCollection($query);
        } else {
            // If 0
            $query = $this->job_blog->get();

            return new JobBlogCollection($query);
        }
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $title = $request->title;
        $description = $request->description;
        return $description;

        $job_blog = $this->job_blog->create($request);
        return response()->json($job_blog);
    }

 
    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        //
    }

 
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}
