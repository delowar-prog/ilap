<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    /**
     * Display Admin Chat Portal.
     */
    public function index(Request $request)
    {
        $query = Conversation::with(['student.user', 'user', 'lastMessage'])
            ->orderBy('last_message_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('surname', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status') && in_array($request->status, ['open', 'closed'])) {
            $query->where('status', $request->status);
        }

        $conversations = $query->get();

        $activeConversation = null;
        $messages = collect([]);

        if ($conversations->isNotEmpty()) {
            $activeId = $request->query('conversation_id', $conversations->first()->id);
            $activeConversation = $conversations->firstWhere('id', $activeId) ?? $conversations->first();

            // Mark student messages as read by admin
            Message::where('conversation_id', $activeConversation->id)
                ->where('sender_id', '!=', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $messages = $activeConversation->messages()->with('sender')->get();
        }

        return view('backend.admin.chat.index', compact('conversations', 'activeConversation', 'messages'));
    }

    /**
     * Send message reply from Admin.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
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
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'sender_name' => Auth::user()->name ?? 'Admin',
                    'message' => $message->message,
                    'attachment_url' => $message->attachmentUrl,
                    'created_at' => $message->created_at->format('M d, Y h:i A'),
                    'is_me' => true,
                ]
            ]);
        }

        return redirect()->route('admin.chats.index', ['conversation_id' => $conversation->id]);
    }

    /**
     * Toggle status (Open / Closed).
     */
    public function toggleStatus(Conversation $conversation)
    {
        $newStatus = ($conversation->status === 'open') ? 'closed' : 'open';
        $conversation->update(['status' => $newStatus]);

        return redirect()->back()->with('success', "Conversation status changed to {$newStatus}.");
    }

    /**
     * Fetch messages for AJAX polling in Admin panel.
     */
    public function fetchMessages(Conversation $conversation)
    {
        $adminId = Auth::id();

        // Mark unread messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $adminId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()->with('sender')->get()->map(function ($msg) use ($adminId) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name ?? 'Student',
                'message' => $msg->message,
                'attachment_url' => $msg->attachmentUrl,
                'created_at' => $msg->created_at->format('M d, h:i A'),
                'is_me' => ($msg->sender_id === $adminId),
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }
}
