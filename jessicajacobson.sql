
-- Drop table and triggers if they already exist (optional, for re-runs)
DROP TRIGGER IF EXISTS before_users_insert;
DROP TRIGGER IF EXISTS before_users_update;
DROP TABLE IF EXISTS users;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    is_admin TINYINT DEFAULT 0,
    username VARCHAR(255) NOT NULL,
    first_name VARCHAR(255),
    full_name VARCHAR(255) NOT NULL,
    city VARCHAR(255),
    country VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    profile_language VARCHAR(2) DEFAULT 'fr',
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    profile_picture VARCHAR(255),
    UNIQUE KEY unique_username (username),
    UNIQUE KEY unique_email (email)
);


-- Add a trigger to enforce uniqueness for (username, email) when is_admin = 0
DELIMITER //

CREATE TRIGGER before_users_insert
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    IF NEW.is_admin = 0 THEN
        IF EXISTS (
            SELECT 1 FROM users
            WHERE is_admin = 0
              AND username = NEW.username
              AND email = NEW.email
        ) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'A non-admin user with this username and email already exists';
        END IF;
    END IF;
END;
//

CREATE TRIGGER before_users_update
BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
    IF NEW.is_admin = 0 THEN
        IF EXISTS (
            SELECT 1 FROM users
            WHERE is_admin = 0
              AND username = NEW.username
              AND email = NEW.email
              AND id <> NEW.id
        ) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'A non-admin user with this username and email already exists';
        END IF;
    END IF;
END;
//

DELIMITER ;

INSERT INTO `users` (`id`, `title`, `is_admin`, `username`, `first_name`, `full_name`, `city`, `country`, `password`, `email`, `profile_language`, `registration_date`, `profile_picture`) VALUES
(1, 'Monsieur', 0, 'marc@gmail.com', 'Marc', 'Famille', 'Montréal', 'Canada', '$2y$10$lobhIJcZ8Y1fujVTZyI2NuimyOhhLGZHpQGSrD8kQeEbFPGM6TWHe', 'marc@gmail.com', 'fr', '2024-05-29 17:53:22', '/uploads/profile_pictures/2024_05_29_17_53_22.jpg'),
(2, 'Madame', 0, 'emma@gmail.com', 'Emma', 'Famille', 'Genève', 'Suisse', '$2y$10$Mcmr1sOE17Pj48r0Uip.1..dAoTylZZ1hDRXvz3yYmLoOAwRjgxsa', 'emma@gmail.com', 'fr', '2024-05-29 17:55:01', '/uploads/profile_pictures/2024_05_29_17_55_01.jpg'),
(3, 'Madame', 0, 'alice@gmail.com', 'Alice', 'Famille', 'Genève', 'Suisse', '$2y$10$YI/CLRwxpmyk1YT6Caq5Sejnhx/IMJdgl20hqco7eXpQIhOnUTJ6m', 'alice@gmail.com', 'fr', '2024-05-29 17:56:34', '/uploads/profile_pictures/2024_05_29_17_56_34.jpg'),
(4, 'Madame', 0, 'isabelle@gmail.com', 'Isabelle', 'Famille', 'Rome', 'Italie', '$2y$10$7MtQuOAUd1bDbXsVfju47eZu8DM24Ui4luey3mAty5Er7a8bnWmC.', 'isabelle@gmail.com', 'fr', '2024-05-29 17:51:47', '/uploads/profile_pictures/2024_05_29_17_51_47.jpg'),
(5, 'Monsieur', 0, 'mathieu@gmail.com', 'Mathieu', 'Famille', 'Montréal', 'Canada', '$2y$10$OtxiWQdTp.rWsVK2i6VVpuya4zDXbTa7p3q2h5z23Vd.saSb8OJBO', 'mathieu@gmail.com', 'fr', '2024-05-29 17:50:15', '/uploads/profile_pictures/2024_05_29_17_50_15.jpg'),
(6, 'Madame', 0, 'sophie@gmail.com', 'Sophie', 'Famille', 'Montréal', 'Québec, canada', '$2y$10$X.dtgxZIlzIqoOBg4y1V7.uYeFtk3nJuQBJaRAB/uQEPZ2zzpTjMu', 'sophie@gmail.com', 'fr', '2024-05-29 17:48:15', '/uploads/profile_pictures/2024_05_29_17_48_15.jpg'),
(7, 'Monsieur', 0, 'jerome@gmail.com', 'Jérôme', 'Famille', 'Montréal', 'Québec', '$2y$10$bXHVZuKv3D.dpIpVP7mHLOBv7YZOkDVbbWdMe.UohtAzX2F41rOuu', 'jerome@gmail.com', 'fr', '2024-05-29 17:45:49', '/uploads/profile_pictures/2024_05_29_17_45_49.jpg'),
(8, 'Madame', 0, 'clara@gmail.com', 'Clara', 'Famille', 'Béziers', 'France', '$2y$10$1GJE6QZd4Y0pFXicPlAWse3zOhoY6TskRLCbo.q7R98VOoCvRd2lW', 'clara@gmail.com', 'fr', '2024-05-29 17:42:42', '/uploads/profile_pictures/2024_05_29_17_42_42.jpg'),
(9, 'Madame', 0, 'jessicajacobson.ca@gmail.com', 'Jessica Jacobson', 'Jacobson', 'Genève', 'Suisse', '$2y$10$aQNd4V8BFw/LfeO22DDyaucnExfFnKLjSyh34gI15aNqp.cZjKUQa', 'jessicajacobson.ca@gmail.com', 'fr', '2024-05-29 14:50:49', '/uploads/profile_pictures/2024_05_29_14_50_49.jpg'),
(10, 'Monsieur', 0, 'jean-paul@gmail.com', 'Jean-paul', 'Famille', 'Martigny', 'Suisse', '$2y$10$L47lPAmuZVSWcEhozVpyoOu9Esp/qhL0HoYp4DRzBB6MuanZoRzPi', 'jean-paul@gmail.com', 'fr', '2024-05-29 17:58:36', '/uploads/profile_pictures/2024_05_29_17_58_36.jpg'),
(11, 'Monsieur', 0, 'daniel@gmail.com', 'Daniel', 'Famille', 'Genève', 'Suisse', '$2y$10$auIwgXlKAo9Cl8xqgL/wNuhgP.ocAuV.dQRHIvwolcHHrWRuAtlnO', 'daniel@gmail.com', 'fr', '2024-05-29 18:00:10', '/uploads/profile_pictures/2024_05_29_18_00_10.jpg'),
(12, 'Madame', 0, 'christine@gmail.com', 'Christine', 'Famille', 'Montréal', 'Canada', '$2y$10$jrh.AJ8n7jVVyxQhGzkAU.n8eXtMXVI9Rb1f9a6.T0kCKQBQCe4si', 'christine@gmail.com', 'fr', '2024-05-29 18:02:12', '/uploads/profile_pictures/2024_05_29_18_02_12.jpg'),
(13, 'Monsieur', 0, 'kaplan@gmail.com', 'Mr. kaplan', 'Famille', 'Quelle part', 'Ailleurs', '$2y$10$2rtUYVNTTFE1M3wHTcqx6e25oyoVjNbjM86S.2DHDZ0ozVSJKpzRi', 'kaplan@gmail.com', 'fr', '2024-05-29 18:04:07', '/uploads/profile_pictures/2024_05_29_18_04_07.jpg'),
(14, 'Madame', 0, 'marie@gmail.com', 'Marie', 'Famille', 'Rouen', 'France', '$2y$10$L81YQyC5TpzS6LejbvIMb.VL3hxbOpgllGleyyjr2xNz/lCeWjzoK', 'marie@gmail.com', 'fr', '2024-05-29 18:07:05', '/uploads/profile_pictures/2024_05_29_18_07_05.jpg'),
(15, 'Monsieur', 0, 'david@gmail.com', 'David', 'Alexandre', 'Genève', 'Suisse', '$2y$10$tHYpqLR8AKPLXJkidzbZ3.2EBDDdVXVNgI1JHqQZFaV..ZS8tVwa.', 'david@gmail.com', 'fr', '2024-05-29 19:15:11', '/uploads/profile_pictures/2024_05_29_19_15_11.jpg'),
(16, 'Monsieur', 0, 'frederic@gmail.com', 'Frédéric', 'Famille', 'Montréal', 'Canada', '$2y$10$UcFkNfAaeNvQBzpRFNcdlOLVDBduMCutUezRJl0gNI0G.q/arZE5y', 'frederic@gmail.com', 'fr', '2024-05-29 19:31:49', '/uploads/profile_pictures/2024_05_29_19_31_49.jpg'),
(17, 'Madame', 0, 'lysiane@gmail.com', 'Lysiane', 'Famille', 'Montréal', 'Canada', '$2y$10$GIGNfzvYeriIn71FUPgZ2eqwatsXARCCymho/.bSxkxNjFdcb/00a', 'lysiane@gmail.com', 'fr', '2024-05-30 17:22:40', '/uploads/profile_pictures/2024_05_30_17_22_40.jpg'),
(18, 'Madame', 0, 'caroline@gmail.com', 'Caroline', 'Famille', 'Paris', 'France', '$2y$10$iK4i0LQHJZ2FJsyWIJifluqOkmvIn15rfjZ7IqFKE9lp2.K1Xe8GK', 'caroline@gmail.com', 'fr', '2024-05-30 17:25:17', '/uploads/profile_pictures/2024_05_30_17_25_17.jpg'),
(19, 'Monsieur', 0, 'ccortes66@hotmail.com', 'Carl', 'Cortés', 'St jérôme', 'Canada', '$2y$10$joDWRi5/4YOp2evgQ.qFDeGxgTTwpF0os469Q1id8q5GR7SS.KZtO', 'ccortes66@hotmail.com', 'fr', '2024-10-19 00:07:28', '/uploads/profile_pictures/2024_10_19_00_07_28.jpg'),
(20, 'Monsieur', 0, 'sam@gmail.com', 'Sam', 'Sam', 'Nepal', 'Nepal', '$2y$10$OK00TEWtCrjtYtLZ4mcdN.3uJ8rcCWotI9nQAAljfHMDqd6V/75/O', 'sam@gmail.com', 'fr', '2025-04-04 08:02:31', '/uploads/profile_pictures/2025_04_04_08_02_31.jpg'),
(21, 'Monsieur', 0, 'prabeshbikramshahi2014@gmail.com', 'Prabesh', 'Prabesh bikram shahi', 'Bhaktapur', 'Nepal', '$2y$10$LuRymQUTb2csBgZMWAbAkeGNtkMd1QnYovkU/os.Q84nw9qnvKrya', 'prabeshbikramshahi2014@gmail.com', 'fr', '2025-04-07 06:26:14', '/uploads/profile_pictures/2025_04_07_06_26_14.jpg'),
(22, 'Madame', 0, 'sndes.kafle7@gmail.com', 'Sandesh', 'Sandesh', 'Kathmandu', 'Nepal', '$2y$10$TsMpmf/sN/ByNpehm1XB3.b7ZXm66YNFSiV5EVhafeFSJeU3lYF8C', 'sndes.kafle7@gmail.com', 'fr', '2025-04-15 06:13:36', '/uploads/profile_pictures/2025_04_15_06_13_36.jpg'),
(23, 'Monsieur', 0, 'testuser@gmail.com', 'Test', 'User', 'Test', 'Test', '$2y$10$HqyUpQUC3ktxWUOOW8uGTuLOcr58v1bSbKPh6SaRlk6fy1mTByEE.', 'testuser@gmail.com', 'fr', '2025-04-15 17:01:34', '/uploads/profile_pictures/2025_04_15_17_01_34.jpg'),
(24, 'Monsieur', 0, 'sainicharan361@gmail.com', 'Charan', 'Charan saini', 'Mohali', 'India', '$2y$10$DqpS3TvjwBJFXJ4YLwgiKuKXX/QSkQOxUVNOXcwUi6ycZmmDFbYpO', 'sainicharan361@gmail.com', 'fr', '2025-04-22 07:34:02', '/uploads/profile_pictures/2025_04_22_07_34_02.jpg'),
(25, 'Monsieur', 0, 'charanworkyct@gmail.com', 'Charan', 'Saini', 'Mohali', 'India', '$2y$10$2z28ZGvaYPmVcM5GYnPzReZgzt793MriN6x/YVE9j87LgEUC5Io0.', 'charanworkyct@gmail.com', 'fr', '2025-04-22 12:57:07', '/uploads/profile_pictures/2025_04_22_12_57_07.jpg'),
(26, NULL, 1, 'davidou', 'David', 'Alexandre', NULL, NULL, '$2y$10$U72txNBrRj/65NIi.ooMf.RvnvfuFubPBu/4aqfTyQ.s266wxXRne', 'david@jadsystem.com', 'fr', NULL, NULL),
(27, NULL, 1, 'sanslactose', 'Franziska', 'Dubs', NULL, NULL, '$2y$10$CC3xlWABbVe492y56buj2eF7oCsIe61bRcGxKaSLAyuLaB4YyQ7sC', 'info@sanslactose.com', 'fr', NULL, NULL);

-- Articles table
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT 0,
    title VARCHAR(255) NOT NULL,
    post_type VARCHAR(25),
    content TEXT NOT NULL,
    publication_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    slug VARCHAR(255) UNIQUE NOT NULL,
    meta_title VARCHAR(255),
    meta_description TEXT,
    canonical_url VARCHAR(255),
    language VARCHAR(10) DEFAULT 'en',
    featured_image VARCHAR(255),  -- URL or relative path to the featured_image
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Pages table
CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_parent_id INT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    meta_title VARCHAR(255),
    meta_description TEXT,
    canonical_url VARCHAR(255),
    language VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (page_parent_id) REFERENCES pages(id)

);

-- Languages table
CREATE TABLE languages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Comments table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text TEXT NOT NULL,
    comment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
