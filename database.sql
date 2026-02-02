-- Database schema for acc_repo
CREATE DATABASE IF NOT EXISTS acc_portfolio;
USE acc_portfolio;

-- Table for admin users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for gallery/photos
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    image_path VARCHAR(255) NOT NULL,
    type ENUM('kenangan', 'galeri') DEFAULT 'galeri',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for messages from proposal
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    response ENUM('accept', 'maybe', 'decline') DEFAULT 'maybe',
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for site settings
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT,
    description VARCHAR(255)
);

-- Initial Data
INSERT INTO settings (setting_key, setting_value, description) VALUES 
('relationship_start_date', '2025-11-17', 'Tanggal jadian'),
('admin_lock_password', 'Matcha', 'Password overlay login');

-- Table for songs
CREATE TABLE IF NOT EXISTS songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100),
    file_path VARCHAR(255) NOT NULL,
    cover_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Songs Data
INSERT INTO songs (title, artist, file_path, cover_path) VALUES 
('everything u are', 'Hindia', 'musik/everything u are - Hindia.mp3', 'foto/everyth.jpg'),
('Jiwa Yang Bersedih', 'Ghea Indrawari', 'musik/Jiwa Yang Bersedih - Ghea Indrawari.mp3', 'foto/jiwayangb.jpg'),
('Malaikat', 'Ghea Indrawari', 'musik/Malaikat - Ghea Indrawari.mp3', 'foto/malaikatku.jpg'),
('Monolog', 'Pamungkas', 'musik/Monolog - Pamungkas.mp3', 'foto/monologg.jpg'),
('Tarot', '.Feast', 'musik/Tarot - .Feast.mp3', 'foto/tarottw.jpg'),
('Terima Kasih Sudah Bertahan', 'Ghea Indrawari', 'musik/Terima Kasih Sudah Bertahan - Ghea Indrawari.mp3', 'foto/terimakasihku.jpg');

-- Table for Bucket List
CREATE TABLE IF NOT EXISTS bucket_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    is_done BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Initial Bucket List Data
INSERT INTO bucket_list (title, is_done) VALUES 
('Makan bakso malang bareng caa', 0),
('Nonton konser Tulus/Hindia berdua', 0),
('Liburan ke Bandung/Bali pas libur panjang', 0),
('Beli barang couple (kaos/topi)', 0);

-- Table for Timeline
CREATE TABLE IF NOT EXISTS timeline (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_date DATE NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Initial Timeline Data
INSERT INTO timeline (event_date, title, description) VALUES 
('2025-07-20', 'Pertama Kali Ngobrol', 'Pas photoshoot itu caa, inget gak? Pas bahas tripod wkwk'),
('2025-08-15', 'Nemenin ambil tas', 'Momen berdua pertama yang bikin deg-degan parah'),
('2025-11-17', 'Hari Jadian', 'Hari paling bahagia pas kamu bilang mau jadi pacar aku!');
