CREATE TABLE IF NOT EXISTS categories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150)     NOT NULL,
    slug        VARCHAR(170)     NOT NULL UNIQUE,
    description TEXT             NULL,
    created_at  DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS articles (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(255)     NOT NULL,
    slug          VARCHAR(280)     NOT NULL UNIQUE,
    image         VARCHAR(500)     NULL,
    description   VARCHAR(500)     NULL,
    content       LONGTEXT         NOT NULL,
    views         INT UNSIGNED     NOT NULL DEFAULT 0,
    published_at  DATETIME         NOT NULL,
    created_at    DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_published_at (published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- many-to-many
CREATE TABLE IF NOT EXISTS article_category (
    article_id  INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (article_id, category_id),
    CONSTRAINT fk_ac_article  FOREIGN KEY (article_id)  REFERENCES articles(id)   ON DELETE CASCADE,
    CONSTRAINT fk_ac_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;