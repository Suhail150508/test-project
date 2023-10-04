<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LargeFileUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        return $this->request;
        //   $file =  $request->file('file');
        // $fileName=hexdec(uniqid()).'.'.$file->extension();
        // $file->move('upload',$fileName);
        // $insert = new AudioVideo();
        // $insert->title = $request->title;
        // $insert->description = $request->description;
        // $insert->file = $fileName;
        // $insert->save();

    }
}
