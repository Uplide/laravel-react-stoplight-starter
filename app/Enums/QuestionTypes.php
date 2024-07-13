<?php

namespace App\Enums;

enum QuestionTypes: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case TEXT_VIDEO = 'text_video';
    case TEXT_IMAGE = 'text_image';
    case VOICE = 'voice';
    case TEXT_VOICE = 'text_voice';
    case VIDEO = 'video';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
}
