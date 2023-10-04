<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsletterMailCollection;
use App\Http\Resources\AllMailCollection;
use App\Interfaces\NewsletterMailInterface;
use App\Models\CreateMailList;
use App\Models\NewsletterMail;
use App\Models\AllMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel;

class NewsletterMailController extends Controller
{
    protected $newsletterMail;

    public function __construct(NewsletterMailInterface $newsletterMail)
    {
        $this->newsletterMail = $newsletterMail;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = NewsletterMail::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new NewsletterMailCollection($query);
        } else {
            $query = $this->newsletterMail->get();

            return new NewsletterMailCollection($query);
        }
    }

    public function allMailList()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = AllMail::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new AllMailCollection($query);
    }



    public function deletedListIndex()
    {
        $newsletterMail = $this->newsletterMail->onlyTrashed();

        return response()->json($newsletterMail);
    }

    public function create()
    {
        //
    }

    // newsletter mail send

    public function store(Request $request)
    {

    // $users = User::query()->where('employment_status','Alumni')->select(['id','email'])->get();
    // foreach($users as $user){
    //     if($user->education){
    //         $users = User::whereHas('education', function ($query) use ($request) {
    //             $query->where('grade', $request->sub_type_value);
    //         })->pluck('email');
    //         foreach($users as $user){
    //             try{
    //                 Mail::to($user->email)->send(new \App\Mail\NewsletterMail($data));
    //             } catch (\Exception $e) {
    //                 $failedRecipients[] = $user->email;
    //             } 
    //         }
    //     }
    // }

        $request->validate([
            'type' => 'required',
            'mail_subject' => 'required',
            'mail_body' => 'required',
        ]);

        $data = $request;
        $failedRecipients = [];

        if ($request->type == 'SystemAdmins'){
            $users = User::query()->where('employment_status','Admin')->get();
            foreach ($users as $key => $user) {
                try{
                    Mail::to($user->email)->send(new \App\Mail\NewsletterMail($data));
                    $createAllMail = new AllMail();
                    $createAllMail->type = $request->type;
                    $createAllMail->email = $user->email;
                    $createAllMail->status = 'Sent';
                    $createAllMail->save();
                } catch (\Exception $e) {
                    $failedRecipients[] = $user->email;
                    $createAllMail = new AllMail();
                    $createAllMail->type = $request->type;
                    $createAllMail->email = $user->email;
                    $createAllMail->status = 'Not Sent';
                    $createAllMail->save();
                }
            }
        } elseif ($request->type == 'SystemAlumnus') {

        $users = User::query()
        ->where('employment_status', 'Alumni')
        ->whereHas('alumniEducation', function ($query) use ($request) {
            $query->where('grade', $request->sub_type_value);
        })
        ->select(['id', 'email'])
        ->get();

        $failedRecipients = [];
        $emailRecipients = [];

        foreach ($users as $user) {
            $emailRecipients[] = $user->email;
        }
        foreach ($emailRecipients as $email) {
            try {
                Mail::to($email)->send(new \App\Mail\NewsletterMail($data));
            } catch (\Exception $e) {
                $failedRecipients[] = $email;
            }
        }
         return response()->json('success');
          
        } elseif ($request->type == 'SystemStudents'){
            
            $users = User::query()
            ->where('employment_status', 'Student')
            ->whereHas('studentEducations', function ($query) use ($request) {
                $query->where('grade', $request->sub_type_value);
            })
            ->select(['id', 'email'])
            ->get();

            $failedRecipients = [];
            $emailRecipients = [];
    
            foreach ($users as $user) {
                $emailRecipients[] = $user->email;
            }
            foreach ($emailRecipients as $email) {
                try {
                    Mail::to($email)->send(new \App\Mail\NewsletterMail($data));
                } catch (\Exception $e) {
                    $failedRecipients[] = $email;
                }
            }
            return response()->json('success');
        } elseif ($request->type == 'SystemCompanyHolders'){
            $users = User::query()->where('employment_status','Company')->get();
            foreach ($users as $key => $user) {
                try{
                    Mail::to($user->email)->send(new \App\Mail\NewsletterMail($data));
                } catch (\Exception $e) {
                    $failedRecipients[] = $user->email;
                }
            }
        } elseif ($request->type == 'ImportWithFile' && $request->importedFileEmailList){
            foreach ($request->importedFileEmailList as $key => $email) {
                try{
                    Mail::to($email)->send(new \App\Mail\NewsletterMail($data));
                } catch (\Exception $e) {
                    $failedRecipients[] = $user->email;
                }
            }
        } elseif ($request->recipient_user_ids && $request->type == 'Individual'){
            foreach ($request->recipient_user_ids as $userId){
                $user = User::query()->findOrFail($userId);
                try{
                    Mail::to($user->email)->send(new \App\Mail\NewsletterMail($data));
                    $createAllMail = new AllMail();
                    $createAllMail->type = $request->type;
                    $createAllMail->email = $user->email;
                    $createAllMail->status = 'Sent';
                    $createAllMail->save();
                } catch (\Exception $e) {
                    $failedRecipients[] = $user->email;
                    $createAllMail = new AllMail();
                    $createAllMail->type = $request->type;
                    $createAllMail->email = $user->email;
                    $createAllMail->status = 'Not Sent';
                    $createAllMail->save();
                }
            }
        }/* elseif ($request->selected_mail_list_id && $request->type == 'MailList'){
            $listDetails = CreateMailList::query()->with('importedFile')->findOrFail($request->selected_mail_list_id);
            $data = Excel::import($listDetails->importedFile->source)->get();
        }*/

        //store mail in newsletterMail table

        if($request->type == 'SystemAdmins' || $request->type == 'SystemAlumnus' || $request->type == 'SystemStudents' || $request->type == 'SystemCompanyHolders'){

            $this->newsletterMail->create($request);

        }elseif ($request->type == 'Individual' && $request->recipient_user_ids){

            $request['recipient_user_ids'] = json_encode($request->recipient_user_ids);

            $this->newsletterMail->create($request);

        } else if ($request->type == 'ImportWithFile' && $request->importedFile){
            $parameters = [
                'file_info' => [
                    [
                        'type' => 'newsletterMail',
                        'files' => $request->importedFile,
                        'directory' => 'newsletterMail',
                        'input_field' => 'importedFile',
                    ],
                ],
            ];

            $newsletterMail = $this->newsletterMail->create($request, $parameters);
        }

        if (count($failedRecipients) > 0) {
            return response()->json(['message' => 'Email sent with failures', 'failed_recipients' => $failedRecipients]);
        } else {
            return response()->json(['message' => 'Email sent successfully']);
        }
//        return response()->json(['message' => 'Email sent successfully']);
    }

    public function show(NewsletterMail $newsletterMail)
    {
        //
    }

    public function edit(NewsletterMail $newsletterMail)
    {
        //
    }

    public function update(Request $request, NewsletterMail $newsletterMail)
    {
        //
    }

    public function destroy(NewsletterMail $newsletterMail)
    {
        //
    }
}
