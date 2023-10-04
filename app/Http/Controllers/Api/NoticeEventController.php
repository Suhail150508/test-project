<?php

namespace App\Http\Controllers\Api;

use App\Models\Seo;
use App\Models\NoticeEvent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\NoticeEventInterface;
use App\Http\Resources\NoticeEventCollection;
use App\Http\Requests\Admin\NoticeEventRequest;
use App\Models\JobPost;

class NoticeEventController extends Controller
{
    protected $noticeevent;

    public function __construct(NoticeEventInterface $noticeevent){
        $this->noticeevent = $noticeevent;
    }
    public function index()
    {
        $data = NoticeEvent::query()->where('status','Active')->select(['id','title', 'slug','description','time','date','status'])->paginate(6);
        return response()->json($data);
    }

    public function paginatedlist()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = NoticeEvent::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new NoticeEventCollection($query);
    }

    public function singlepage()
    {
        $data = NoticeEvent::first();
        return response()->json($data);
    }


    public function create()
    {
        //
    }


    public function store(NoticeEventRequest $request)
    {
        $data = $request;

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $noticeevent = $this->noticeevent->create($data);

        // Data insert in seo table
        $seo = new Seo();
        $seo->model_name = 'App\Models\NoticeEvent';
        $seo->model_id = $noticeevent->id;
        $seo->site = 'ccc';
        $seo->page_url = '/notice-event/' . $noticeevent->slug;
        $seo->title = $noticeevent->title;
        $seo->keywords = 'ccc, notice event';
        $seo->description = Str::limit(strip_tags($noticeevent->description), 100);
        $seo->save();

        $seo = new Seo();
        $seo->model_name = 'App\Models\NoticeEvent';
        $seo->model_id = $noticeevent->id;
        $seo->site = 'alumni';
        $seo->page_url = '/notice-event/' . $noticeevent->slug;
        $seo->title = $noticeevent->title;
        $seo->keywords = 'alumni, notice event';
        $seo->description = Str::limit(strip_tags($noticeevent->description), 100);
        $seo->save();

        return response()->json($noticeevent);
    }

    // public function show($id)
    // {
    //     $noticeEvent = NoticeEvent::query()->findOrFail($id);

    //     return response()->json($noticeEvent);
    // }

    public function show($slug)
    {
        $noticeEvent = NoticeEvent::query()->where('slug', $slug)->firstOrFail();
        if ($noticeEvent->job_post_id != null) {
            $noticeEventJobPost = JobPost::with('documentFile')->where('id', $noticeEvent->job_post_id)->first();
            $noticeEvent->document_source = $noticeEventJobPost->documentFile->source;
        }
        
        return response()->json($noticeEvent);
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, NoticeEvent $notice_event)
    {
        $data = $request;

        // Generate the slug from the news title and Set the slug in the data array
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;

        $noticeevent = $this->noticeevent->update($notice_event->id, $data);

        // Update or create the SEO entry
        Seo::updateOrCreate(
            [
                'model_name' => 'App\Models\NoticeEvent',
                'model_id' => $noticeevent->id,
                'site' => 'ccc', // Unique value for this record
            ],
            [
                'page_url' => '/notice-event/' . $noticeevent->slug,
                'title' => $noticeevent->title,
                'keywords' => 'ccc, notice event',
                'description' => Str::limit(strip_tags($noticeevent->description), 100),
            ]
        );

        // Create the second record
        Seo::updateOrCreate(
            [
                'model_name' => 'App\Models\NoticeEvent',
                'model_id' => $noticeevent->id,
                'site' => 'alumni', // Unique value for this record
            ],
            [
                'page_url' => '/notice-event/' . $noticeevent->slug,
                'title' => $noticeevent->title,
                'keywords' => 'alumni, notice event',
                'description' => Str::limit(strip_tags($noticeevent->description), 100),
            ]
        );

        return response()->json($noticeevent);
    }


    public function destroy(NoticeEvent $notice_event)
    {
        $noticeevent = $this->noticeevent->delete($notice_event->id);
        return response()->json($noticeevent);
    }
}
