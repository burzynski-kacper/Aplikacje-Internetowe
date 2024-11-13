create table post
(
    id      integer not null
        constraint post_pk
            primary key autoincrement,
    subject text not null,
    content text not null
);
create table fish (
    id integer primary key autoincrement ,
    species text not null,
    location text not null,
    record decimal(5, 2)
);