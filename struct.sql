CREATE TABLE /*TABLE_PREFIX*/t_resume_uploader (
    fk_i_user_id INT(10) UNSIGNED NOT NULL,
    name VARCHAR(255),
	code VARCHAR(255),
	ext VARCHAR(150),
	views int(10) NOT NULL,
	date date NOT NULL,
    	INDEX (fk_i_user_id),
        PRIMARY KEY (fk_i_user_id),
        FOREIGN KEY (fk_i_user_id) REFERENCES /*TABLE_PREFIX*/t_user (pk_i_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';