CREATE TABLE projects (
    id           INTEGER     NOT NULL AUTO_INCREMENT,
    is_active    TINYINT     NOT NULL DEFAULT 1,
    project      VARCHAR(64) NOT NULL,
    lead_user_id INTEGER     NOT NULL,

    PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE issues (
    id               INTEGER      NOT NULL AUTO_INCREMENT,
    project_id       INTEGER      NOT NULL,
    assigned_user_id INTEGER      NOT NULL,
    status_id        TINYINT      NOT NULL DEFAULT 0,
    priority_id      TINYINT      NOT NULL DEFAULT 4,
    title            VARCHAR(255) NOT NULL,
    last_updated     TIMESTAMP    NOT NULL,

    PRIMARY KEY  (id),
    INDEX ix_project (project_id, assigned_user_id),
    INDEX ix_user (assigned_user_id, project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE statuses (
    id       TINYINT  NOT NULL,
    status   CHAR(32) NOT NULL,
    is_open  TINYINT  NOT NULL DEFAULT 0,
    ordering TINYINT  NOT NULL,

    PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO statuses VALUES (0, 'Untriaged',              1, 0);
INSERT INTO statuses VALUES (1, 'Open',                   1, 10);
INSERT INTO statuses VALUES (2, 'Suspended',              1, 20);
INSERT INTO statuses VALUES (3, 'Resolved',               0, 30);
INSERT INTO statuses VALUES (4, 'Intended Behaviour',     0, 40);
INSERT INTO statuses VALUES (5, 'Not Enough Information', 0, 50);
INSERT INTO statuses VALUES (6, 'Won''t Fix',             0, 60);
INSERT INTO statuses VALUES (7, 'Design Decision Needed', 1, 5);
INSERT INTO statuses VALUES (8, 'Works For Me',           0, 35);

CREATE TABLE priorities (
    id       TINYINT  NOT NULL,
    priority CHAR(42) NOT NULL,
    ordering TINYINT  NOT NULL,

    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO priorities VALUES (1, 'Enhancement',   99);
INSERT INTO priorities VALUES (2, 'Critical',      5);
INSERT INTO priorities VALUES (3, 'High',          10);
INSERT INTO priorities VALUES (4, 'Medium',        20);
INSERT INTO priorities VALUES (5, 'Showstopper',   1);
INSERT INTO priorities VALUES (6, 'Annoyance',     50);
INSERT INTO priorities VALUES (7, 'Documentation', 60);

CREATE TABLE watches (
    user_id  INTEGER NOT NULL,
    issue_id INTEGER NOT NULL,

    PRIMARY KEY (user_id, issue_id),
    INDEX ix_issue (issue_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE messages (
    id       INTEGER  NOT NULL AUTO_INCREMENT,
    issue_id INTEGER  NOT NULL,
    user_id  INTEGER  NOT NULL,
    posted   DATETIME NOT NULL,
    message  TEXT     NOT NULL,

    PRIMARY KEY (id),
    INDEX ix_issue (issue_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE attachments (
    id         INTEGER      NOT NULL AUTO_INCREMENT,
    message_id INTEGER      NOT NULL,
    size       INTEGER      NOT NULL,
    filename   VARCHAR(255) NOT NULL,

    PRIMARY KEY (id),
    INDEX ix_message (message_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Only needed if you have to store the attachments in the database.
CREATE TABLE attachment_chunks (
    attachment_id INTEGER    NOT NULL,
    data          MEDIUMBLOB NOT NULL,

    PRIMARY KEY (attachment_id)
) ENGINE=MyISAM;

CREATE TABLE users (
    id     INTEGER          NOT NULL AUTO_INCREMENT,
    email  VARCHAR(128)     NOT NULL,
    pwd    CHAR(40)         NOT NULL,
    name   VARCHAR(128)     NOT NULL,
    is_dev TINYINT          NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    INDEX ix_email (email),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE user_ips (
    ip      INTEGER UNSIGNED NOT NULL,
    user_id INTEGER NOT NULL,

    PRIMARY KEY  (ip)
) ENGINE=MyISAM;

INSERT INTO users VALUES (
    1,
    'keith@talideon.com',
    CONCAT(MD5(CONCAT('xyzzy1', 'vdg3dfg*')), 'vdg3dfg*'),
    'Keith Gaughan',
    1
);
