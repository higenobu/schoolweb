<?php
require_once __DIR__.'/db.php';

/* SET GRADE */
function setGrade(int $enrollmentId, float $grade): bool {
    $sql = "UPDATE enrollment SET grade=:g WHERE enrollment_id=:eid";
    $stmt = query($sql, [':g'=>$grade, ':eid'=>$enrollmentId]);
    return $stmt->rowCount() > 0;
}
?>
