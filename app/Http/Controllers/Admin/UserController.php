<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Mail\UserApprovalMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);
        return redirect()->route('admin.users.show', $user)->with('success', 'User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted');
    }

    public function approvalPanel()
    {
        $pendingUsers = User::where('is_approved', false)->paginate(10);
        $approvedUsers = User::where('is_approved', true)->paginate(10);
        
        return view('admin.users.approval-panel', compact('pendingUsers', 'approvedUsers'));
    }

    public function approve(User $user)
    {
        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        try {
            Mail::to($user->email)->send(new UserApprovalMail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Approval email error: ' . $e->getMessage());
        }

        return back()->with('success', 'User approved and notified');
    }

    public function reject(User $user, Request $request)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        $user->update([
            'is_approved' => false,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'User rejected');
    }
}
