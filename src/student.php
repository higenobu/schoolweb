<?php
require_once __DIR__.'/db.php';

/* CREATE */
function addStudent(array $data): int {
    $sql = "INSERT INTO student (first_name,last_name,birth_date,email,department_id,status)
            VALUES (:fn,:ln,:bd,:em,:did,:st)";
    $stmt = query($sql, $data);
    return (int)$stmt->rowCount();
}

/* READ ALL */
function getStudents(): array {
    $sql = "SELECT s.student_id, s.first_name, s.last_name, s.email, s.status,
                   d.dept_name
            FROM student s
            JOIN department d USING(department_id)";
    $stmt = query($sql);
    return $stmt->fetchAll();
}

/* UPDATE */
function updateStudent(int $id, array $data): bool {
    $sql = "UPDATE student SET first_name=:fn,last_name=:ln,birth_date=:bd,
                                      email=:em,department_id=:did,status=:st
            WHERE student_id=:id";
    $stmt = query($sql, array_merge($data, [':id'=>$id]));
    return $stmt->rowCount() > 0;
}

/* DELETE */
function deleteStudent(int $id): bool {
    $sql = "DELETE FROM student WHERE student_id=:id";
    $stmt = query($sql, [':id'=>$id]);
    return $stmt->rowCount() > 0;
}
?>
