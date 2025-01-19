<?php
namespace App\Models;

use App\Models\User;
use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\CategoryRepository;
use App\Models\TagRepository;

class Admin extends User {

    public function __construct($id, $username, $email, $passwordHash, $role, $dateInscription = null, $photoProfil = null, $bio = null, $pays = null, $langueId = null, $statutId = null) {
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

    public function showDashboard() {
        return "Tableau de bord Administrateur";
    }

    public function validateTeacherAccount($teacherId) {
        return UserRepository::activateUser($teacherId);
    }

    public function suspendUser($userId) {
        return UserRepository::suspendUser($userId);
    }

    public function deleteUser($userId) {
        return UserRepository::deleteUser($userId);
    }

    public function addCourse($courseData) {
        return CoursRepository::addCourse($courseData);
    }

    public function updateCourse($courseId, $courseData) {
        return CoursRepository::updateCourse($courseId, $courseData);
    }

    public function deleteCourse($courseId) {
        return CoursRepository::deleteCourse($courseId);
    }

    public function addCategory($categoryName) {
        return CategoryRepository::addCategory($categoryName);
    }

    public function deleteCategory($categoryId) {
        return CategoryRepository::deleteCategory($categoryId);
    }

    public function addTag($tagName) {
        return TagRepository::addTag($tagName);
    }

    public function deleteTag($tagId) {
        return TagRepository::deleteTag($tagId);
    }

    public function addTagsInBulk($tags) {
        return TagRepository::addTagsInBulk($tags);
    }

    public function getGlobalStatistics() {
        return [
            'total_courses' => CoursRepository::getTotalCourses(),
            'courses_by_category' => CategoryRepository::getCoursesByCategory(),
            'most_popular_course' => CoursRepository::getMostPopularCourse(),
            'top_3_teachers' => UserRepository::getTopTeachers(3)
        ];
    }

    public function getPendingTeachers() {
        return UserRepository::getUsersByRoleAndStatus(User::ROLE_ENSEIGNANT, User::STATUS_PENDING);
    }

    public function getAllUsers() {
        return UserRepository::getAllUsers();
    }

    public function getAllCourses() {
        return CoursRepository::getAllCourses();
    }

    public function getAllCategories() {
        return CategoryRepository::getAllCategories();
    }

    public function getAllTags() {
        return TagRepository::getAllTags();
    }
}