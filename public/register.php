<?php
require_once __DIR__.'/../src/helpers.php';
require_once __DIR__.'/../src/enroll.php';
require_once __DIR__.'/../src/student.php';
require_once __DIR__.'/../src/course.php';

$students = getStudents();
$courses  = getCourses();
$message  = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['sid'], $_POST['cid'])) {
    try {
        $ok = registerEnrollment((int)$_POST['sid'], (int)$_POST['cid']);
        $message = $ok ? '登録成功' : '既に登録済みです';
    } catch (PDOException $e) {
        $message = '登録に失敗しました';
    }
}
?>
<!DOCTYPE html>
<html lang="ja"><head><meta charset="utf-8"><title>履修登録</title></head>
<body>
<h2>履修登録</h2>
<?php if ($message !== ''): ?><p><?= h($message) ?></p><?php endif; ?>
<table border="1" cellpadding="5">
<tr><th>学生</th><th>科目</th><th>登録</th></tr>
<?php foreach ($students as $s): ?>
<?php foreach ($courses as $c): ?>
<tr>
<td><?= h($s['first_name'].' '.$s['last_name']) ?> (<?= h($s['student_id']) ?>)</td>
<td><?= h($c['course_code'].' '.$c['title']) ?></td>
<td>
<form method="post" style="display:inline;">
<input type="hidden" name="sid" value="<?= h($s['student_id']) ?>">
<input type="hidden" name="cid" value="<?= h($c['course_id']) ?>">
<button type="submit">登録</button>
</form>
</td>
</tr>
<?php endforeach; ?>
<?php endforeach; ?>
</table>
<p><a href="index.php">← ホームへ戻る</a></p>
</body></html>
