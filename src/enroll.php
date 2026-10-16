<?php
require_once __DIR__.'/db.php';

/* REGISTER */
function registerEnrollment(int $studentId, int $courseId): string {
    try {
        $sql = "INSERT INTO enrollment (student_id,course_id)
                VALUES (:sid,:cid)";
        $stmt = query($sql, [':sid'=>$studentId, ':cid'=>$courseId]);

        return $stmt->rowCount() > 0 ? 'success' : 'error';
    } catch (PDOException $e) {
        // MySQL duplicate key error
        if ((int)$e->getCode() === 23000) {
            return 'duplicate';
        }
        return 'error';
    }
}

/* LIST ENROLLMENTS */
function getEnrollmentsByStudent(int $studentId): array {
    $sql = "SELECT e.enrollment_id,c.course_code,c.title,e.registration_date,e.grade
            FROM enrollment e
            JOIN course c ON e.course_id=c.course_id
            WHERE e.student_id=:sid";
    $stmt = query($sql, [':sid'=>$studentId]);
    return $stmt->fetchAll();
}
?>
