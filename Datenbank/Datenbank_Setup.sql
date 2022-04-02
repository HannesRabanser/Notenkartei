CREATE DATABASE noa_notenarchiv;

USE noa_notenarchiv;


/* Erstellen der Tabellen */
CREATE TABLE tb_thema (
    th_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	th_name varchar(100)
);

CREATE TABLE tb_z_i_kirchenjahr (
    zik_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	zik_name varchar(100)
);

CREATE TABLE tb_katigorie (
    ka_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ka_name varchar(100),
    ka_prefix varchar(5)
);

CREATE TABLE tb_besetzung (
    be_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	be_name varchar(100)
);

CREATE TABLE tb_verlag (
    ve_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ve_name varchar(100)
);

CREATE TABLE tb_notenblatt (
    nb_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nb_katalognummer varchar(5),
	nb_titel varchar(100),
    nb_untertitel varchar(100),
    nb_zugehoerigkeit varchar(100),
    nb_katigorie int,
    nb_besetzung int,
    nb_komponist varchar(100),
    nb_bearbeitung varchar(100),
    nb_texter varchar(100),
    nb_verlag int,
    nb_werknummer varchar(100),
    nb_status varchar(100)
);

CREATE TABLE tb_user (
    us_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	us_username varchar(50),
    us_passwort varchar(255),
    us_berechtigung tinyint
);

CREATE TABLE tb_nb_zik (
    nb_zik_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nb_zik_z_i_kirchenjahr int,
    nb_zik_notenblatt int
);

CREATE TABLE tb_nb_th (
    nb_th_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nb_th_thema int,
    nb_th_notenblatt int
);

/* Erstellen der Foreign Keys */
ALTER TABLE tb_notenblatt
ADD FOREIGN KEY (nb_katigorie) REFERENCES tb_katigorie(ka_id),
ADD FOREIGN KEY (nb_besetzung) REFERENCES tb_besetzung(be_id),
ADD FOREIGN KEY (nb_verlag) REFERENCES tb_verlag(ve_id);

ALTER TABLE tb_nb_zik
ADD FOREIGN KEY (nb_zik_notenblatt) REFERENCES tb_notenblatt(nb_id),
ADD FOREIGN KEY (nb_zik_z_i_kirchenjahr) REFERENCES tb_z_i_kirchenjahr(zik_id);

ALTER TABLE tb_nb_th
ADD FOREIGN KEY (nb_th_notenblatt) REFERENCES tb_notenblatt(nb_id),
ADD FOREIGN KEY (nb_th_thema) REFERENCES tb_thema(th_id);

/* Erstellen des Admin Account */
INSERT INTO `tb_user` (`us_username`, `us_passwort`, `us_berechtigung`) VALUES ('Admin', '$2y$10$hx6nSeiQ3leXadf3X1CfHeHvvPtxgK2lg8Z5f6o.coCPWmKhgDiDO', '127')