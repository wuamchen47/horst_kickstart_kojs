<?php

$db = new MySqli('localhost', 'root', '', 'horst');
$db->query("SET NAMES 'utf8'");
$db->query("SET CHARACTER SET utf8");
$start_read = 0;
$npp = 47;

$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
$student = (!empty($_POST['student'])) ? $_POST['student'] : '';


if(!empty($student)){
	$name = $student['name'];
	$age = $student['age'];	
}

switch($action){

	case 'insert':
		$db->query("INSERT INTO students SET name = '$name', age = '$age'"); 
		echo $db->insert_id; //last insert id
	break;

	case 'update':
		$id = $student['id'];
		$db->query("UPDATE students SET name = '$name', age = '$age' WHERE id = '$id'");
	break;

	default:
        $sql =  "   SELECT n.id, u.name, u.avatar, n.text, DATE_FORMAT(n.time, '%d.%m.%Y') as fulldate, n.linkurl
                    FROM news n, user u 
                    WHERE n.user = u.id and n.private = 0 
                    ORDER BY n.id DESC LIMIT $start_read,$npp
                ";
        $news = $db->query($sql);
		$news_r = array();
		while($row = $news->fetch_array()){
            $id = $row['id'];
			$name = $row['name'];
            $avatar = $row['avatar'];
			$comment = $row['text'];
            $fulldate = $row['fulldate'];
            $link = $row['linkurl'];

			$news_r[] = array(
				'id' => $id, 'name' => $name, 'avatar' => $avatar, 'comment' => $comment, 'fulldate' => $fulldate, 'link' => $link
				); 
		}
		echo json_encode($news_r);
	break;
}
?>