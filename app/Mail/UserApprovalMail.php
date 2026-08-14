<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserApprovalMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $status, // 'approved' or 'rejected'
        public ?string $rejectionReason = null
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved' 
            ? 'Tài khoản của bạn đã được phê duyệt'
            : 'Tài khoản của bạn bị từ chối';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-approval',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
