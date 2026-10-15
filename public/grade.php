<?php
require_once __DIR__.'/../src/helpers.php';
require_once __DIR__.'/../src/student.php';
require_once __DIR__.'/../src/enroll.php';
require_once __DIR__.'/../src/grade.php';

$message = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['eid'], $_POST['grade']) && is_numeric($_POST['grade'])) {
    $grade = (float)$_POST['grade'];
    // enrollment.grade は DECIMAL(4,2) のため上限は 99.99
    if ($grade >= 0 && $grade <= 99.99) {
        setGrade((int)$_POST['eid'], $grade);
        $message = '成績を保存しました';
    } else {
        $message = '成績は 0〜99.99 で入力してください';
    }
}

$students = getStudents();
?>
<!DOCTYPE html>
<html lang="ja"><head><meta charset="utf-8"><title>成績入力</title></head>
<body>
<h2>成績評価</h2>
<?php if ($message !== ''): ?><p><?= h($message) ?></p><?php endif; ?>

<?php foreach ($students as $s): ?>
<h3><?= h($s['first_name'].' '.$s['last_name']) ?></h3>
<table border="1" cellpadding="5">
<tr><th>科目コード</th><th>科目名</th><th>現在の成績</th><th>採点</th></tr>
<?php foreach (getEnrollmentsByStudent((int)$s['student_id']) as $e): ?>
<tr>
<td><?= h($e['course_code']) ?></td>
<td><?= h($e['title']) ?></td>
<td><?= h($e['grade'] ?? '未入力') ?></td>
<td>
<form method="post" style="display:inline;">
<input type="hidden" name="eid" value="<?= h($e['enrollment_id']) ?>">
<input type="number" step="0.01" min="0" max="99.99" name="grade" placeholder="0〜99.99">
<button type="submit">保存</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endforeach; ?>

<p><a href="index.php">← ホームへ戻る</a></p>
</body></html>
