<?php
require_once __DIR__.'/../src/enroll.php';
require_once __DIR__.'/../src/student.php';
require_once __DIR__.'/../src/course.php';
require_once __DIR__.'/../src/db.php';

function h($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

$message = '';

$students = getStudents();
$courses  = getCourses();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['sid'], $_POST['cid'])) {
    $result = registerEnrollment((int)$_POST['sid'], (int)$_POST['cid']);

    if ($result === 'success') {
        $message = '登録成功';
    } elseif ($result === 'duplicate') {
        $message = '既に登録済みです';
    } else {
        $message = '登録に失敗しました';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>履修登録</title>
</head>
<body>
<h2>履修登録</h2>

<?php if ($message !== ''): ?>
    <p><?= h($message) ?></p>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>学生</th>
        <?php foreach ($courses as $c): ?>
            <th><?= h($c['course_code']) ?> <?= h($c['title']) ?></th>
        <?php endforeach; ?>
    </tr>

    <?php foreach ($students as $s): ?>
        <tr>
            <td><?= h($s['first_name'] . ' ' . $s['last_name']) ?> (<?= h($s['student_id']) ?>)</td>
            <?php foreach ($courses as $c): ?>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="sid" value="<?= h($s['student_id']) ?>">
                        <input type="hidden" name="cid" value="<?= h($c['course_id']) ?>">
                        <button type="submit">登録</button>
                    </form>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php">← ホームへ戻る</a></p>
</body>
</html>
