CREATE TABLE projects (
    id           INTEGER     NOT NULL AUTO_INCREMENT,
    is_active    TINYINT     NOT NULL DEFAULT 1,
    project      VARCHAR(64) NOT NULL,
    lead_user_id INTEGER     NOT NULL,

    PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE issues (
    id               INTEGER      NOT NULL AUTO_INCREMENT,
    project_id       INTEGER      NOT NULL,
    assigned_user_id INTEGER      NOT NULL,
    resolution_id    TINYINT      NOT NULL DEFAULT 0,
    priority_id      TINYINT      NOT NULL DEFAULT 4,
    title            VARCHAR(255) NOT NULL,
    last_updated     TIMESTAMP    NOT NULL,

    PRIMARY KEY  (id),
    INDEX ix_project (project_id, assigned_user_id),
    INDEX ix_user (assigned_user_id, project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE resolutions (
    id         TINYINT  NOT NULL,
    resolution CHAR(24) NOT NULL,
    is_open    TINYINT  NOT NULL DEFAULT 0,
    ordering   TINYINT  NOT NULL,

    PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO resolutions VALUES (0, 'Untriaged',              1, 0);
INSERT INTO resolutions VALUES (1, 'Open',                   1, 10);
INSERT INTO resolutions VALUES (2, 'Suspended',              1, 20);
INSERT INTO resolutions VALUES (3, 'Resolved',               0, 30);
INSERT INTO resolutions VALUES (4, 'Intended Behaviour',     0, 40);
INSERT INTO resolutions VALUES (5, 'Not Enough Information', 0, 50);
INSERT INTO resolutions VALUES (6, 'Won''t Fix',             0, 60);

CREATE TABLE priorities (
    id       TINYINT  NOT NULL,
    priority CHAR(42) NOT NULL,
    ordering TINYINT  NOT NULL,

    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO priorities VALUES (1, 'Enhancement', 99);
INSERT INTO priorities VALUES (2, 'Critical',    5);
INSERT INTO priorities VALUES (3, 'High',        10);
INSERT INTO priorities VALUES (4, 'Medium',      20);
INSERT INTO priorities VALUES (5, 'Showstopper', 1);
INSERT INTO priorities VALUES (6, 'Annoyance',   50);

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
    KEY ix_issue (issue_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE users (
    id     INTEGER          NOT NULL AUTO_INCREMENT,
    email  VARCHAR(128)     NOT NULL,
    pwd    CHAR(40)         NOT NULL,
    name   VARCHAR(128)     NOT NULL,
    is_dev TINYINT          NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    INDEX ix_email (email),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE user_ips (
    ip      INTEGER UNSIGNED NOT NULL,
    user_id INTEGER NOT NULL,

    PRIMARY KEY  (ip)
) ENGINE=InnoDB;

INSERT INTO users VALUES (
	1,
	'keith@talideon.com',
	CONCAT(MD5(CONCAT('xyzzy1', 'vdg3dfg*')), 'vdg3dfg*'),
	NULL,
	'Keith Gaughan',
	1
);
