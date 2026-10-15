<?php
require_once __DIR__.'/../src/enroll.php';
require_once __DIR__.'/../src/grade.php';
require_once __DIR__.'/../src/db.php';

// 表示：学生ごとの履修一覧
$students = getStudents();
?>
<!DOCTYPE html>
<html lang="ja"><head><meta charset="utf-8"><title>成績入力</title></head>
<body>
<h2>成績評価</h2>

<?php foreach ($students as $s): ?>
<table border="1" cellpadding="5">
<tr><th>科目コード</th><th>科目名</th><th>現在の成績</th><th>採点</th></tr>
<?php
$enrolls = getEnrollmentsByStudent($s['student_id']);
foreach ($enrolls as $e):
    $sql = "SELECT c.course_code,c.title FROM course c WHERE c.course_id=:cid";
    $r = query($sql, [':cid'=>$e['course_id']]);
    $c = $r->fetch();
?>
<tr>
<td><?= htmlspecialchars($c['course_code']) ?></td>
<td><?= htmlspecialchars($c['title']) ?></td>
<td><?= $e['grade'] ?? '未入力' ?></td>
<td>
<form method="post" style="display:inline;">
<input type="hidden" name="eid" value="<?=$e['enrollment_id']?>">
<input type="number" step="0.01" name="grade" placeholder="0〜100">
<button type="submit">保存</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endforeach; ?>

<p><a href="index.php">← ホームへ戻る</a></p>
</body></html>
