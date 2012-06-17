CREATE TABLE sed_qaptcha (
	qst_id INT NOT NULL AUTO_INCREMENT,
	qst_text VARCHAR(255) NOT NULL,
	qst_answer	VARCHAR(255) NOT NULL,
	PRIMARY KEY(qst_id)
	);
	INSERT INTO sed_qaptcha (qst_text, qst_answer)
	VALUES ('What is the name of our planet?', 'earth');
	INSERT INTO sed_qaptcha (qst_text, qst_answer)
	VALUES ('The name of USA, Canada, Australia currency is', 'dollar');
	INSERT INTO sed_qaptcha (qst_text, qst_answer)
	VALUES ('A horse-like animal with black and white lines', 'zebra');