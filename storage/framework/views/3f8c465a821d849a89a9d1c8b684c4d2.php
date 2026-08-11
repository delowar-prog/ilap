<?php $__env->startSection('title', 'Student Chatting Center'); ?>

<?php $__env->startPush('css'); ?>
<style>
    .admin-chat-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.06);
        overflow: hidden;
        background: #fff;
    }
    .admin-chat-sidebar {
        border-right: 1px solid #edf2f9;
        background-color: #f9fbfd;
        height: 720px;
        display: flex;
        flex-direction: column;
    }
    .admin-conv-item {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f9;
        transition: all 0.2s ease;
        text-decoration: none !important;
        color: inherit;
        display: block;
    }
    .admin-conv-item:hover, .admin-conv-item.active {
        background-color: #ffffff;
        box-shadow: inset 4px 0 0 #1a9fd4;
    }
    .admin-chat-main {
        height: 720px;
        display: flex;
        flex-direction: column;
        background: #ffffff;
    }
    .admin-chat-header {
        padding: 18px 24px;
        border-bottom: 1px solid #edf2f9;
        background: #ffffff;
    }
    .admin-chat-body {
        flex: 1;
        padding: 24px;
        overflow-y: auto;
        background-color: #f8fafc;
    }
    .msg-wrapper {
        display: flex;
        margin-bottom: 20px;
        flex-direction: column;
    }
    .msg-wrapper.me {
        align-items: flex-end;
    }
    .msg-wrapper.other {
        align-items: flex-start;
    }
    .msg-bubble {
        max-width: 75%;
        padding: 14px 18px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
        word-wrap: break-word;
    }
    .msg-wrapper.me .msg-bubble {
        background: linear-gradient(135deg, #1a9fd4 0%, #2c3e7a 100%);
        color: #ffffff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(26, 159, 212, 0.2);
    }
    .msg-wrapper.other .msg-bubble {
        background: #ffffff;
        color: #2d3748;
        border: 1px solid #e2e8f0;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    .msg-info {
        font-size: 0.75rem;
        color: #a0aec0;
        margin-top: 5px;
    }
    .admin-chat-footer {
        padding: 16px 24px;
        border-top: 1px solid #edf2f9;
        background: #ffffff;
    }
    .att-badge {
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
    .msg-wrapper.other .att-badge {
        background: #edf2f7;
        color: #2d3748;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-1 text-dark"><i class="fas fa-comments text-primary me-2"></i> Student Chatting Center</h3>
            <p class="text-muted small mb-0">Manage and respond to live inquiries from students.</p>
        </div>
    </div>

    <div class="card admin-chat-card">
        <div class="row g-0">
            <!-- Sidebar: Conversations List -->
            <div class="col-lg-4 col-md-5 admin-chat-sidebar">
                <!-- Search & Filters -->
                <div class="p-3 border-bottom bg-light">
                    <form action="<?php echo e(route('admin.chats.index')); ?>" method="GET" class="mb-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="Search student name, ID, topic..." value="<?php echo e(request('search')); ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between align-items-center font-12">
                        <span class="fw-bold text-dark">Filter:</span>
                        <div>
                            <a href="<?php echo e(route('admin.chats.index', array_merge(request()->query(), ['status' => '']))); ?>" 
                               class="badge <?php echo e(!request('status') ? 'bg-primary' : 'bg-light text-dark'); ?> me-1 text-decoration-none">All</a>
                            <a href="<?php echo e(route('admin.chats.index', array_merge(request()->query(), ['status' => 'open']))); ?>" 
                               class="badge <?php echo e(request('status') === 'open' ? 'bg-success' : 'bg-light text-dark'); ?> me-1 text-decoration-none">Open</a>
                            <a href="<?php echo e(route('admin.chats.index', array_merge(request()->query(), ['status' => 'closed']))); ?>" 
                               class="badge <?php echo e(request('status') === 'closed' ? 'bg-secondary' : 'bg-light text-dark'); ?> text-decoration-none">Closed</a>
                        </div>
                    </div>
                </div>

                <!-- List -->
                <div class="overflow-auto flex-grow-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php 
                            $studentObj = $conv->student; 
                            $studentName = $studentObj ? ucwords(trim($studentObj->first_name . ' ' . $studentObj->surname)) : ($conv->user->name ?? 'Student');
                            $unread = $conv->unreadCountForUser(Auth::id());
                        ?>
                        <a href="<?php echo e(route('admin.chats.index', array_merge(request()->query(), ['conversation_id' => $conv->id]))); ?>" 
                           class="admin-conv-item <?php echo e($activeConversation && $activeConversation->id === $conv->id ? 'active' : ''); ?>">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 170px;">
                                    <?php echo e($studentName); ?>

                                </h6>
                                <span class="badge <?php echo e($conv->status === 'open' ? 'bg-success' : 'bg-secondary'); ?> font-11">
                                    <?php echo e(ucfirst($conv->status)); ?>

                                </span>
                            </div>
                            <div class="text-primary font-12 fw-bold text-truncate mb-1">
                                Topic: <?php echo e($conv->subject ?? 'General Chat'); ?>

                            </div>
                            <p class="text-muted small mb-1 text-truncate">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conv->lastMessage): ?>
                                    <?php echo e($conv->lastMessage->sender_id === Auth::id() ? 'You: ' : ''); ?><?php echo e($conv->lastMessage->message ?? '[Attachment]'); ?>

                                <?php else: ?>
                                    No messages yet.
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center font-11 text-muted">
                                <span><i class="far fa-clock me-1"></i><?php echo e($conv->last_message_at ? $conv->last_message_at->diffForHumans() : ''); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unread > 0): ?>
                                    <span class="badge bg-danger rounded-pill"><?php echo e($unread); ?> unread</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 opacity-50"></i>
                            <p class="mb-0">No student conversations found.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Main Chat Panel -->
            <div class="col-lg-8 col-md-7 admin-chat-main">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConversation): ?>
                    <?php 
                        $activeStudent = $activeConversation->student;
                        $activeStudentName = $activeStudent ? ucwords(trim($activeStudent->first_name . ' ' . $activeStudent->surname)) : ($activeConversation->user->name ?? 'Student');
                    ?>
                    <!-- Header -->
                    <div class="admin-chat-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl me-3">
                                <div class="avatar-name rounded-circle bg-soft-primary text-primary fw-bold fs-5">
                                    <?php echo e(strtoupper(substr($activeStudentName, 0, 1))); ?>

                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark"><?php echo e($activeStudentName); ?></h5>
                                <div class="text-muted font-12">
                                    <span>ID: <strong><?php echo e($activeStudent->student_id ?? 'N/A'); ?></strong></span> &bull; 
                                    <span><?php echo e($activeStudent->email ?? $activeConversation->user->email ?? ''); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeStudent && $activeStudent->phone): ?>
                                        &bull; <span><i class="fas fa-phone-alt font-10"></i> <?php echo e($activeStudent->phone); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <form action="<?php echo e(route('admin.chats.toggle_status', $activeConversation->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm <?php echo e($activeConversation->status === 'open' ? 'btn-outline-danger' : 'btn-outline-success'); ?> px-3 rounded-pill">
                                    <i class="fas <?php echo e($activeConversation->status === 'open' ? 'fa-lock' : 'fa-lock-open'); ?> me-1"></i>
                                    <?php echo e($activeConversation->status === 'open' ? 'Mark Closed' : 'Reopen Chat'); ?>

                                </button>
                            </form>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeStudent): ?>
                                <a href="<?php echo e(route('admin.students.show', $activeStudent->id)); ?>" class="btn btn-sm btn-light border rounded-pill" target="_blank" title="View Student Profile">
                                    <i class="fas fa-user-graduate me-1"></i> Profile
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <!-- Messages Body -->
                    <div class="admin-chat-body" id="adminChatBody">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php $isMe = ($msg->sender_id === Auth::id()); ?>
                            <div class="msg-wrapper <?php echo e($isMe ? 'me' : 'other'); ?>">
                                <div class="msg-bubble">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isMe): ?>
                                        <div class="fw-bold font-12 mb-1 opacity-75"><?php echo e($msg->sender->name ?? $activeStudentName); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($msg->message): ?>
                                        <div><?php echo nl2br(e($msg->message)); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($msg->attachment): ?>
                                        <div>
                                            <a href="<?php echo e($msg->attachmentUrl); ?>" target="_blank" class="att-badge">
                                                <i class="fas fa-paperclip me-2"></i> Attachment (View / Download)
                                            </a>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="msg-info">
                                    <?php echo e($msg->created_at->format('M d, h:i A')); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isMe): ?>
                                        &bull; <i class="fas <?php echo e($msg->is_read ? 'fa-check-double text-info' : 'fa-check text-muted'); ?>"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="text-center text-muted my-5">
                                <i class="fas fa-comments fa-3x mb-3 text-300"></i>
                                <p class="mb-0">No messages in this chat thread yet.</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Input Footer -->
                    <div class="admin-chat-footer">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeConversation->status === 'closed'): ?>
                            <div class="alert alert-warning mb-0 text-center font-13 d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-exclamation-triangle me-1"></i> This conversation is currently closed.</span>
                                <form action="<?php echo e(route('admin.chats.toggle_status', $activeConversation->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-dark">Reopen Chat to Reply</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <form id="adminSendForm" action="<?php echo e(route('admin.chats.send', $activeConversation->id)); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div id="adminAttachmentPreview" class="mb-2 d-none">
                                    <span class="badge bg-light text-dark border p-2 font-12">
                                        <i class="fas fa-file me-1"></i> <span id="adminFileName">File</span>
                                        <button type="button" class="btn-close ms-2" onclick="removeAdminAttachment()" style="font-size: 0.6rem;"></button>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <label class="btn btn-light border border-end-0 text-secondary" for="adminFileAttachment" title="Attach File">
                                        <i class="fas fa-paperclip"></i>
                                        <input type="file" name="attachment" id="adminFileAttachment" class="d-none" onchange="handleAdminFileSelect(this)">
                                    </label>
                                    <input type="text" name="message" id="adminMessageInput" class="form-control border" placeholder="Type reply to student..." autocomplete="off">
                                    <button type="submit" class="btn btn-primary px-4 fw-bold" id="adminSendBtn">
                                        <i class="fas fa-paper-plane me-1"></i> Send Reply
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center h-100 text-center p-4">
                        <div>
                            <i class="fas fa-comments fa-4x text-200 mb-3"></i>
                            <h5 class="fw-bold text-dark">No Active Conversation Selected</h5>
                            <p class="text-muted">Select a student from the sidebar list to view conversation history.</p>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('js'); ?>
<script>
    function scrollToBottom() {
        const body = document.getElementById('adminChatBody');
        if (body) {
            body.scrollTop = body.scrollHeight;
        }
    }

    function handleAdminFileSelect(input) {
        if (input.files && input.files[0]) {
            document.getElementById('adminFileName').innerText = input.files[0].name;
            document.getElementById('adminAttachmentPreview').classList.remove('d-none');
        }
    }

    function removeAdminAttachment() {
        const input = document.getElementById('adminFileAttachment');
        if (input) input.value = '';
        document.getElementById('adminAttachmentPreview').classList.add('d-none');
    }

    document.addEventListener("DOMContentLoaded", function () {
        scrollToBottom();

        const form = document.getElementById('adminSendForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(form);
                const input = document.getElementById('adminMessageInput');
                const btn = document.getElementById('adminSendBtn');

                if (!input.value.trim() && !document.getElementById('adminFileAttachment').files.length) {
                    return;
                }

                btn.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    if (data.success) {
                        input.value = '';
                        removeAdminAttachment();
                        fetchAdminMessages();
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    form.submit();
                });
            });
        }

        <?php if($activeConversation): ?>
        function fetchAdminMessages() {
            fetch("<?php echo e(route('admin.chats.fetch', $activeConversation->id)); ?>", {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.messages) {
                    const body = document.getElementById('adminChatBody');
                    let html = '';
                    data.messages.forEach(msg => {
                        html += `
                            <div class="msg-wrapper ${msg.is_me ? 'me' : 'other'}">
                                <div class="msg-bubble">
                                    ${!msg.is_me ? `<div class="fw-bold font-12 mb-1 opacity-75">${msg.sender_name}</div>` : ''}
                                    ${msg.message ? `<div>${msg.message.replace(/\n/g, '<br>')}</div>` : ''}
                                    ${msg.attachment_url ? `<div><a href="${msg.attachment_url}" target="_blank" class="att-badge"><i class="fas fa-paperclip me-2"></i> Attachment</a></div>` : ''}
                                </div>
                                <div class="msg-info">${msg.created_at}</div>
                            </div>
                        `;
                    });
                    body.innerHTML = html;
                    scrollToBottom();
                }
            })
            .catch(e => console.log('Admin polling error:', e));
        }

        setInterval(fetchAdminMessages, 4000);
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views/backend/admin/chat/index.blade.php ENDPATH**/ ?>