<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Sty\Hutton\Models\BuildingType;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Collection;

use Exception;

use Sty\Hutton\Models\{Chat,Message,MessageReplay};

use Str;

use App\Models\User;

class ChatController extends Controller
{
    public function CreateChat(Request $request) {

        try {

            $chat = Chat::updateOrCreate(
                [
                    'admin_id' => $request->admin_id,
                    'joiner_id'   => $request->joiner_id
                ],
                [
                    'admin_id' => $request->admin_id,
                    'joiner_id'   => $request->joiner_id
                ],
            );

            $message = 'Chat Created Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => ['chat' => $chat],
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }

    public function CreateMessage(Request $request,$chat) {

        try {

            $chat = Chat::find($chat);

            $chat = Message::create(
                [
                    'chat_id' => $chat->id,
                    'from_user_id' => $request->from_user_id,
                    'message' => $request->message,
                ]
            );

            $message = 'Message Sent Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => ['chat' => $chat],
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }

    public function GetChat(Request $request,$chat) {

        try {

            $chat = Chat::with('messages')->find($chat);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['chat' => $chat],
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }

    public function sendMessage (Request $request) {

        try {

            $joiner = User::where('uuid',$request->joiner)->first();

            $admin = User::where('uuid',$request->admin)->first();

            $chat = Message::create(
                [
                    'joiner_id' => $joiner->id,
                    'admin_id' => $admin->id,
                    'message' => $request->message,
                ]
            );

            $message = 'Message Sent Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => ['chat' => $chat],
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }
    }

    public function adminNotifications (Request $request,$uuid) {

        try {

            $admin = User::where('uuid',$uuid)->first();

            $chats = Message::with('admin','joiner','replies')
                                ->where('admin_id',$admin->id)
//                                ->where('is_read',0)
                                ->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['chats' => $chats],
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }

    public function joinerNotifications (Request $request,$uuid) {

        try {

            $joiner = User::where('uuid',$uuid)->first();

            $chats = Message::with('admin','joiner','replies')
                                ->where('joiner_id',$joiner->id)
//                                ->where('is_read',0)
                                ->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['chats' => $chats],
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }

    public function chatReply (Request $request) {

        try {

            $msg = Message::find($request->message_id);

            if($msg != null){

                $replay = MessageReplay::create([
                    'message_id' => $request->message_id,
                    'message'   => $request->message
                ]);

            }
            else
            {
                $message =  'Message not found';

                return response()->json([
                    'type' => 'error',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $message = 'Message sent Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }

    public function markRead (Request $request,$message_id) {

        try {

            $msg = Message::find($message_id);

            if($msg != null){

                $msg->update([
                    'is_read' => 1,
                ]);

            }
            else
            {
                $message =  'Message not found';

                return response()->json([
                    'type' => 'error',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $message = 'Mark as Read Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }

    public function messageDetails (Request $request,$message_id) {

        try {

            $msg = Message::with('joiner','admin','replies')->find($message_id);

            $message = '';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => ['message' => $msg],
            ]);

        }
        catch (\Exception $e) {

            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }

    }
}
