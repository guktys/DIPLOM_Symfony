<?php

namespace App\Service\Courses;

use App\Entity\CoursesStudent;
use App\Model\CourseStudent;
use App\Repository\CoursesRepository;
use App\Repository\CoursesStudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CoursesAppointmentSaveHandler
{
    private CoursesRepository $courseRepository;
    private CoursesStudentRepository $courseStudentRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        CoursesRepository        $courseRepository,
        CoursesStudentRepository $courseStatusRepository,
        EntityManagerInterface   $entityManager
    )
    {
        $this->courseRepository = $courseRepository;
        $this->courseStudentRepository = $courseStatusRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke($request, $user)
    {
        $courseId = $request->get('course');
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);
        $courseStudent = $this->courseStudentRepository->findOneBy(['user' => $user->getId(), 'kourse' => $course->getId()]);
        if ($courseStudent) {
            return new JsonResponse(['success' => 'isInBase', 'message' => 'Ви вже записані на цей курс!']);
        } else {
            $courseStudent = new CoursesStudent();
            $courseStudent->setKourse($course);
            $courseStudent->setUser($user);
            $courseStudent->setStartTime($course->getStartTime());
            $courseStudent->setEndTime($course->getEndTime());
            $courseStudent->setStatus(CourseStudent::ENROLLMENT->value);

            $this->entityManager->persist($courseStudent);
            $this->entityManager->flush();
            if ($courseStudent->getId()) {
                return new JsonResponse(['success' => true, 'message' => 'Ви успішно записані!']);
            } else {
                return new JsonResponse(['success' => false, 'message' => 'Помилка, спробуйте будь ласка знову пізніше']);
            }
        }
    }
}