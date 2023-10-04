<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Interfaces\GroupInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AlumniInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlumniCollection;
use Multicaret\Acquaintances\Models\Friendship;
use App\Http\Resources\FollowingAlumniCollection;
use App\Http\Resources\SuggestionAlumniCollection;

class ConnectionController extends Controller
{
    protected $alumni;

    public function __construct(AlumniInterface $alumni)
    {
        $this->alumni = $alumni;
    }

    // friendship code start
    public function getSuggestionAlumnis()
    {
        try {
            // $data = Friendship::where('sender_id', request()->auth_id)->where('status', 'pending')->pluck('recipient_id')->toArray();
            $sendFriendRequests = Friendship::where('sender_id', request()->auth_id)->pluck('recipient_id')->toArray();
            $receiveFriendRequests = Friendship::where('recipient_id', request()->auth_id)->pluck('sender_id')->toArray();
            $data = array_merge($sendFriendRequests, $receiveFriendRequests);
            array_push($data, (int)request()->auth_id);

            // $query = $this->alumni->with(['country', 'division', 'district', 'department', 'achievements', 'skills', 'experiences', 'educations'])->whereNotIn('id', $data)->get();

            $query = $this->alumni->query()
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'username','email');
            }])
            ->select('id', 'user_id', 'ewu_id_no', 'first_name', 'middle_name', 'last_name', 'blood_group', 'organization', 'designation_department', 'occupation', 'doj')
            ->whereNotIn('id', $data)
            ->get();

            return new SuggestionAlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function getSingleFriendship($sender_id, $recipient_id)
    {
        try {
            $user = Alumni::findOrFail($sender_id);
            $friend = Alumni::findOrFail($recipient_id);
            $data = $user->getFriendship($friend);

            return response()->json([
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function sendFriendRequest($recipientAlumniId)
    {
        try {
            $alumnus = Alumni::findOrFail(request()->auth_id);
            $recipient = Alumni::findOrFail($recipientAlumniId);
            $data = $alumnus->befriend($recipient);
            // $recipient->update([
            //     'friendship_status' =>  $data->status,
            // ]);

            return response()->json([
                'data' => $data,
                'message' => 'Connection Request Send',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }


    public function getPendingFriendRequests()
    {
        try {
            $data = Friendship::where('sender_id', request()->auth_id)->where('status', 'pending')->pluck('recipient_id')->toArray();
            $query = $this->alumni->with(['country', 'division', 'district', 'department', 'achievements', 'skills', 'experiences', 'educations'])->whereIn('id', $data)->get();

            return new AlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function cancelFriendRequest($recipientAlumniId)
    {
        try {
            $alumnus = Alumni::findOrFail(request()->auth_id);
            $recipient = Alumni::findOrFail($recipientAlumniId);
            $data = $alumnus->unfriend($recipient);
            // $recipient->update([
            //     'friendship_status' =>  NULL,
            // ]);

            return response()->json([
                'data' => $data,
                'message' => 'Cancel Request',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }


    public function getInvitationFriendRequests()
    {
        try {
            $alumni = Alumni::find(request()->auth_id);
            $data = $alumni->getFriendRequests();
            $sender_id = $data->pluck('sender_id')->toArray();
            $query = $this->alumni->with(['country', 'division', 'district', 'department', 'achievements', 'skills', 'experiences', 'educations'])->whereIn('id', $sender_id)->get();

            return new AlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function acceptFriendRequest($senderAlumniId)
    {
        try {
            $alumnus = Alumni::findOrFail(request()->auth_id);
            $sender = Alumni::findOrFail($senderAlumniId);
            $data = $alumnus->acceptFriendRequest($sender);

            return response()->json([
                'data' => $data,
                'message' => 'Friend Request Accept',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function denyFriendRequest($senderAlumniId)
    {
        try {
            $alumnus = Alumni::findOrFail(request()->auth_id);
            $sender = Alumni::findOrFail($senderAlumniId);
            // $data = $alumnus->denyFriendRequest($sender);
            $data = $alumnus->unfriend($sender);

            return response()->json([
                'data' => $data,
                'message' => 'Deny Request',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }


    public function getConnectionFriends()
    {
        try {
            $alumni = Alumni::findOrFail(request()->auth_id);
            $data = $alumni->getAcceptedFriendships();
            $sender_id = $data->pluck('sender_id')->toArray();
            $recipient_id = $data->pluck('recipient_id')->toArray();

            $merge_array = array_merge($sender_id, $recipient_id);
            $data = array_diff($merge_array, [request()->auth_id]);

            $query = $this->alumni->with(['country', 'division', 'district', 'department', 'achievements', 'skills', 'experiences', 'educations'])->whereIn('id', $data)->get();

            return new AlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function unfriend($senderAlumniId)
    {
        // dd($senderAlumniId);
        try {
            $alumnus = Alumni::findOrFail(request()->auth_id);
            $sender = Alumni::findOrFail($senderAlumniId);
            $data = $alumnus->unfriend($sender);

            return response()->json([
                'data' => $data,
                'message' => 'Successfully unfriend',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
    // friendship code end



    // block frined code start
    public function getBlockFriendLists()
    {
        try {
            $data = Friendship::where('sender_id', request()->auth_id)->where('status', 'blocked')->pluck('recipient_id')->toArray();
            $query = $this->alumni->with(['country', 'division', 'district', 'department', 'achievements', 'skills', 'experiences', 'educations'])->whereIn('id', $data)->get();

            return new AlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function getBlockFriendship($sender_id, $recipient_id) {
        try {
            $data = Friendship::where('sender_id', $sender_id)->where('recipient_id', $recipient_id)->where('status', 'blocked')->first();

            return response()->json([
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function block($friend_id)
    {
        try {
            $user = Alumni::findOrFail(request()->auth_id);
            $friend = Alumni::findOrFail($friend_id);
            $data = $user->blockFriend($friend);

            return response()->json([
                'data' => $data,
                'message' => 'Successfully unfriend',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function unblock($friend_id)
    {
        try {
            $user = Alumni::findOrFail(request()->auth_id);
            $friend = Alumni::findOrFail($friend_id);
            $data = $user->unblockFriend($friend);

            return response()->json([
                'data' => $data,
                'message' => 'Successfully unfriend',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
    // block frined code end




    // following code start
    public function getSuggestionFollowingAlumnis()
    {
        try {
            $user = Alumni::findOrFail(request()->auth_id);
            $followingUser = $user->followings()->get();
            $followingUserId = $followingUser->pluck('id')->toArray();
            array_push($followingUserId, (int)request()->auth_id);
            // $query = $this->alumni->with(['user', 'country', 'division', 'district', 'department', 'achievements', 'skills', 'experiences', 'educations'])->whereNotIn('id', $followingUserId)->get();

            $query = $this->alumni->query()
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'username', 'email');
            }])
            ->select('id', 'user_id', 'ewu_id_no', 'first_name', 'middle_name', 'last_name', 'blood_group', 'organization', 'designation_department', 'occupation', 'doj')
            ->whereNotIn('id', $followingUserId)
            ->get();

            return new FollowingAlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function getFollowingFriends()
    {
        try {
            $user = Alumni::findOrFail(request()->auth_id);
            $query = $user->followings()->get();

            return new AlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function getFollowerFriends()
    {
        try {
            $user = Alumni::findOrFail(request()->auth_id);
            $query = $user->followers()->get();

            return new AlumniCollection($query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function follow($target_id)
    {
        try {
            $user = Alumni::findOrFail(request()->auth_id);
            $targets = Alumni::findOrFail($target_id);
            $data = $user->follow($targets);

            return response()->json([
                'data' => $data,
                'message' => 'You are following ' . $targets->first_name . ' ' . $targets->middle_name . ' ' . $targets->last_name,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function unfollow($target_id)
    {
        try {
            $user = Alumni::findOrFail(request()->auth_id);
            $targets = Alumni::findOrFail($target_id);
            $data = $user->unfollow($targets);

            return response()->json([
                'data' => $data,
                'message' => 'You are unfollowing ' . $targets->first_name . ' ' . $targets->middle_name . ' ' . $targets->last_name,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function isFollowing($alumni_id, $subject_id)
    {
        try {
            $user = Alumni::findOrFail($alumni_id);
            $target = Alumni::findOrFail($subject_id);
            $data = $user->isFollowing($target);

            return response()->json([
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
    // following code end



    // count code start
    public function totalFriendsCount()
    {
        try {
            $alumni = Alumni::findOrFail(request()->auth_id);
            $data = $alumni->getFriendsCount();
            // dd($data);

            return response()->json([
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function totalPendingFriendRequestCount()
    {
        try {
            $data = Friendship::where('sender_id', request()->auth_id)->where('status', 'pending')->count();

            return response()->json([
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function totalInvitationCount()
    {
        try {
            $alumni = Alumni::findOrFail(request()->auth_id);
            $data = $alumni->getFriendRequests();

            return response()->json([
                'data' => $data->count(),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function totalBlockListCount()
    {
        try {
            $data = Friendship::where('sender_id', request()->auth_id)->where('status', 'blocked')->count();

            return response()->json([
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
    // count code end



    // Mutual friend code start
    public function getMutualFriends($user_id, $other_user_id) {
        try {
            $user = Alumni::findOrFail($user_id);
            $otherUser = Alumni::findOrFail($other_user_id);
            $data = $user->getMutualFriends($otherUser);
            // $data['totalMutualFriends'] = $data->count();

            // return response()->json([
            //     'data' => $data,
            // ], 200);

            return new AlumniCollection($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }
    // Mutual friend code end
}
