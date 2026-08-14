@component('mail::message')
# New User Registration - Approval Required

A new user has registered and requires your approval to access the system.

## User Information

**Name:** {{ $user->fullname }}
**Email:** {{ $user->email }}
**Phone:** {{ $user->phone ?? 'Not provided' }}
**Registration Date:** {{ $user->created_at->format('d/m/Y H:i:s') }}

## Action Required

Please review this registration and approve or reject it by clicking the link below:

@component('mail::button', ['url' => route('admin.users.approval-panel')])
View Approval Panel
@endcomponent

Alternatively, you can use this link:
{{ route('admin.users.approval-panel') }}

---

**Note:** This user will not be able to login until their registration is approved by an administrator.

---

If you didn't expect this email, you can ignore it.

@endcomponent
