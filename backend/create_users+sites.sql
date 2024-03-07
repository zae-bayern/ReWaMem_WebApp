CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE sites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    site_name VARCHAR(255) NOT NULL,
    site_data TEXT, -- This could be JSON data or any format, TODO
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);
