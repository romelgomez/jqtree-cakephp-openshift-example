CREATE TABLE posts (
    id SERIAL,
    title VARCHAR(50),
    body TEXT,
    created TIMESTAMP DEFAULT NULL,
    modified TIMESTAMP DEFAULT NULL
);

INSERT INTO posts (title,body,created)
    VALUES ('The title', 'This is the post body.', NOW());
INSERT INTO posts (title,body,created)
    VALUES ('A title once again', 'And the post body follows.', NOW());
INSERT INTO posts (title,body,created)
    VALUES ('Title strikes back', 'This is really exciting! Not.', NOW());

