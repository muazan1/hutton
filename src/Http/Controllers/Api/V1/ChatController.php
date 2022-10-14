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

use Sty\Hutton\Models\{Chat,Message};

use Str;

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

            $chat = Message::create(
                [
                    'joiner_id' => $request->joiner_id,
                    'admin_id' => $request->admin_id,
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


}