CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE sites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    site_name VARCHAR(255) NOT NULL,
    site_data TEXT,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Populate with test data to see something
INSERT INTO `sites` (`id`, `user_id`, `site_name`, `site_data`) VALUES
(1, 0, 'Import', '{\"company\":\"Import\",\"type\":\"1\",\"org\":[],\"contact\":\"\",\"phone\":\"\",\"email\":\"\",\"year\":\"\",\"month\":\"\",\"day\":\"\",\"work\":[],\"trockenwaesche\":\"\",\"berufskleidung\":\"\",\"krankenhaus\":\"\",\"hotel\":\"\",\"bewohner\":\"\",\"handtuch\":\"\",\"fussmatten\":\"\",\"feuchtwisch\":\"\",\"reinigungsteile\":\"\",\"sonstiges\":\"\",\"wasser\":\"\",\"strom\":\"\",\"oel\":\"\",\"gas\":\"\",\"holz\":\"\",\"sonstigeenergie\":\"\",\"waschmittel\":\"\",\"abwasserandere\":\"\",\"timespans\":[{\"months\":[],\"year\":\"2024\",\"trockenwaesche\":\"1\",\"berufskleidung\":\"100\",\"krankenhaus\":\"\",\"hotel\":\"\",\"bewohner\":\"\",\"handtuch\":\"\",\"fussmatten\":\"\",\"feuchtwisch\":\"\",\"reinigungsteile\":\"\",\"sonstiges\":\"\",\"wasser\":\"1\",\"strom\":\"0.160\",\"oel\":\"\",\"gas\":\"\",\"holz\":\"\",\"sonstigeenergie\":\"0.8\",\"waschmittel\":\"1\"}]}'),
(2, 0, 'Import', '{\"company\":\"Import\",\"type\":\"1\",\"org\":[],\"contact\":\"\",\"phone\":\"\",\"email\":\"\",\"year\":\"\",\"month\":\"\",\"day\":\"\",\"work\":[],\"trockenwaesche\":\"\",\"berufskleidung\":\"\",\"krankenhaus\":\"\",\"hotel\":\"\",\"bewohner\":\"\",\"handtuch\":\"\",\"fussmatten\":\"\",\"feuchtwisch\":\"\",\"reinigungsteile\":\"\",\"sonstiges\":\"\",\"wasser\":\"\",\"strom\":\"\",\"oel\":\"\",\"gas\":\"\",\"holz\":\"\",\"sonstigeenergie\":\"\",\"waschmittel\":\"\",\"abwasserandere\":\"\",\"timespans\":[{\"months\":[],\"year\":\"2024\",\"trockenwaesche\":\"1\",\"berufskleidung\":\"100\",\"krankenhaus\":\"\",\"hotel\":\"\",\"bewohner\":\"\",\"handtuch\":\"\",\"fussmatten\":\"\",\"feuchtwisch\":\"\",\"reinigungsteile\":\"\",\"sonstiges\":\"\",\"wasser\":\"1\",\"strom\":\"0.163\",\"oel\":\"\",\"gas\":\"\",\"holz\":\"\",\"sonstigeenergie\":\"0.9\",\"waschmittel\":\"1\"}]}');

-- Test user with password 'testpassword' so login is possible
INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'testuser', '$2y$10$V2tu1aWYyvj84QYBBY3B8uiJSpqK.HCqqXeWrz2FQda0knDhdS34O');
