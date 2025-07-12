create database libro_db

-- USERS TABLE
CREATE TABLE users (
    id VARCHAR(8) PRIMARY KEY, -- e.g., 20250001
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    type ENUM('librarian', 'borrower') NOT NULL,
    region VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    barangay VARCHAR(100) NOT NULL
);

-- BOOKS TABLE
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50),
    stock INT NOT NULL DEFAULT 0
);

-- BORROWED_BOOKS TABLE
CREATE TABLE borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(8) NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('borrowed', 'pending', 'returned') NOT NULL DEFAULT 'borrowed',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- MY_SHELF TABLE
CREATE TABLE my_shelf (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(8) NOT NULL,
    book_id INT NOT NULL,
    added_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

INSERT INTO books (title, author, description, image, category, stock) VALUES
-- HORROR
('The Shining', 'Stephen King', 'A haunted hotel slowly drives a family to madness.', 'ts.jpg', 'Horror', 10),
('Dracula', 'Bram Stoker', 'The original vampire novel that started a legend.', 'td.jpg', 'Horror', 8),

-- SCI-FI
('The Martian', 'Andy Weir', 'An astronaut stranded on Mars uses science to survive.', 'tm.jpg', 'Sci-fi', 12),
('Neuromancer', 'William Gibson', 'Cyberpunk classic about hacking and AI.', 'nu.jpg', 'Sci-fi', 7),
('Dune', 'Frank Herbert', 'A desert planet holds the key to galactic power.', 'dn.jpg', 'Sci-fi', 10),

-- FANTASY
('The Hobbit', 'J.R.R. Tolkien', 'A hobbit goes on a perilous journey with dwarves.', 'th.jpg', 'Fantasy', 15),
('Harry Potter', 'J.K. Rowling', 'A boy discovers he’s a wizard and attends a magical school.', 'hp.jpg', 'Fantasy', 20),
('Game of Thrones', 'George R. R. Martin', 'Noble houses clash in a brutal fantasy world.', 'gt.jpg', 'Fantasy', 14),
('Beyond the Ocean Door', 'Amisha Sathi', 'A poetic journey through mysterious seascapes.', 'brof.jpg', 'Fantasy', 4),
('The Great Gatsby', 'F. Scott Fitzgerald', 'A tragic tale of love and ambition in the Jazz Age.', 'tgg.jpg', 'Fantasy', 7),

-- COMEDY
('Good Omens', 'Terry Pratchett and Neil Gaiman', 'An angel and demon team up to stop Armageddon.', 'go.jpg', 'Comedy', 11),
('Bossypants', 'Tina Fey', 'Hilarious stories from the life of Tina Fey.', 'bp.jpg', 'Comedy', 9),
('Really, Good, Actually', 'Monica Heisey', 'A brutally funny novel about heartbreak and healing.', 'rga.jpg', 'Comedy', 6),
('Everything Is Not Peachet', 'Lisa Peachey', 'A light-hearted tale of finding balance in chaos.', 'enp.jpg', 'Comedy', 5),

-- BIOGRAPHY
('The Diary of a Young Girl', 'Anne Frank', 'A young Jewish girl’s account of hiding during WWII.', 'dy.jpg', 'Biography', 10),
('Long Walk to Freedom', 'Nelson Mandela', 'The autobiography of South Africa’s most iconic leader.', 'lw.jpg', 'Biography', 10),
('Moby-Dick', 'Nathaniel Philbrick', 'A biographical retelling of Melville’s whaling classic.', 'md.jpg', 'Biography', 6);
