@extends('layouts.backend_master')
@section('title', 'Direct Chat with Admin')

@push('css')
<style>
    .chat-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.06);
        overflow: hidden;
        background: #fff;
    }
    .chat-sidebar {
        border-right: 1px solid #edf2f9;
        background-color: #f9fbfd;
        height: 680px;
        display: flex;
        flex-direction: column;
    }
    .conversation-item {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f9;
        transition: all 0.2s ease;
        text-decoration: none !important;
        color: inherit;
        display: block;
    }
    .conversation-item:hover, .conversation-item.active {
        background-color: #ffffff;
        box-shadow: inset 4px 0 0 #2c3e7a;
    }
    .chat-main {
        height: 680px;
        display: flex;
        flex-direction: column;
        background: #ffffff;
    }
    .chat-header {
        padding: 18px 24px;
        border-bottom: 1px solid #edf2f9;
        background: #ffffff;
    }
    .chat-body {
        flex: 1;
        padding: 24px;
        overflow-y: auto;
        background-color: #f8fafc;
    }
    .message-wrapper {
        display: flex;
        margin-bottom: 20px;
        flex-direction: column;
    }
    .message-wrapper.me {
        align-items: flex-end;
    }
    .message-wrapper.other {
        align-items: flex-start;
    }
    .message-bubble {
        max-width: 75%;
        padding: 14px 18px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
        word-wrap: break-word;
    }
    .message-wrapper.me .message-bubble {
        background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%);
        color: #ffffff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(44, 62, 122, 0.2);
    }
    .message-wrapper.other .message-bubble {
        background: #ffffff;
        color: #2d3748;
        border: 1px solid #e2e8f0;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    .message-info {
        font-size: 0.75rem;
        color: #a0aec0;
        margin-top: 5px;
    }
    .chat-footer {
        padding: 16px 24px;
        border-top: 1px solid #edf2f9;
        background: #ffffff;
    }
    .attachment-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(255,255,255,0.2);
        padding: 6px 12px;
        border-radius: 8px;
        margin-top: 8px;
        font-size: 0.85rem;
        color: inherit;
        text-decoration: none;
    }
    .message-wrapper.other .attachment-badge {
        background: #edf2f7;
        color: #2d3748;
    }
</style>
@endpush

@section('admin_contents')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-1" style="color: #2c3e7a;"><i class="fas fa-comments me-2"></i> Direct Chatting</h3>
            <p class="text-muted small mb-0">Communicate directly with Admin and Academic Support team.</p>
        </div>
        <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#newChatModal">
            <i class="fas fa-plus me-1"></i> New Topic
        </button>
    </div>

    <div class="card chat-card">
        <div class="row g-0">
            <!-- Sidebar: Conversations List -->
            <div class="col-lg-4 col-md-5 chat-sidebar">
                <div class="p-3 border-bottom bg-light">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-list-ul me-1"></i> Conversations</h6>
                </div>
                <div class="overflow-auto flex-grow-1">
                    @forelse($conversations as $conv)
                        <a href="{{ route('student.chat.index', ['conversation_id' => $conv->id]) }}" 
                           class="conversation-item {{ $activeConversation && $activeConversation->id === $conv->id ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 180px;">
                                    {{ $conv->subject ?? 'General Conversation' }}
                                </h6>
                                <span class="badge {{ $conv->status === 'open' ? 'bg-success' : 'bg-secondary' }} font-11">
                                    {{ ucfirst($conv->status) }}
                                </span>
                            </div>
                            <p class="text-muted small mb-1 text-truncate">
                                @if($conv->lastMessage)
                                    {{ $conv->lastMessage->sender_id === Auth::id() ? 'You: ' : '' }}{{ $conv->lastMessage->message ?? '[Attachment]' }}
                                @else
                                    No messages yet.
                                @endif
                            </p>
                            <div class="d-flex justify-content-between align-items-center font-11 text-muted">
                                <span><i class="far fa-clock me-1"></i>{{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '' }}</span>
                                @php $unread = $conv->unreadCountForUser(Auth::id()); @endphp
                                @if($unread > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unread }} new</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-comment-slash fa-2x mb-2 opacity-50"></i>
                            <p class="mb-0">No conversations started yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="col-lg-8 col-md-7 chat-main">
                @if($activeConversation)
                    <!-- Header -->
                    <div class="chat-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl me-3">
                                <div class="avatar-name rounded-circle bg-soft-primary text-primary fw-bold fs-5">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">{{ $activeConversation->subject ?? 'Direct Chat' }}</h5>
                                <span class="text-muted font-12"><i class="fas fa-circle text-success font-10 me-1"></i> Admin Support Team</span>
                            </div>
                        </div>
                        <div>
                            <span class="badge {{ $activeConversation->status === 'open' ? 'bg-soft-success text-success' : 'bg-soft-secondary text-secondary' }} px-3 py-2 rounded-pill font-12">
                                Status: {{ ucfirst($activeConversation->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Chat Messages Body -->
                    <div class="chat-body" id="chatBody">
                        @forelse($messages as $msg)
                            @php $isMe = ($msg->sender_id === Auth::id()); @endphp
                            <div class="message-wrapper {{ $isMe ? 'me' : 'other' }}">
                                <div class="message-bubble">
                                    @if(!$isMe)
                                        <div class="fw-bold font-12 mb-1 opacity-75">{{ $msg->sender->name ?? 'Admin' }}</div>
                                    @endif

                                    @if($msg->message)
                                        <div>{!! nl2br(e($msg->message)) !!}</div>
                                    @endif

                                    @if($msg->attachment)
                                        <div>
                                            <a href="{{ $msg->attachmentUrl }}" target="_blank" class="attachment-badge">
                                                <i class="fas fa-paperclip me-2"></i> Attachment (View / Download)
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="message-info">
                                    {{ $msg->created_at->format('M d, h:i A') }}
                                    @if($isMe)
                                        &bull; <i class="fas {{ $msg->is_read ? 'fa-check-double text-info' : 'fa-check text-muted' }}"></i>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted my-5">
                                <i class="fas fa-comments fa-3x mb-3 text-300"></i>
                                <p class="mb-0">Start the conversation by typing your message below.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer: Input Form -->
                    <div class="chat-footer">
                        @if($activeConversation->status === 'closed')
                            <div class="alert alert-secondary mb-0 text-center font-13">
                                <i class="fas fa-lock me-1"></i> This conversation has been marked as closed by Admin. You can start a new topic anytime.
                            </div>
                        @else
                            <form id="sendMessageForm" action="{{ route('student.chat.send', $activeConversation->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div id="attachmentPreview" class="mb-2 d-none">
                                    <span class="badge bg-light text-dark border p-2 font-12">
                                        <i class="fas fa-file me-1"></i> <span id="fileName">File</span>
                                        <button type="button" class="btn-close ms-2" onclick="removeAttachment()" style="font-size: 0.6rem;"></button>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <label class="btn btn-light border border-end-0 text-secondary" for="fileAttachment" title="Attach file">
                                        <i class="fas fa-paperclip"></i>
                                        <input type="file" name="attachment" id="fileAttachment" class="d-none" onchange="handleFileSelect(this)">
                                    </label>
                                    <input type="text" name="message" id="messageInput" class="form-control border" placeholder="Type your message here..." autocomplete="off">
                                    <button type="submit" class="btn btn-primary px-4 fw-bold" id="sendBtn" style="background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%); border: none;">
                                        <i class="fas fa-paper-plane me-1"></i> Send
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-center p-4">
                        <div>
                            <i class="fas fa-comments fa-4x text-200 mb-3"></i>
                            <h5 class="fw-bold text-dark">No Active Conversation</h5>
                            <p class="text-muted">Select a conversation from the sidebar or start a new topic.</p>
                            <button class="btn btn-primary btn-sm rounded-pill px-4 mt-2" data-bs-toggle="modal" data-bs-target="#newChatModal">
                                Start New Topic
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal: Start New Chat -->
<div class="modal fade" id="newChatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('student.chat.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" style="color: #2c3e7a;"><i class="fas fa-comment-medical me-2"></i> Start New Topic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-dark">Topic / Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="e.g. Question about Visa / Fees / Document Status" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-dark">Initial Message</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Write your query in detail..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Create Topic</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    function scrollToBottom() {
        const chatBody = document.getElementById('chatBody');
        if (chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    }

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            document.getElementById('fileName').innerText = input.files[0].name;
            document.getElementById('attachmentPreview').classList.remove('d-none');
        }
    }

    function removeAttachment() {
        const input = document.getElementById('fileAttachment');
        if (input) input.value = '';
        document.getElementById('attachmentPreview').classList.add('d-none');
    }

    document.addEventListener("DOMContentLoaded", function () {
        scrollToBottom();

        const form = document.getElementById('sendMessageForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(form);
                const messageInput = document.getElementById('messageInput');
                const sendBtn = document.getElementById('sendBtn');

                if (!messageInput.value.trim() && !document.getElementById('fileAttachment').files.length) {
                    return;
                }

                sendBtn.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    sendBtn.disabled = false;
                    if (data.success) {
                        messageInput.value = '';
                        removeAttachment();
                        fetchLiveMessages();
                    }
                })
                .catch(err => {
                    sendBtn.disabled = false;
                    form.submit(); // fallback to normal submit
                });
            });
        }

        @if($activeConversation)
        function fetchLiveMessages() {
            fetch("{{ route('student.chat.fetch', $activeConversation->id) }}", {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.messages) {
                    const chatBody = document.getElementById('chatBody');
                    let html = '';
                    data.messages.forEach(msg => {
                        html += `
                            <div class="message-wrapper ${msg.is_me ? 'me' : 'other'}">
                                <div class="message-bubble">
                                    ${!msg.is_me ? `<div class="fw-bold font-12 mb-1 opacity-75">${msg.sender_name}</div>` : ''}
                                    ${msg.message ? `<div>${msg.message.replace(/\n/g, '<br>')}</div>` : ''}
                                    ${msg.attachment_url ? `<div><a href="${msg.attachment_url}" target="_blank" class="attachment-badge"><i class="fas fa-paperclip me-2"></i> Attachment</a></div>` : ''}
                                </div>
                                <div class="message-info">${msg.created_at}</div>
                            </div>
                        `;
                    });
                    chatBody.innerHTML = html;
                    scrollToBottom();
                }
            })
            .catch(e => console.log('Polling error:', e));
        }

        // Poll for new messages every 4 seconds
        setInterval(fetchLiveMessages, 4000);
        @endif
    });
</script>
@endpush
@endsection
