<?php

namespace App\Http\Controllers\Auth_Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\GenerateAdminToken;
use App\Services\Message\Email\EmailService;
use App\Services\Message\MessageService;
use App\Services\ValidateUserAdminService\ValidateAdminEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    //
    public function loginForm()
    {
        return view('admin_auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'exists:admins,email'],
            'password' => ['required', 'min:3', 'max:20'],
        ], $messages = [
            'email.required' => 'ایمیل خود را وارد کنید',
            'email.exists' => 'کاربری با ایمیل وارد شده وجود ندارد',
        ]);

        try {

            if ($admin = Admin::where(['email' => $request->email])->first()) {
                Auth::guard('admin')->login($admin, $request->remember);
                session()->flash('success', 'ورود موفقیت آمیز بود.');
                return redirect()->route('admin.dashboard');
            }
            session()->flash('error', 'اطلاعات ورود صحیح نمی باشد');
            return redirect()->route('admin.login.form');

            //            $code = GenerateAdminToken::generateAdminToken();
            //            $admin = Admin::where('email', $request->email)->first();
            //            $admin->code = $code;
            //            $admin->save();
            //            // l.v 1
            //            $emailService = new EmailService();
            //            $details = [
            //                'title' => 'کد  ورود به پنل میدیریت',
            //                'body' => $admin->code,
            //            ];
            //            $emailService->setDetails($details);
            //            $emailService->setFrom(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_ADDRESS'));
            //            $emailService->setSubject('کد ورود به پنل میدیریت');
            //            $emailService->setTo($admin->email);
            //            // l.v 2
            //            $messageService = new MessageService($emailService);
            //            $messageService->send();
            //
            //            session()->flash('success', 'کد فعال سازی به ایمیل ارسال شد');
            //            return redirect()->route('admin.validate.email.form');


        } catch (\Exception $ex) {
            return view('errors_custom.login_error', ['error' => $ex->getMessage()]);
        }

    }

    public function logOut(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        Auth::guard('admin')->logout();
        $admin->code = null;
        $admin->email_verified_at = null;
        $admin->remember_token = null;
        $admin->save();
        $request->session()->invalidate();
        return redirect()->route('admin.login.form');
    }

}
