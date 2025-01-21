<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\Category;
use App\Models\Tag;

class Teacher extends User
{
    public function __construct(
        int $id,
        string $username,
        string $email,
        string $passwordHash,
        string $role,
        ?string $dateInscription ,
        ?string $photoProfil ,
        ?string $bio ,
        ?string $pays ,
        ?int $langueId ,
        ?int $statutId 
    ) {
        parent::__construct(
            $id,
            $username,
            $email,
            $passwordHash,
            $role,
            $dateInscription,
            $photoProfil,
            $bio,
            $pays,
            $langueId,
            $statutId
        );
    }

    public function showDashboard(): string
    {
        return "Tableau de bord Enseignant";
    }

    public function addCourse(array $courseData): bool
    {
        return CoursRepository::createCourse($courseData);
    }

    public function updateCourse(int $courseId, array $courseData): bool
    {
        return CoursRepository::updateCourse($courseId, $courseData);
    }

    public function deleteCourse(int $courseId): bool
    {
        return CoursRepository::deleteCourse($courseId);
    }

    public function getMyCourses(): array
    {
        return CoursRepository::getCoursesByTeacher($this->getId());
    }

    public function getCourseStatistics(int $courseId): array
    {
        return CoursRepository::getCourseStatistics($courseId);
    }

    public function getTeacherStatistics(): array
    {
        return [
            'total_courses' => CoursRepository::getTotalCoursesByTeacher($this->getId()),
            'total_students' => CoursRepository::getTotalStudentsByTeacher($this->getId()),
            'most_popular_course' => CoursRepository::getMostPopularCourseByTeacher($this->getId())
        ];
    }

    public function updateProfile(array $profileData): bool
    {
        return UserRepository::updateUser($this->getId(), $profileData);
    }

    public function getProfile(): array
    {
        return UserRepository::getUserById($this->getId());
    }

      public function getLangueUser(){
        return UserRepository::getLangue($this->getId());


      }
}