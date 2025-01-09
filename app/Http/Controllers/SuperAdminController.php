<?php


// app/Http/Controllers/SuperAdminController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SuperAdminController extends Controller
{

    public function index()
    {
        echo "Test";
        die();
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function showInviteForm()
    {
        return view('superadmin.invite');
    }

    public function sendInvite(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'team_name' => 'required|string',
        ]);

        // Create a team
        $team = Team::create([
            'team_name' => $validated['team_name'],
            'super_admin_id' => auth()->id(),
        ]);

        // Generate invite token
        $invite = Invitation::create([
            'email' => $validated['email'],
            'team_id' => $team->id,
            'token' => Str::random(60),
            'expires_at' => now()->addMinutes(30),
        ]);

        // Send email invitation with token link
        Mail::to($validated['email'])->send(new InvitationEmail($invite));

        return back()->with('message', 'Invitation sent successfully!');
    }

    public function viewInvites()
    {
        $invites = Invitation::all();
        return view('superadmin.invites', compact('invites'));
    }
}
