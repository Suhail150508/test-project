<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\AdminCollection;
use App\Interfaces\UserInterface;
use App\Models\Alumni;
use Carbon\Carbon;
use App\Jobs\DbBackupJob;
use App\Jobs\FileBackupJob;
use Illuminate\Support\Facades\Bus;
use App\Models\Club;
use App\Models\Department;
use App\Models\EventMember;
use App\Models\Experience;
use App\Models\GroupMember;
use App\Models\JobPost;
use App\Models\NewsFeed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use function Psr\Log\error;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = User::query()
                ->where('is_admin','Yes')
                ->where('employment_status','Admin')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new AdminCollection($query);
        } else {
            $admin = User::query()->where('employment_status','Admin')->where('is_admin','Yes')->get();

            return new AdminCollection($admin);
        }
    }

    public function deletedListIndex()
    {
        $admin = User::query()->where('is_admin','Yes')->onlyTrashed()->get();

        return response()->json($admin);
    }

    public function create()
    {
        //
    }

    public function store(UserRequest $request)
    {
        if ($request['is_admin'] == 'yes'){
            $admin = $this->user->create($request);

            return response()->json([
                'data' => $admin,
                'message' => trans('admin.created'),
            ], 200);
        } else{
            return response()->json([
                "error" => trans('admin.wrong_values')
            ],422);
        }
    }

    public function show($id)
    {
        $userId = Crypt::decrypt($id); //decrypt the id
        $admin = $this->user->findOrFail($userId);

        return response()->json($admin);
    }

    public function edit($id)
    {
        $userId = Crypt::decrypt($id); //decrypt the id
        $admin = $this->user->findOrFail($userId);

        return response()->json($admin);
    }

    public function update(Request $request, $id)
    {
//        $userId = Crypt::decrypt($id); //decrypt the id
        $admin = $this->user->update($id, $request);

        return response()->json([
            'data' => $admin,
            'message' => trans('admin.updated'),
        ], 200);
    }

    public function destroy($id)
    {
//        $userId = Crypt::decrypt($id); //decrypt the id
        $this->user->delete($id);

        return response()->json([
            'message' => trans('admin.deleted'),
        ], 200);
    }

    public function restore($id)
    {
//        $userId = Crypt::decrypt($id); //decrypt the id
        $this->user->restore($id);

        return response()->json([
            'message' => trans('admin.restored'),
        ], 200);
    }

    public function forceDelete($id) //decrypt the id
    {
//        $userId = Crypt::decrypt($id);
        $this->user->forceDelete($id);

        return response()->json([
            'message' => trans('admin.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->user->status($request->id);

        return response()->json([
            'message' => trans('admin.status_updated'),
        ], 200);
    }

    public function dashboard()
    {
        $data['admins'] = User::query()->where('employment_status','Admin')->where('status','Active')->get()->count();
        $data['alumnus'] = User::query()->where('employment_status','Alumni')->where('status','Active')->get()->count();
        $data['students'] = User::query()->where('employment_status','Student')->where('status','Active')->get()->count();
        $data['companies'] = User::query()->where('employment_status','Company')->where('status','Active')->get()->count();
        $data['departments'] = Department::query()->where('status','Active')->get()->count();
        $data['clubs'] = Club::query()->where('status','Active')->get()->count();
        $data['popularCandidates'] = Alumni::query()->with('alumni','country')->where('is_feature','1')->get();
        $data['totalJobs'] = JobPost::query()->where('is_approved','Yes')->where('status','Active')->get()->count();
        $data['latestJobs'] = JobPost::query()->where('is_approved','Yes')->where('status','Active')->latest()->take(10)->get();
        $data['maxCompanies'] = JobPost::query()->selectRaw('company_name, COUNT(*) as count')->groupBy('company_name')->orderBy('count','desc')
            ->take(5)->get(['company_name','count']);
        $data['lastNewsFeed'] = NewsFeed::query()->with('alumni')->latest()->first();
        $data['newsFeedCreator'] = $data['lastNewsFeed']->alumni->user->username;
        $data['groupMember'] = GroupMember::query()->with('alumni','group')->where('status','accept')->latest()->first();
        $data['eventActivities'] = EventMember::query()->with('alumni','event')->latest()->first();
        $data['eventAlumni'] = $data['eventActivities']->alumni;
        $data['event'] = $data['eventActivities']->event;

        //chart data
        $startDate = now()->subMonths(11)->startOfMonth();
        $endDate = now()->endOfMonth();

        $data['lastCompanies'] = User::query()
            ->where('employment_status','Company')
            ->select(DB::raw('COUNT(*) as count, MONTH(created_at) as month, YEAR(created_at) as year'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('month','desc')
            ->get();

        $data['newJobs'] = JobPost::query()
            ->select(DB::raw('COUNT(*) as count, MONTH(created_at) as month, YEAR(created_at) as year'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('month','asc')
            ->get();

        $data['gotJobs'] = Experience::query()->groupBy('user_id')->where('is_current', 'Yes')
            ->select(DB::raw('COUNT(*) as count, MONTH(created_at) as month, YEAR(created_at) as year'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->get();

        $data['gotAlumnus'] = User::query()->where('employment_status','Alumni')->where('status','Active')
            ->select(DB::raw('COUNT(*) as count, MONTH(created_at) as month, YEAR(created_at) as year'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->get();

        return  response()->json($data);
    }

    public function backupList()
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        $files = $disk->files(config('backup.backup.name'));

        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $file_name = str_replace(config('backup.backup.name') . '/', '', $f);
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => $file_name,
                    'file_size' => $this->bytesToHuman($disk->size($f)),
                    'created_at' => Carbon::parse($disk->lastModified($f))->diffForHumans(),
                    'download_link' => action('Api\AdminController@backupDownload', [$file_name]),
                ];
            }
        }

        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);
        return response()->json($backups);
    }

    private function bytesToHuman($bytes)
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function runBackup(Request $request)
    {
        $batch = Bus::batch([
            new DbBackupJob(),
        ])->dispatch();
        // Dispatch the backup job to the queue
//        DbBackupJob::dispatch()->onQueue('backups');

        return response()->json(['message' => 'Database Backup job dispatched to the queue.']);
    }


    /*public function runBackup(Request $request)
    {
        // Run the backup command
        $projectPath = base_path();
        $command = 'php ' . $projectPath . '/artisan backup:run --only-db';
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {

            // Get the path to the latest backup file
            $backupPath = $this->getLatestBackupPath();

            // Stream the backup file to the user's browser for download
//            return $this->streamBackupFile($backupPath);

            return $backupPath;
//            return response()->download($backupPath)->deleteFileAfterSend(true);
        }

        abort(500, 'Failed to create the backup.');
    }

    protected function getLatestBackupPath()
    {
        // Get the path to the latest backup file
        $backupsDirectory = storage_path('app/1pv3NH0nzAIVhZmN3E7JE9ARgamS4sS4Y');
        $files = scandir($backupsDirectory, SCANDIR_SORT_DESCENDING);

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                return $backupsDirectory . '/' . $file;
            }
        }

        return null;
    }*/

    protected function streamBackupFile($backupPath)
    {
        $response = new Response($backupPath);
        $response->header('Content-Type', 'application/octet-stream');
        $response->header('Content-Disposition', 'attachment; filename="' . basename($backupPath) . '"');

        return $response;
    }

    public function runBackupFiles(Request $request)
    {
        $batch = Bus::batch([
            new FileBackupJob(),
        ])->dispatch();
        // Dispatch the backup job to the queue
//        FileBackupJob::dispatch()->onQueue('backups');

        return response()->json(['message' => 'Storage Backup job dispatched to the queue.']);
    }

    public function backupDownload($file_name)
    {
        $filePath = storage_path('app/1pv3NH0nzAIVhZmN3E7JE9ARgamS4sS4Y/' . $file_name);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function deleteBackup($file_name)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists(config('backup.backup.name') . '/' . $file_name)) {
            $disk->delete(config('backup.backup.name') . '/' . $file_name);
        }

        return response()->json('Backup Deleted Successfully');
    }

    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }

    public function restoreDatabase(Request $request)
    {
        $sqlFile = $request->file('file');

        // Get the path to the temporary storage directory
        $tempPath = storage_path('app/temp');

        // Store the SQL file in the temporary storage directory
        $filePath = $sqlFile->store('temp');

        // Get the full path to the SQL file
        $fullPath = $tempPath . '/' . $filePath;

        // Read the contents of the SQL file
        $sql = file_get_contents($fullPath);

        // Run the SQL queries to restore the database
        DB::unprepared($sql);

        // Delete the temporary SQL file
        Storage::delete($filePath);

        return response()->json(['message' => 'Database restored successfully']);

    }
}
