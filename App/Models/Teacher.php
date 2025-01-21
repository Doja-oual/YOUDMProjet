<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserRepository;
use App\Models\CoursRepository;

class Teacher extends User
{
    public function addCourse(array $courseData): bool
    {
        if (empty($courseData)) {
            throw new \InvalidArgumentException("Les données du cours ne peuvent pas être vides.");
        }

        return CoursRepository::addCourse($courseData);
    }

    public function updateCourse(int $courseId, array $courseData): bool
    {
        if ($courseId <= 0) {
            throw new \InvalidArgumentException("L'ID du cours doit être un entier positif.");
        }

        return CoursRepository::updateCourse($courseId, $courseData);
    }

    public function deleteCourse(int $courseId): bool
    {
        if ($courseId <= 0) {
            throw new \InvalidArgumentException("L'ID du cours doit être un entier positif.");
        }

        return CoursRepository::deleteCourse($courseId);
    }

    public function getMyCourses(): array
    {
        return CoursRepository::getCoursesByTeacher($this->getId());
    }

    public function getCourseStatistics(int $courseId): array
    {
        if ($courseId <= 0) {
            throw new \InvalidArgumentException("L'ID du cours doit être un entier positif.");
        }

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
        if (empty($profileData)) {
            throw new \InvalidArgumentException("Les données du profil ne peuvent pas être vides.");
        }

        return UserRepository::updateUser($this->getId(), $profileData);
    }

    public function getProfile(): array
    {
        return UserRepository::getUserById($this->getId());
    }
}