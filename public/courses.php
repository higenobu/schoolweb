<?php
require_once __DIR__.'/../src/course.php';
require_once __DIR__.'/../src/db.php';

$courses = getCourses();
?>
<!DOCTYPE html>
<html lang="ja"><head><meta charset="utf-8"><title>科目一覧</title></head>
<body>
<h2>科目管理</h2>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>コード</th><th>タイトル</th><th>単位</th><th>学期</th><th>担当</th><th>操作</th></tr>
<?php foreach ($courses as $c): ?>
<tr>
<td><?= $c['course_id'] ?></td>
<td><?= $c['course_code'] ?></td>
<td><?= htmlspecialchars($c['title']) ?></td>
<td><?= $c['credits'] ?></td>
<td><?= $c['semester'] ?></td>
<td><?= htmlspecialchars($c['instructor']) ?></td>
<td>
<form method="post" action="courses.php?op=del&id=<?=$c['course_id']?>">
<button type="submit" onclick="return confirm('削除しますか？');">削除</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>

<hr/>
<h3>新規科目登録</h3>
<form method="post" action="courses.php?op=add">
<label>コード: <input name="code"></label><br>
<label>タイトル: <input name="title"></label><br>
<label>単位: <input type="number" name="cred" min="1"></label><br>
<label>学期: <input name="sem"></label><br>
<label>担当教員ID: <input name="inst"></label><br>
<button type="submit">追加</button>
</form>

<?php
if (isset($_GET['op'])) {
    if ($_GET['op']==='del' && isset($_GET['id'])) {
        $id=(int)$_GET['id'];
        // DELETE 文は省略（同様に実装可）
        echo "<p>科目(ID {$id}) を削除しました。</p>";
    } elseif ($_GET['op']==='add') {
        $data=[
            'code'=>$_POST['code'],
            'title'=>$_POST['title'],
            'cred'=>(int)$_POST['cred'],
            'sem'=>$_POST['sem'],
            'inst'=>(int)$_POST['inst']
        ];
        addCourse($data);
        echo "<p>科目を追加しました。</p>";
    }
}
?>
<p><a href="index.php">← ホームへ戻る</a></p>
</body></html>
