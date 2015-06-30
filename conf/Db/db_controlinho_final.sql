CREATE TABLE usuario(
    id SERIAL,
    nome CHARACTER VARYING(50),
    email CHARACTER VARYING(50),
    senha CHARACTER VARYING(32),
    status INTEGER,
    avatar CHARACTER VARYING(256),
    PRIMARY KEY (id)
);

CREATE TABLE posts (
    id SERIAL,
    titulo CHARACTER VARYING(50),
    corpo TEXT,
    usuario INTEGER,
    data_post DATE DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT usuario_post FOREIGN KEY (usuario) REFERENCES usuario (id)
);

CREATE TABLE anexos(
    id SERIAL,
    src CHARACTER VARYING(256),
    media CHARACTER VARYING(256),
    post INTEGER,
    CONSTRAINT anexos_post FOREIGN KEY (post) REFERENCES posts (id)
);

CREATE TABLE comentarios(
    id SERIAL,
    comentario TEXT,
    usuario INTEGER DEFAULT NULL,
    data_comentario DATE DEFAULT NULL,
    post INTEGER DEFAULT NULL,
    CONSTRAINT comentario_post FOREIGN KEY (post) REFERENCES posts (id),
    CONSTRAINT usuario_autor_comentario FOREIGN KEY (usuario) REFERENCES usuario (id)
);
