<?php

namespace App\Enums;

enum RegisterQuestionTypes: string
{
    case SINGLE_SELECT = 'single_select';
    case MULTIPLE_SELECT = 'multiple_select';
    case TEXT = 'text';
}
