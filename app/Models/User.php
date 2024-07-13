<?php

namespace App\Models;

use App\Modules\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'phone_code',
        'gender',
        'role',
        'birthday',
        'ses',
        'is_email_verify',
        'is_phone_verify',
        'email_verify_code',
        'phone_verify_code',
        'auth_verify_code',
        'email_verify_date_time',
        'phone_verify_date_time',
        'auth_verify_date_time',
    ];

    /**
     * Guard for the model
     *
     * @var string
     */
    protected $guard = 'user-api';

    // Gerekli metodları tanımlayalım
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $hidden = [
        'password',
        'remember_token',
        'email_verify_code',
        'phone_verify_code',
        'auth_verify_code',
        'email_verify_date_time',
        'phone_verify_date_time',
        'auth_verify_date_time',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function targetGroups()
    {
        return $this->belongsToMany(TargetGroup::class, 'target_group_users');
    }

    public function userQuestionAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }


    public function setAuthVerifyCode($code)
    {
        $this->auth_verify_code = $code;
        $this->auth_verify_time = Carbon::now()->addMinutes(2);
        $this->save();
    }

    public function setPhoneVerifyCode($code)
    {
        $this->phone_verify_code = $code;
        $this->phone_verify_time = Carbon::now()->addMinutes(2);
        $this->save();
    }

    public function setEmailVerifyCode($code)
    {
        $this->email_verify_code = $code;
        $this->email_verify_time = Carbon::now()->addMinutes(2);
        $this->save();
    }

    public static function makeAuthVerifyCode()
    {
        $code = Helper::makeId(4, true);
        if (User::where("auth_verify_code", $code)->first()) {
            return User::makeAuthVerifyCode()();
        }

        return $code;
    }

    public static function makeEmailVerifyCode()
    {
        $code = Helper::makeId(4, true);
        if (User::where("email_verify_code", $code)->first()) {
            return User::makeEmailVerifyCode()();
        }

        return $code;
    }

    public static function makePhoneVerifyCode()
    {
        $code = Helper::makeId(4, true);
        if (User::where("email_verify_code", $code)->first()) {
            return User::makePhoneVerifyCode()();
        }

        return $code;
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_users', 'user_id', 'project_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function getProjectsCountAttribute()
    {
        return $this->projects()->count();
    }

    public function getCompletedProjectsCountAttribute()
    {
        return $this->projects()->wherePivot('status', 'completed')->count();
    }


    public function completedTasks()
    {
        return $this->belongsToMany(Task::class, 'user_question_answers', 'user_id', 'task_id')
            ->wherePivot('status', 'completed');
    }

    public function getCompletedTasksCountAttribute()
    {
        return $this->completedTasks()->count();
    }
}
