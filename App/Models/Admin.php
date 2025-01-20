<?php
namespace App\Models;

use App\Models\User;
use App\Models\UserRepository;
use App\Models\CoursRepository;
use App\Models\Category;
use App\Models\Tag;

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


   

    public function deleteCourse($courseId) {
        return CoursRepository::getAllCourses($courseId);
    }

    public function addCategorie($categoryName) {
        $tagInstance = new Category();
        return $tagInstance->addCategorie(['nom'=>$categoryName]);
    }
   

    public function deleteCategory($categoryId) {
        $tagInstance = new Category();
        return $tagInstance->deleteCategory($categoryId);
    }

    public function addTag($tagName) {
        $tagInstance = new Tag();
        return $tagInstance->addTag(['nom' => $tagName]);
    }

    public function deleteTag($tagId) {
        $tagInstance = new Tag();
        return $tagInstance->deleteTag($tagId);
    }

    public function addTagsInBulk($tags) {
        $tagInstance = new Tag();
        $results = [];
        foreach ($tags as $tagName) {
            $results[] = $tagInstance->addTag(['nom' => $tagName]);
        }
        return $results;
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
        return $this->getUsersByRoleAndStatus(self::ROLE_ENSEIGNANT, self::STATUS_PENDING);
    }

    public function getAllUsers() {
        return UserRepository::getAllUsers();
    }

    public function getAllCourses() {
        $courseInstance= new CoursRepository();
        return $courseInstance->getAllCourses();
        }

    public function getAllCategories() {
        $tagInstance = new Category();
        return $tagInstance->showCategorie();
    }

    public function getAllTags() {
        $tagInstance = new Tag();
        return $tagInstance->showTag();
    }
    public function updateTag($tagId, $newTagName) {
        $tagInstance = new Tag();
        $data = ['nom' => $newTagName]; 
        return $tagInstance->updateTags($tagId, $data); 
}
public function updateCategory($categoryId, $newCategoryName) {
    $tagInstance = new Category();
    $data = ['nom' => $newCategoryName]; 
    return $tagInstance->updateCategorie($categoryId, $data); 
}

}