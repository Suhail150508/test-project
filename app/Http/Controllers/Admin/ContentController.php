<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ContentRequest;
use App\Interfaces\ContentInterface;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    protected $content;

    public function __construct(ContentInterface $content)
    {
        $this->content = $content;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.content.{$link}";
    }

    public function index()
    {
        if(request()->ajax()){
            return $this->content->datatable();
        }else{
            return view($this->path('index'));
        }
    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            return $this->content->deletedDatatable();
        }
    }

    public function create()
    {
        return view($this->path('create'));
    }

    public function store(ContentRequest $request)
    {
        return $this->content->create($request);
    }

    public function show(Content $content)
    {
        //
    }

    public function edit(Content $content)
    {
        $data['content'] = $content;
        return view($this->path('edit'))->with($data);
    }

    public function update(ContentRequest $request, Content $content)
    {
        return $this->content->update($content->id,$request);
    }

    public function destroy(Content $content)
    {
        return $this->content->delete($content->id);
    }

    public function restore($id)
    {
        return $this->content->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->content->forceDelete($id);
    }
}
