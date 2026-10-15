<?php
require_once __DIR__.'/db.php';

/* CREATE */
function addCourse(array $data): int {
    $sql = "INSERT INTO course (course_code,title,credits,semester,instructor_id)
            VALUES (:code,:title,:cred,:sem,:inst)";
    $stmt = query($sql, $data);
    return (int)$stmt->rowCount();
}

/* LIST */
function getCourses(): array {
    $sql = "SELECT c.course_id,c.course_code,c.title,c.credits,c.semester,CONCAT(i.first_name,' ',i.last_name) AS instructor
            FROM course c
            LEFT JOIN instructor i ON c.instructor_id=i.instructor_id";
    $stmt = query($sql);
    return $stmt->fetchAll();
}

/* UPDATE / DELETE 同様に実装可能 */
?>
