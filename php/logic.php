<?
require_once('../database.php');

header('Content-Type: application/json');
$r = json_decode(file_get_contents('php://input'), true);

switch ($r['action']) {
    case 'update':

        $posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
        $comments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);

        if ($posts == [] || $comments == []) {
            echo 'Не удалось получить данные';
            break;
        }

        if (write_posts($posts) && write_comments($comments)) {
            echo 'Загружено ' . count($posts) . ' записей и ' . count($comments) . ' комментариев';
        } else {
            echo 'Не удалось записать данные';
        }

        break;
    
    case 'clear':

        if (clear_database()) {
            echo 'База данных успешно очищена';
        } else {
            echo 'Не удалось очистить базу данных';
        }
        break;

    case 'find_posts':
        $k = $r['keyword'];

        if (strlen($k) >= 3){
            $res = find_posts_by_keyword($k);
            echo json_encode($res);
        } else {
            echo json_encode(['error' => 'too_short_request']);
        }

        break;

    default:
        echo 'action is unidentified';
        break;
}

