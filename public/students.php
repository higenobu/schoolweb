<?php
require_once __DIR__.'/../src/student.php';
require_once __DIR__.'/../src/db.php';

$students = getStudents();
?>
<!DOCTYPE html>
<html lang="ja">
<head><meta charset="utf-8"><title>学生一覧</title></head>
<body>
<h2>学生情報管理</h2>

<table border="1" cellpadding="5">
<tr>
<th>ID</th><th>氏名</th><th>メール</th><th>所属</th><th>状態</th><th>操作</th>
</tr>
<?php foreach ($students as $s): ?>
<tr>
<td><?= $s['student_id'] ?></td>
<td><?= htmlspecialchars($s['first_name'].$s['last_name']) ?></td>
<td><?= htmlspecialchars($s['email']) ?></td>
<td><?= htmlspecialchars($s['dept_name']) ?></td>
<td><?= $s['status'] ?></td>
<td>
<form method="post" action="students.php?op=del&id=<?=$s['student_id']?>">
<button type="submit" onclick="return confirm('削除しますか？');">削除</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>

<hr/>
<h3>新規登録</h3>
<form method="post" action="students.php?op=add">
<label>名前: <input name="fn"></label><br>
<label>姓: <input name="ln"></label><br>
<label>誕生日: <input type="date" name="bd"></label><br>
<label>メール: <input name="em"></label><br>
<label>所属コード: <input name="did"></label><br>
<button type="submit">追加</button>
</form>

<?php
if (isset($_GET['op'])) {
    if ($_GET['op']==='del' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        deleteStudent($id);
        echo "<p>学生(ID {$id}) を削除しました。</p>";
    } elseif ($_GET['op']==='add') {
        $data = [
            'fn' => $_POST['fn'],
            'ln' => $_POST['ln'],
            'bd' => $_POST['bd'],
            'em' => $_POST['em'],
            'did'=> (int)$_POST['did'],
            'st' => '在学'
        ];
        addStudent($data);
        echo "<p>学生を追加しました。</p>";
    }
}
?>
<p><a href="index.php">← ホームへ戻る</a></p>
</body>
</html>
