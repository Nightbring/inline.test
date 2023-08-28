<?
$db_config = [
    'dbHost' => 'localhost',
    'dbUser' => 'root',
    'dbPassword' => 'root',
    'dbName' => 'inline.test'
];

$conn = new mysqli($db_config['dbHost'], $db_config['dbUser'], $db_config['dbPassword'], $db_config['dbName']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function write_posts(array $posts):bool {
    global $conn;

    $t = [];

    $q = "INSERT INTO `posts` (`id`,`title`,`body`) VALUES ";
    foreach ($posts as $post) {
        array_push($t, "('{$post['id']}', '{$post['title']}', '{$post['body']}')");
    }

    $q .= implode(', ', $t);

    $q .= " ON DUPLICATE KEY UPDATE `title`=VALUES(title), `body`=VALUES(body);";


    if ($conn->query($q)) {
        return true;
    } 

    return false;
}

function write_comments(array $comments):bool {
    global $conn;
    
    $t = [];

    $q = "INSERT INTO `comments` (`id`, `postId`, `name`, `email`, `body`) VALUES ";
    foreach ($comments as $comment) {
        array_push($t, "('{$comment['id']}', '{$comment['postId']}', '{$comment['name']}', '{$comment['email']}', '{$comment['body']}')");
    }

    $q .= implode(', ', $t);

    $q .= " ON DUPLICATE KEY UPDATE `postId`=VALUES(postId), `name`=VALUES(name), `email`=VALUES(email), `body`=VALUES(body);";


    if ($conn->query($q)) {
        return true;
    } 
    
    return false;
}

function clear_database():bool {
    global $conn;

    if ($conn->query("DELETE FROM `posts`;") && $conn->query("DELETE FROM `comments`;")) {
        return true;
    } else {
        return false;
    }
    
}

function find_posts_by_keyword($keyword):array {
    global $conn;

    $res = [];
    $r = $conn->query(
        "SELECT p.id, p.title, c.name, c.email, c.body 
        FROM `posts` AS p LEFT JOIN `comments` AS c
        ON p.id = c.postId
        WHERE c.body LIKE '%{$keyword}%'"
    );

    $t = [];
    $i = -1;
    while ($row = $r->fetch_assoc()) {
        if ($row['id'] != $i) {
            
            if ($t != []) {
                array_push($res, $t);
            }

            $i = $row['id'];

            $t = [
                'id' => $row['id'],
                'title' => $row['title'],
                'name' => $row['name'],
                'comments' => []
            ];

            array_push($t['comments'], [
                'name' => $row['name'],
                'email' => $row['email'],
                'body' => $row['body']
            ]);
        } else {

            array_push($t['comments'], [
                'name' => $row['name'],
                'email' => $row['email'],
                'body' => $row['body']
            ]);
        }
    }
    if ($t != []) {
        array_push($res, $t);
    }

    return $res;
}
