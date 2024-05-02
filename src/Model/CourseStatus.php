<?php

namespace App\Model;

enum CourseStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case  COMPLETED = 'COMPLETED';
    case  CANCELED = 'CANCELED';
    case ARCHIVED = 'ARCHIVED';
    case ENROLLMENT = 'ENROLLMENT';
}