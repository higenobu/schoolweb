<?php
require_once __DIR__.'/../src/enroll.php';
require_once __DIR__.'/../src/student.php';
require_once __DIR__.'/../src/course.php';
require_once __DIR__.'/../src/db.php';

$students = getStudents();
$courses  = getCourses();

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['sid']) && isset($_POST['cid'])) {
    $sid = (int)$_POST['sid'];
    $cid = (int)$_POST['cid'];
    $ok = registerEnrollment($sid,$cid);
    echo "<p>{$ok ? '登録成功' : '既に登録済みまたはエラー'}</p>";
}
?>
<!DOCTYPE html>
<html lang="ja"><head><meta charset="utf-8"><title>履修登録</title></head>
<body>
<h2>履修登録</h2>
<table border="1" cellpadding="5">
<tr><th>学生</th><th>科目</th><th>登録</th></tr>
<?php foreach ($students as $s): ?>
<tr>
<td><?= $s['first_name'].$s['last_name'] ?> (<?= $s['student_id'] ?>)</td>
<?php foreach ($courses as $c): ?>
<td><?= $c['course_code'].$c['title'] ?></td>
<td>
<form method="post" style="display:inline;">
<input type="hidden" name="sid" value="<?=$s['student_id']?>">
<input type="hidden" name="cid" value="<?=$c['course_id']?>">
<button type="submit">登録</button>
</form>
</td>
<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</table>
<p><a href="index.php">← ホームへ戻る</a></p>
</body></html>
