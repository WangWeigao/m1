<?php
namespace App\Http\Models;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class TMEmail extends Controller
{
    public $from;   // 发件人邮箱
    public $to;     // 收件人邮箱
    public $cc;     // 抄送
    public $attach; // 附件
    public $subject;    // 主题
    public $content;    // 内容
}
