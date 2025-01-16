<?php
namespace App\Models;

use App\Core\Model;

class TeacherModel extends Model {
    protected $table = 'teachers';
    protected $fillable = ['name', 'email', 'specialization'];

    public function getCourses($teacherId) {
        return (new Course())->where('enseignant_id', $teacherId)->get();
    }

    public function createCourse($teacherId, $data) {
        $data['enseignant_id'] = $teacherId;
        return (new Course())->createCourse($data);
    }

    public function updateCourse($courseId, $data) {
        return (new Course())->updateCourse($courseId, $data);
    }

    public function deleteCourse($courseId) {
        return (new Course())->deleteCourse($courseId);
    }

    public function getTeacher($teacherId) {
        return $this->find($teacherId);
    }

    public function updateTeacher($teacherId, $data) {
        return $this->update($teacherId, $data);
    }

    public function deleteTeacher($teacherId) {
        return $this->delete($teacherId);
    }
}