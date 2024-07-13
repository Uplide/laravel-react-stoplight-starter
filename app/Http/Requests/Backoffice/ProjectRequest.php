<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Yetkilendirme kontrolünü burada yapabilirsiniz
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'required|integer|exists:companies,id',
            'cover' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'tasks' => 'nullable|array',
            'tasks.*.title' => 'required_with:tasks|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.cover' => 'nullable|string',
            'tasks.*.start_date' => 'nullable|date',
            'tasks.*.end_date' => 'nullable|date|after_or_equal:tasks.*.start_date',
            'tasks.*.sort' => 'required_with:tasks|integer',
            'tasks.*.status' => 'required_with:tasks|in:pending,in_process,completed',
            'tasks.*.questions' => 'nullable|array',
            'tasks.*.questions.*.title' => 'required_with:tasks.*.questions|string|max:255',
            'tasks.*.questions.*.description' => 'required_with:tasks.*.questions|string',
            'tasks.*.questions.*.option_type' => 'required_with:tasks.*.questions|in:text,image,text_video,text_image,video,radio,checkbox',
            'tasks.*.questions.*.sort' => 'required_with:tasks.*.questions|integer',
            'tasks.*.questions.*.options' => 'nullable|array',
            'tasks.*.questions.*.options.*.option_name' => 'required_with:tasks.*.questions.*.options|string|max:255',
            'tasks.*.questions.*.options.*.option_value' => 'required_with:tasks.*.questions.*.options|string|max:255',
            'tasks.*.questions.*.options.*.sort' => 'required_with:tasks.*.questions.*.options|integer',
            'announcements' => 'nullable|array',
            'announcements.*.title' => 'required_with:announcements|string|max:255',
            'announcements.*.description' => 'nullable|string',
            'announcements.*.cover' => 'nullable|string',
            'announcements.*.sort' => 'required_with:announcements|integer',
            'announcements.*.status' => 'required_with:announcements|in:pending,in_process,completed',
            'target_groups' => 'required|array',
            'target_groups.*.title' => 'required|string|max:255',
            'target_groups.*.description' => 'nullable|string',
            'target_groups.*.ses' => 'required|in:HIGH,MIDDLE,IMMIGRANT_MINORITY,BELOW_POVERTY_LINE',
            'target_groups.*.target_group_users' => 'nullable|array',
            'target_groups.*.target_group_users.*.user.user_id' => 'nullable|integer|exists:users,id',
            'target_groups.*.target_group_users.*.user.name' => 'nullable|string|max:255',
            'target_groups.*.target_group_users.*.user.surname' => 'nullable|string|max:255',
            'target_groups.*.target_group_users.*.user.email' => 'nullable|email|max:255',
            'target_groups.*.target_group_users.*.user.phone' => 'nullable|string|max:20',
            'target_groups.*.target_group_users.*.user.gender' => 'nullable|in:MALE,FEMALE,NOT_SPECIFIED',
            'target_groups.*.target_group_users.*.user.age' => 'nullable|integer|min:0',
            'target_groups.*.target_group_users.*.user.ses' => 'nullable|in:HIGH,MIDDLE,IMMIGRANT_MINORITY,BELOW_POVERTY_LINE',
            'project_mods' => 'nullable|array',
            'project_mods.*.mod.mod_id' => 'nullable|integer|exists:users,id',
            'project_mods.*.mod.name' => 'required|string|max:255',
            'project_mods.*.mod.surname' => 'required|string|max:255',
            'project_mods.*.mod.email' => 'required|email|max:255',
            'project_mods.*.mod.phone' => 'required|string|max:20',
            'project_observers' => 'nullable|array',
            'project_observers.*.observer.observer_id' => 'nullable|integer|exists:users,id',
            'project_observers.*.observer.name' => 'required|string|max:255',
            'project_observers.*.observer.surname' => 'required|string|max:255',
            'project_observers.*.observer.email' => 'required|email|max:255',
            'project_observers.*.observer.phone' => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Proje başlığı gereklidir.',
            // Diğer hata mesajlarını burada belirtebilirsiniz.
        ];
    }
}
