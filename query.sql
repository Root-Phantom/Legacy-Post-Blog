CREATE USER 'blog'@'%' IDENTIFIED BY '5819';
GRANT ALL PRIVILEGES ON blog.* TO 'blog'@'%';
FLUSH PRIVILEGES;
CREATE DATABASE blog;
USE blog;
create table posts
(
    id         int auto_increment
        primary key,
    title      varchar(255)                        not null,
    body       text                                not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at timestamp default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP
);
-- sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
