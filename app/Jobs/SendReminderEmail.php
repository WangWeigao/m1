<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\StudentUser;
use App\Http\Models\TMEmail;
use Illuminate\Http\Request;


class SendReminderEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StudentUser $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer, Request $request)
    {
        $tm_email = new TMEmail;
        $tm_email->from = 'emailuser001@163.com';
        // $tm_email->to = $this->user->email;
        // $tm_email->to = '168792316@qq.com'; // 董扬的QQ邮箱
        $tm_email->to = 'wangweigao@gmail.com';
        // $tm_email->cc = 'wangweigao@gmail.com';

        $tm_email->subject = '成绩报告(推送家长)' . '-' . mt_rand() . '-' . $this->user->email;
        // $mailer->send('emails.test', ['user' => $this->user], function ($m) use ($tm_email) {
        $mailer->send('emails.mail-report-new', ['root' => $request->root()], function ($m) use ($tm_email) {
            $m->from($tm_email->from, '音熊');
            $m->to($tm_email->to);
            // $m->cc($tm_email->cc);
            $m->subject($tm_email->subject);
        });
    }
}
