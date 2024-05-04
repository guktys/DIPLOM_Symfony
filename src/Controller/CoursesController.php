<?php

namespace App\Controller;

use App\Entity\CoursesStudent;
use App\Model\CourseStatus;
use App\Model\CourseStudent;
use App\Repository\CoursesRepository;
use App\Repository\CoursesStudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
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

    #[Route('/courses', name: 'courses')]
    public function courses()
    {
        return $this->render('courses.html.twig', [
        ]);
    }

    #[Route('/courses_appointment', name: 'courses_appointment')]
    public function coursesAppointment(Request $request)
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
        return $this->render('courses_appointment.html.twig', [
            'courses' => $courses,
            'coursesInfos' => $coursesInfo,
        ]);
    }

    #[Route('/courses_appointment_save', name: 'courses_appointment_save')]
    public function coursesAppointmentSave(Request $request, EntityManagerInterface $entityManager)
    {
        $courseId = $request->get('course');
        $user = $this->getUser();
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

            $entityManager->persist($courseStudent);
            $entityManager->flush();
            if ($courseStudent->getId()) {
                return new JsonResponse(['success' => true, 'message' => 'Ви успішно записані!']);
            } else {
                return new JsonResponse(['success' => false, 'message' => 'Помилка, спробуйте будь ласка знову пізніше']);
            }
        }
    }
}