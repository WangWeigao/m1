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
        $tm_email->to = 'emailuser001@163.com';
        $tm_email->subject = '测试邮件' . '-' . mt_rand() . '-' . $this->user->email;
        // $mailer->send('emails.test', ['user' => $this->user], function ($m) use ($tm_email) {
        $mailer->send('emails.report', ['root' => $request->root()], function ($m) use ($tm_email) {
            $m->from($tm_email->from, '音熊');
            $m->to($tm_email->to);
            $m->subject($tm_email->subject);
        });
    }
}
