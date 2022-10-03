<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberMailRequest;
use App\Mail\MemberMail;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;

class MemberMailController extends Controller
{
    /**
     * Display the Member Mail Form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::select('id', 'first_name', 'last_name')->get();

        return view('admin.member_mail.index', compact('members'));
    }

    /**
     * Send Mail to the members.
     *
     * @param \App\Http\Requests\MemberMailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMail(MemberMailRequest $request)
    {
        $validatedData = $request->validated();
        $selectedOnly = $validatedData['member_type'] === "selected";

        $members = Member::select('id', 'first_name', 'last_name', 'email', 'phone')
            ->when($selectedOnly, function ($query) use ($validatedData) {
                $query->whereIn('id', $validatedData['member']);
            })
            ->get()
        ;

        foreach ($members as $member) {
            Mail::to($member->email)->send(new MemberMail([
                'subject' => $validatedData['subject'],
                'message' => $validatedData['content'],
                'firstName' => $member->first_name,
                'lastName' => $member->last_name,
                'email' => $member->email,
                'phone' => $member->phone,
            ]));
        }

        return redirect()->route('admin.member-mail.index')
            ->with(['type' => 'success', 'message' => __('Mail successfully Sent !!!')])
        ;
    }
}
