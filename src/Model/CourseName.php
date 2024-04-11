<?php

declare(strict_types=1);

namespace App\Model;

enum CourseName: string
{
    case MANICURE = 'Курс манікюра';
    case PEDICURE = 'Курс педикюру';
    case NAIL_ART = 'Курс нейл-арта';
    case ELECTRO_EPIL = 'Електро епіляції';
}