<?php

namespace App\Service\Courses;

use App\Model\CourseStatus;
use App\Repository\CoursesRepository;
use App\Repository\CoursesStudentRepository;

class CoursesAppointmentHandler
{
    private CoursesRepository $courseRepository;
    private CoursesStudentRepository $courseStudentRepository;

    public function __construct(
        CoursesRepository        $courseRepository,
        CoursesStudentRepository $courseStatusRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->courseStudentRepository = $courseStatusRepository;

    }

    public function __invoke($request): array
    {
        $coursesInfo = [];
        if ($request->query->has('type')) {
            $courseType = $request->query->get('type');
            $courses = $this->courseRepository->findBy(['status' => CourseStatus::ENROLLMENT->value, 'courseType' => $courseType]);
        } else {
            $courses = $this->courseRepository->findBy(['status' => CourseStatus::ENROLLMENT->value]);
        }
        foreach ($courses as $course) {
            $coursesInfo[$course->getId()] = $course->getCoursesInfo();
        }
        return [
            'courses' => $courses,
            'coursesInfos' => $coursesInfo,
        ];
    }
}