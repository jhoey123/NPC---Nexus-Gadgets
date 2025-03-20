CREATE table users(
    id int(11) NOT NULL AUTO_INCREMENT,
    fname varchar(255) NOT NULL,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
);

CREATE table products(
    barcode_id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    category varchar(255) NOT NULL,
    description text NOT NULL,
    price int(11) NOT NULL,
    image varchar(255) NOT NULL,
    PRIMARY KEY (barcode_id)
);

CREATE table orders(
    order_id int(11) NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    barcode_id int(11) NOT NULL,
    quantity int(11) NOT NULL,
    PRIMARY KEY (order_id),
    Index (user_id),
    FOREIGN KEY (barcode_id) REFERENCES products(barcode_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE table category(
    product_id int(11) NOT NULL AUTO_INCREMENT,
    category_name varchar(255) NOT NULL,
    PRIMARY KEY (product_id),
    foreign key (product_id) references products(barcode_id)
);
--i copy and paste lang ni sa sql file sa nexusDB.sql