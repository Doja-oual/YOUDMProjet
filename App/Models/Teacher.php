
<?php
class Teacher extends User {

public function addCourse($courseData) {
    return CoursRepository::addCourse($courseData);
}

public function updateCourse($courseId, $courseData) {
    return CoursRepository::updateCourse($courseId, $courseData);
}

public function deleteCourse($courseId) {
    return CoursRepository::deleteCourse($courseId);
}

public function getMyCourses() {
    return CoursRepository::getCoursesByTeacher($this->getId());
}

public function getCourseStatistics($courseId) {
    return CoursRepository::getCourseStatistics($courseId);
}

public function getTeacherStatistics() {
    return [
        'total_courses' => CoursRepository::getTotalCoursesByTeacher($this->getId()),
        'total_students' => CoursRepository::getTotalStudentsByTeacher($this->getId()),
        'most_popular_course' => CoursRepository::getMostPopularCourseByTeacher($this->getId())
    ];
}

public function updateProfile($profileData) {
    return UserRepository::updateUser($this->getId(), $profileData);
}

public function getProfile() {
    return UserRepository::getUserById($this->getId());
}
}