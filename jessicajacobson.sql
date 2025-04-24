
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
