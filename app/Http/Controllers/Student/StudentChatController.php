<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentChatController extends Controller
{
    /**
     * Show student chat portal.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Student record not found.');
        }

        // Fetch or create default conversation
        $conversations = Conversation::where('student_id', $student->id)
            ->with(['lastMessage', 'student'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        if ($conversations->isEmpty()) {
            $conversation = Conversation::create([
                'student_id' => $student->id,
                'user_id' => $user->id,
                'subject' => 'Chat with Admin',
                'status' => 'open',
                'last_message_at' => now(),
            ]);

            // Welcome system message
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $user->id,
                'message' => 'Hello Admin, I have a question regarding my application/account.',
                'is_read' => false,
            ]);

            $conversations = collect([$conversation]);
        }

        $activeConversationId = $request->query('conversation_id', $conversations->first()->id);
        $activeConversation = $conversations->firstWhere('id', $activeConversationId) ?? $conversations->first();

        // Mark admin messages as read
        Message::where('conversation_id', $activeConversation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $activeConversation->messages()->with('sender')->get();

        return view('backend.student.chat.index', compact('conversations', 'activeConversation', 'messages', 'student'));
    }

    /**
     * Create a new conversation thread.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        $student = $user->student;

        $conversation = Conversation::create([
            'student_id' => $student->id,
            'user_id' => $user->id,
            'subject' => $request->subject ?? 'Direct Inquiry',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('student.chat.index', ['conversation_id' => $conversation->id])
            ->with('success', 'New chat thread started!');
    }

    /**
     * Send a message in active conversation.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $student = $user->student;

        if ($conversation->student_id !== $student->id) {
            abort(403, 'Unauthorized access to conversation.');
        }

        $request->validate([
            'message' => 'required_without:attachment|nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat_attachments', 'public');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'status' => 'open',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $user->name,
                    'message' => $message->message,
                    'attachment_url' => $message->attachmentUrl,
                    'created_at' => $message->created_at->format('M d, Y h:i A'),
                    'is_me' => true,
                ]
            ]);
        }

        return redirect()->route('student.chat.index', ['conversation_id' => $conversation->id]);
    }

    /**
     * Fetch messages via AJAX for real-time polling.
     */
    public function fetchMessages(Conversation $conversation)
    {
        $user = Auth::user();
        $student = $user->student;

        if ($conversation->student_id !== $student->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark incoming messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()->with('sender')->get()->map(function ($msg) use ($user) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name ?? 'User',
                'message' => $msg->message,
                'attachment_url' => $msg->attachmentUrl,
                'created_at' => $msg->created_at->format('M d, h:i A'),
                'is_me' => ($msg->sender_id === $user->id),
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }
}
