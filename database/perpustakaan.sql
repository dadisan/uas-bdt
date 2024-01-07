-- Masuk ke SQL
-- mysql - u root 
-- 
-- membuat database
CREATE DATABASE perpustakaan;

-- menggunakan database
USE perpustakaan;

CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    stock INT NOT NULL,
    published_date DATE
);

CREATE TABLE members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);

CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    book_id INT NOT NULL,
    member_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (book_id) REFERENCES books(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

-- membuat tabel users
CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    `password` VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = INNODB;

-- menambahkan/memasukan/insert/input users
INSERT INTO
    users (username, `password`)
VALUES
    ("david", "rahasia"),
    ("dimas", "password");

-- Membuat view buku yang tersedia atau stok lebih dari 0
CREATE VIEW available_books AS
SELECT id, title
FROM books
WHERE stock > 0;

-- Trigger untuk mengurangi stok saat buku dipinjam
DELIMITER //
CREATE TRIGGER reduce_stock_after_borrow
AFTER INSERT ON transactions
FOR EACH ROW
BEGIN
    SET @book_stock := (SELECT stock FROM books WHERE id = NEW.book_id);

    -- Kurangi stok buku sebanyak 1
    UPDATE books SET stock = @book_stock - 1 WHERE id = NEW.book_id;
END //
DELIMITER ;

-- Trigger untuk menambah stok saat buku dikembalikan
DELIMITER //
CREATE TRIGGER increase_stock_after_return
AFTER UPDATE ON transactions
FOR EACH ROW
BEGIN
    IF NEW.return_date IS NOT NULL AND OLD.return_date IS NULL THEN
        SET @book_stock := (SELECT stock FROM books WHERE id = OLD.book_id);

        -- Tambahkan stok buku sebanyak 1
        UPDATE books SET stock = @book_stock + 1 WHERE id = OLD.book_id;
    END IF;
END //
DELIMITER ;

-- Buat stored procedure
DELIMITER //
CREATE PROCEDURE GetUnreturnedTransactions()
BEGIN
    SELECT transactions.id, books.title, members.name, transactions.borrow_date
    FROM transactions
    JOIN books ON transactions.book_id = books.id
    JOIN members ON transactions.member_id = members.id
    WHERE transactions.return_date IS NULL;
END //
DELIMITER ;

-- Stored Procedure untuk mendapatkan semua transaksi
DELIMITER //
CREATE PROCEDURE GetAllTransactions()
BEGIN
    SELECT transactions.id, books.title, members.name, transactions.borrow_date, transactions.return_date
    FROM transactions
    JOIN books ON transactions.book_id = books.id
    JOIN members ON transactions.member_id = members.id;
END //
DELIMITER ;

-- Buat function
DELIMITER //
CREATE FUNCTION UpdateReturnDate(transaction_id INT, return_date DATE)
RETURNS BOOLEAN
BEGIN
    DECLARE success BOOLEAN DEFAULT FALSE;

    -- Lakukan operasi pembaruan
    UPDATE transactions SET return_date = return_date WHERE id = transaction_id;

    -- Cek apakah pembaruan berhasil
    IF ROW_COUNT() > 0 THEN
        SET success = TRUE;
    END IF;

    RETURN success;
END //
DELIMITER ;
