<?php

namespace App\Model;

enum CourseStudent: string
{
    case ACTIVE = 'ACTIVE';
    case  COMPLETED = 'COMPLETED';
    case  CANCELED = 'CANCELED';
    case ARCHIVED = 'ARCHIVED';
    case ENROLLMENT = 'ENROLLMENT';
}