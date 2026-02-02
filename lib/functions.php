<?php
// lib/functions.php
require_once __DIR__ . '/../config/database.php';

function getSetting($key)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    return $result ? $result['setting_value'] : null;
}

function getGallery($type = null)
{
    global $pdo;
    if ($type) {
        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE type = ? ORDER BY created_at DESC");
        $stmt->execute([$type]);
    } else {
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
    }
    return $stmt->fetchAll();
}

function getSongs()
{
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM songs ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        // Table might be missing (SQLSTATE[42S02]: Base table or view not found: 1146)
        if ($e->getCode() == '42S02') {
            // Re-create the table
            $pdo->exec("CREATE TABLE IF NOT EXISTS songs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(100) NOT NULL,
                artist VARCHAR(100),
                file_path VARCHAR(255) NOT NULL,
                cover_path VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            // Seed with default data if empty
            $pdo->exec("INSERT INTO songs (title, artist, file_path, cover_path) VALUES 
                ('everything u are', 'Hindia', 'musik/everything u are - Hindia.mp3', 'foto/everyth.jpg'),
                ('Jiwa Yang Bersedih', 'Ghea Indrawari', 'musik/Jiwa Yang Bersedih - Ghea Indrawari.mp3', 'foto/jiwayangb.jpg'),
                ('Malaikat', 'Ghea Indrawari', 'musik/Malaikat - Ghea Indrawari.mp3', 'foto/malaikatku.jpg'),
                ('Monolog', 'Pamungkas', 'musik/Monolog - Pamungkas.mp3', 'foto/monologg.jpg'),
                ('Tarot', '.Feast', 'musik/Tarot - .Feast.mp3', 'foto/tarottw.jpg'),
                ('Terima Kasih Sudah Bertahan', 'Ghea Indrawari', 'musik/Terima Kasih Sudah Bertahan - Ghea Indrawari.mp3', 'foto/terimakasihku.jpg')");

            $stmt = $pdo->query("SELECT * FROM songs ORDER BY created_at DESC");
            return $stmt->fetchAll();
        }
        return [];
    }
}

function getBucketList()
{
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM bucket_list ORDER BY created_at ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        if ($e->getCode() == '42S02') {
            $pdo->exec("CREATE TABLE IF NOT EXISTS bucket_list (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                is_done BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            $pdo->exec("INSERT INTO bucket_list (title, is_done) VALUES 
                ('Makan bakso malang bareng caa', 0),
                ('Nonton konser Tulus/Hindia berdua', 0),
                ('Liburan ke Bandung/Bali pas libur panjang', 0),
                ('Beli barang couple (kaos/topi)', 0)");
            return $pdo->query("SELECT * FROM bucket_list ORDER BY created_at ASC")->fetchAll();
        }
        return [];
    }
}

function getTimeline()
{
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM timeline ORDER BY event_date ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        if ($e->getCode() == '42S02') {
            $pdo->exec("CREATE TABLE IF NOT EXISTS timeline (
                id INT AUTO_INCREMENT PRIMARY KEY,
                event_date DATE NOT NULL,
                title VARCHAR(100) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            $pdo->exec("INSERT INTO timeline (event_date, title, description) VALUES 
                ('2025-07-20', 'Pertama Kali Ngobrol', 'Pas photoshoot itu caa, inget gak? Pas bahas tripod wkwk'),
                ('2025-08-15', 'Nemenin ambil tas', 'Momen berdua pertama yang bikin deg-degan parah'),
                ('2025-11-17', 'Hari Jadian', 'Hari paling bahagia pas kamu bilang mau jadi pacar aku!')");
            return $pdo->query("SELECT * FROM timeline ORDER BY event_date ASC")->fetchAll();
        }
        return [];
    }
}

function saveMessage($message, $response, $status = null)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO messages (message, response, status) VALUES (?, ?, ?)");
    return $stmt->execute([$message, $response, $status]);
}

function formatDate($date, $format = 'd M Y')
{
    return date($format, strtotime($date));
}
?>