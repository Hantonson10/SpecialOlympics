/*************************************************************/
/* ARCHIVO DE CREACION DE LAS TABLAS CORRESPONDIENTES AL     */
/* PROYECTO DE BBDD E INTERFAZ PARA LA GESTION INTERNA DE LA */
/* ASOCIACION SPECIAL OLYMPICS ARAGON.                       */
/*************************************************************/


-- DROPs DE TABLAS (revisar orden inverso)
/*
DROP TABLE HISTORICO_ESTADO;
DROP TABLE RRSS;
DROP TABLE Manejar;
DROP TABLE FORMACION;
DROP TABLE Estudiar;
DROP TABLE DOCUMENTO_TIPO;
DROP TABLE DOCUMENTOS;
DROP TABLE Prestar;
DROP TABLE MATERIAL;
DROP TABLE ENTRENAMIENTO;
DROP TABLE Disponer;
DROP TABLE Participar;
DROP TABLE Emplear;
DROP TABLE ACTIVIDAD;
DROP TABLE MATERIAL_ACT;
DROP TABLE TEMPORADA;
DROP TABLE DEPORTE;
DROP TABLE SEDE;
DROP TABLE CAMPUS;
DROP TABLE EVENTO;
DROP TABLE APS;
DROP TABLE CHARLA;
DROP TABLE PRENDA;
DROP TABLE VOLUNTARIO;
*/


-- TABLA VOLUNTARIO  -  ok en mysql
CREATE TABLE VOLUNTARIO (
    voluntario_id INT AUTO_INCREMENT,
    voluntario_nombre VARCHAR(25) NOT NULL,
    voluntario_apellidos VARCHAR(40) NOT NULL,
    voluntario_tel1 BIGINT NOT NULL,
    voluntario_tel2 BIGINT,
    voluntario_tel_emerg BIGINT,
    voluntario_f_alta datetime,  /*cambiar desde HISTORICO_ESTADO*/
    voluntario_f_baja datetime, /*Si no está de baja, será null*/
    voluntario_f_nac datetime NOT NULL,
    voluntario_dni VARCHAR(9) NOT NULL CHECK(voluntario_dni REGEXP '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]') /*(voluntario_dni like '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]')*/,
    voluntario_foto VARCHAR(500),
    voluntario_mail VARCHAR(50) NOT NULL,
    voluntario_ocupacion VARCHAR(40),
    voluntario_hobbies VARCHAR(300),
    voluntario_direccion VARCHAR(80),
    voluntario_cpostal INT,
    voluntario_tall_camiseta VARCHAR(3)
	CHECK (voluntario_tall_camiseta like 'XS' OR voluntario_tall_camiseta like 'S' OR voluntario_tall_camiseta like 'M' OR voluntario_tall_camiseta like 'L'
		OR voluntario_tall_camiseta like 'XL' OR voluntario_tall_camiseta like 'XXL'),
    voluntario_tall_pie TINYINT CHECK (voluntario_tall_pie BETWEEN 2 AND 60),
    voluntario_tall_pantalon TINYINT CHECK (voluntario_tall_pantalon BETWEEN 2 AND 60),
    PRIMARY KEY (voluntario_id),
    UNIQUE (voluntario_nombre, voluntario_apellidos),
    UNIQUE (voluntario_tel1),
    UNIQUE (voluntario_mail)
);



-- TABLA HISTORICO_ESTADO  -  ok en mysql
CREATE TABLE HISTORICO_ESTADO (
	historico_estado_id INT AUTO_INCREMENT,
	historico_estado_voluntario_id INT NOT NULL,
	historico_estado_historico VARCHAR(25) NOT NULL,
	historico_estado_fecha DATETIME NOT NULL,
	PRIMARY KEY (historico_estado_id),
	FOREIGN KEY (historico_estado_voluntario_id) REFERENCES VOLUNTARIO (voluntario_id)
);

CREATE TABLE USUARIO(
    usuario_id SMALLINT AUTO_INCREMENT,
    usuario_voluntario INT NOT NULL,
    usuario_password VARCHAR(32) NOT NULL,
    usuario_estado VARCHAR(1) CHECK (usuario_estado = 'S' OR usuario_estado = 'N'),
    PRIMARY KEY (usuario_id),
    FOREIGN KEY (usuario_voluntario) REFERENCES VOLUNTARIO(voluntario_id)
);

/*	Cuando se inserta o se actualiza un registro por fecha de alta, actualizar la tabla de históricos
	Creo que el campo historico_estado_historico es confuso, podria ser historico_estado_anterior?
*/



-- TABLA FORMACION  -  ok en mysql
CREATE TABLE FORMACION (
    formacion_id SMALLINT AUTO_INCREMENT,
    formacion_nombre VARCHAR(100) NOT NULL,
    formacion_descripcion VARCHAR(200),
    formacion_horas INT NOT NULL,
    formacion_entidad VARCHAR(50),
    PRIMARY KEY (formacion_id)
);



-- TABLA Estudiar  -  ok en mysql
CREATE TABLE Estudiar(
    estudiar_voluntario_id INT NOT NULL,
    estudiar_formacion_id SMALLINT NOT NULL,
    estudiar_fecha DATE NOT NULL,
    FOREIGN KEY (estudiar_voluntario_id) REFERENCES VOLUNTARIO (voluntario_id),
    FOREIGN KEY (estudiar_formacion_id) REFERENCES FORMACION (formacion_id)
);


-- TABLA RRSS  -  ok en mysql
CREATE TABLE RRSS(
    rrss_id INT AUTO_INCREMENT,
    rrss_nombre VARCHAR(15) NOT NULL,
    PRIMARY KEY (rrss_id)
);


-- TABLA MANEJAR  -  ok en mysql
CREATE TABLE MANEJAR(
    manejar_username VARCHAR(30),
    manejar_rrss INT NOT NULL,
    manejar_voluntario int NOT NULL,
    PRIMARY KEY (manejar_username),
    FOREIGN KEY (manejar_rrss) REFERENCES RRSS (rrss_id),
    FOREIGN KEY (manejar_voluntario) REFERENCES VOLUNTARIO (voluntario_id)
);


-- TABLA TIPO DE DOCUMENTO  -  ok en mysql
CREATE TABLE DOCUMENTO_TIPO(
    documento_tipo_id SMALLINT AUTO_INCREMENT,
    documento_tipo_nombre VARCHAR(50) NOT NULL,
    CONSTRAINT PK_DOCUMENTO_TIPO_ID PRIMARY KEY (documento_tipo_id)
);



-- TABLA DOCUMENTO  -  ok en mysql
CREATE TABLE DOCUMENTO(
    documento_id INT AUTO_INCREMENT,
    documento_url VARCHAR(500) NOT NULL,
    documento_voluntario INT NOT NULL,
    documento_tipo SMALLINT NOT NULL,
    PRIMARY KEY (documento_id),
    UNIQUE (documento_voluntario, documento_tipo),
    FOREIGN KEY (documento_voluntario) REFERENCES VOLUNTARIO (voluntario_id)
);



-- TABLA MATERIAL  -  ok en mysql
CREATE TABLE MATERIAL(
    material_id INT AUTO_INCREMENT,
    material_nombre VARCHAR(25) NOT NULL,
    material_descripcion VARCHAR(100) NOT NULL,
    material_motivo VARCHAR(15),
    material_cantidad SMALLINT NOT NULL,
    PRIMARY KEY (material_id)
);


-- TABLA PRENDA (ESPECIALIZACION DE MATERIAL)  -  ok en mysql
CREATE TABLE PRENDA(
    prenda_id INT,
    prenda_observacion VARCHAR(100),
    PRIMARY KEY (prenda_id),
    FOREIGN KEY (prenda_id) REFERENCES MATERIAL (material_id)
);


-- TABLA MATERIAL_ACT (ESPECIALIZACION DE MATERIAL)  -  ok en mysql
CREATE TABLE MATERIAL_ACT (
    material_act_id INT,
    mat_act_observacion VARCHAR(100),
    PRIMARY KEY (material_act_id),
    FOREIGN KEY (material_act_id) REFERENCES MATERIAL (material_id)
);


-- TABLA PRESTAR  -  ok en mysql
CREATE TABLE PRESTAR (
    prestar_material INT,
    prestar_voluntario INT,
    prestar_cantidad SMALLINT CHECK (prestar_cantidad > 0),
    prestar_fecha_entrega datetime NOT NULL,
    prestar_fecha_devolucion datetime CHECK (prestar_fecha_devolucion >= prestar_fecha_entrega),
    PRIMARY KEY (prestar_material, prestar_voluntario),
    FOREIGN KEY (prestar_material) REFERENCES MATERIAL (material_id),
    FOREIGN KEY (prestar_voluntario) REFERENCES VOLUNTARIO (voluntario_id)
);




-- TABLA DEPORTE  -  ok en mysql
CREATE TABLE DEPORTE (
    deporte_id SMALLINT AUTO_INCREMENT,
    deporte_nombre VARCHAR(50) NOT NULL,
    PRIMARY KEY (deporte_id),
    UNIQUE (deporte_nombre)
);



-- TABLA TEMPORADA  -  ok en mysql
CREATE TABLE TEMPORADA (
    temporada_id TINYINT AUTO_INCREMENT,
    temporada_nombre VARCHAR (9) NOT NULL,
    PRIMARY KEY (temporada_id),
    UNIQUE (temporada_nombre)
);


-- TABLA Disponer  -  ok en mysql
CREATE TABLE Disponer(
    disponer_temporada TINYINT,
    disponer_deporte SMALLINT,
    PRIMARY KEY (disponer_temporada, disponer_deporte),
    FOREIGN KEY (disponer_temporada) REFERENCES TEMPORADA (temporada_id),
    FOREIGN KEY (disponer_deporte) REFERENCES DEPORTE (deporte_id)   
);




-- TABLA ACTIVIDAD
CREATE TABLE ACTIVIDAD (
    actividad_id SMALLINT AUTO_INCREMENT,
    actividad_duracion INT NOT NULL, /*horas*/
    actividad_lugar VARCHAR(50) NOT NULL,
    actividad_fecha DATETIME NOT NULL,
    actividad_temporada TINYINT NOT NULL,
    PRIMARY KEY (actividad_id),
    FOREIGN KEY (actividad_temporada) REFERENCES TEMPORADA (temporada_id)
);




-- TABLA ENTRENAMIENTO
CREATE TABLE ENTRENAMIENTO (
    entrenamiento_actividad SMALLINT,
    PRIMARY KEY (entrenamiento_actividad),
    FOREIGN KEY (entrenamiento_actividad) REFERENCES ACTIVIDAD (actividad_id)
);


-- TABLA SEDE
CREATE TABLE SEDE (
    sede_actividad SMALLINT,
    PRIMARY KEY (sede_actividad),
    FOREIGN KEY (sede_actividad) REFERENCES ACTIVIDAD (actividad_id)
);


-- TABLA CAMPUS
CREATE TABLE CAMPUS (
    campus_actividad SMALLINT,
    PRIMARY KEY (campus_actividad),
    FOREIGN KEY (campus_actividad) REFERENCES ACTIVIDAD (actividad_id)
);


-- TABLA EVENTO
CREATE TABLE EVENTO (
    evento_actividad SMALLINT,
    PRIMARY KEY (evento_actividad),
    FOREIGN KEY (evento_actividad) REFERENCES ACTIVIDAD (actividad_id)
);


-- TABLA APS
CREATE TABLE APS (
    aps_actividad SMALLINT,
    PRIMARY KEY (aps_actividad),
    FOREIGN KEY (aps_actividad) REFERENCES ACTIVIDAD (actividad_id)
);


-- TABLA CHARLA
CREATE TABLE CHARLA (
    charla_actividad SMALLINT,
    PRIMARY KEY (charla_actividad),
    FOREIGN KEY (charla_actividad) REFERENCES ACTIVIDAD(actividad_id)
);



-- TABLA EMPLEAR (EMPLEAR MATERIAL EN UNA ACTIVIDAD)
CREATE TABLE EMPLEAR (
    emplear_actividad SMALLINT,
    emplear_material_act INT,
    PRIMARY KEY (emplear_actividad, emplear_material_act),
    FOREIGN KEY (emplear_actividad) REFERENCES ACTIVIDAD (actividad_id),
    FOREIGN KEY (emplear_material_act) REFERENCES MATERIAL_ACT (material_act_id)
);










-- TRIGGERS DE ACTIVIDAD
CREATE VIEW ACTIVIDADES_USADAS AS (
	SELECT actividad_id FROM ACTIVIDAD, CHARLA, APS, EVENTO, CAMPUS, SEDE, ENTRENAMIENTO
	WHERE actividad_id = charla_actividad OR actividad_id = aps_actividad OR actividad_id = evento_actividad 
	OR actividad_id = campus_actividad OR actividad_id = sede_actividad OR actividad_id = entrenamiento_actividad
);





DELIMITER //

CREATE TRIGGER `CHECKCHARLA`
BEFORE INSERT ON `CHARLA`
FOR EACH ROW
BEGIN
	DECLARE v_numOfOcurrencies INT;
    SELECT COUNT(*) INTO v_numOfOcurrencies FROM ACTIVIDADES_USADAS WHERE NEW.charla_actividad = actividad_id;
	IF v_numOfOcurrencies <> 0 THEN
		signal sqlstate '20000' set message_text = 'La actividad ya se ha definido';
    END IF;
END //





CREATE TRIGGER `CHECKAPS`
BEFORE INSERT ON `APS`
FOR EACH ROW
BEGIN
	DECLARE v_numOfOcurrencies INT;
    SELECT COUNT(*) INTO v_numOfOcurrencies FROM ACTIVIDADES_USADAS WHERE NEW.aps_actividad = actividad_id;
	IF v_numOfOcurrencies <> 0 THEN
		signal sqlstate '20000' set message_text = 'La actividad ya se ha definido';
    END IF;
END //





CREATE TRIGGER `CHECKEVENTO`
BEFORE INSERT ON `EVENTO`
FOR EACH ROW
BEGIN
	DECLARE v_numOfOcurrencies INT;
    SELECT COUNT(*) INTO v_numOfOcurrencies FROM ACTIVIDADES_USADAS WHERE NEW.evento_actividad = actividad_id;
	IF v_numOfOcurrencies <> 0 THEN
		signal sqlstate '20000' set message_text = 'La actividad ya se ha definido';
    END IF;
END //





CREATE TRIGGER `CHECKCAMPUS`
BEFORE INSERT ON `CAMPUS`
FOR EACH ROW
BEGIN
	DECLARE v_numOfOcurrencies INT;
    SELECT COUNT(*) INTO v_numOfOcurrencies FROM ACTIVIDADES_USADAS WHERE NEW.campus_actividad = actividad_id;
	IF v_numOfOcurrencies <> 0 THEN
		signal sqlstate '20000' set message_text = 'La actividad ya se ha definido';
    END IF;
END //





CREATE TRIGGER `CHECKSEDE`
BEFORE INSERT ON `SEDE`
FOR EACH ROW
BEGIN
	DECLARE v_numOfOcurrencies INT;
    SELECT COUNT(*) INTO v_numOfOcurrencies FROM ACTIVIDADES_USADAS WHERE NEW.sede_actividad = actividad_id;
	IF v_numOfOcurrencies <> 0 THEN
		signal sqlstate '20000' set message_text = 'La actividad ya se ha definido';
    END IF;
END //




CREATE TRIGGER `CHECKENTRENAMIENTO`
BEFORE INSERT ON `ENTRENAMIENTO`
FOR EACH ROW
BEGIN
	DECLARE v_numOfOcurrencies INT;
    SELECT COUNT(*) INTO v_numOfOcurrencies FROM ACTIVIDADES_USADAS WHERE NEW.entrenamiento_actividad = actividad_id;
	IF v_numOfOcurrencies <> 0 THEN
		signal sqlstate '20000' set message_text = 'La actividad ya se ha definido';
    END IF;
END //

CREATE TRIGGER `UPDATEHISTORIAL`
BEFORE UPDATE ON `VOLUNTARIO`
FOR EACH ROW
BEGIN
    DECLARE v_LastEstado VARCHAR(10);
    IF (OLD.voluntario_f_baja IS NULL AND NEW.voluntario_f_baja IS NOT NULL) OR (OLD.voluntario_f_baja IS NOT NULL AND NEW.voluntario_f_baja IS NULL) THEN
        SELECT historico_estado_historico INTO v_LastEstado FROM HISTORICO_ESTADO
            WHERE historico_estado_fecha = (SELECT MAX(historico_estado_fecha) FROM `HISTORICO_ESTADO` WHERE historico_estado_voluntario_id = NEW.voluntario_id)
                AND historico_estado_voluntario_id = NEW.voluntario_id;

        IF (NEW.voluntario_f_baja IS NULL AND v_LastEstado NOT LIKE '%BAJA%') OR (NEW.voluntario_f_baja IS NOT NULL AND v_LastEstado NOT LIKE '%ALTA%') THEN
            signal sqlstate '20001' set message_text = 'No se puede reasignar un estado en el que ya se encuentra';
        ELSE
            IF NEW.voluntario_f_baja IS NULL THEN
                INSERT INTO HISTORICO_ESTADO(historico_estado_voluntario_id,historico_estado_historico,historico_estado_fecha) VALUES(NEW.voluntario_id,'ALTA',now());
            ELSE
                INSERT INTO HISTORICO_ESTADO(historico_estado_voluntario_id,historico_estado_historico,historico_estado_fecha) VALUES(NEW.voluntario_id,'BAJA',now());
            END IF;
        END IF;
    END IF;
END //


CREATE TRIGGER `CREATEHISTORIALFIRSTVAL`
AFTER INSERT ON `VOLUNTARIO`
FOR EACH ROW
BEGIN
    INSERT INTO HISTORICO_ESTADO(historico_estado_voluntario_id,historico_estado_historico,historico_estado_fecha) VALUES(NEW.voluntario_id,'ALTA',NEW.voluntario_f_alta);
END //


CREATE TRIGGER ADD_USR_FROM_VOL
AFTER INSERT ON VOLUNTARIO
FOR EACH ROW
BEGIN
    INSERT INTO USUARIO(usuario_voluntario,usuario_password,usuario_estado) VALUES(NEW.voluntario_id, MD5('acceso'), 'N');
END //


CREATE FUNCTION `LOGIN`(`v_email` VARCHAR(50)) RETURNS JSON
BEGIN
    DECLARE v_pwd varchar(32);
    DECLARE v_activo varchar(1);
    SELECT usuario_password, usuario_estado INTO v_pwd, v_activo FROM usuario INNER JOIN voluntario ON voluntario_id = usuario_voluntario WHERE voluntario_mail = v_email;
    RETURN JSON_ARRAY(v_pwd, v_activo);
END //

DELIMITER ;



-- Inserts tabla VOLUNTARIO
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lolo','Loles Lales','976237016','976446898','976733863','2022-02-01',NULL,'1995-01-29','60575564G','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lolo@gmail.com','Trabajando','Bailar,leer y escribir','C/Laloles 23',50016,'L',42,40);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lola','Lolas Lolas','976237017','976446899','976733864','2022-02-02',NULL,'1995-01-30','60575564H','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lola@gmail.com','albañil','Bailar,leer y escribir','C/Lolales 24',50017,'XL',44,41);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lelo','Lelos Lelos','976237018','976446900','976733865','2022-02-02',NULL,'1995-01-31','60575564J','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lelo@gmail.com','pintor','Bailar,leer y escribir','C/Leloles 25',50018,'XS',38,38);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lela','Lelas Lelas','976237019','976446901','976733866','2022-02-03',NULL,'1995-02-01','60575564K','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lela@gmail.com','actriz','Bailar,leer y escribir','C/Lelales 26',50019,'S',38,39);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lila','Lilas Lilas','976237020','976446902','976733867','2022-02-04',NULL,'1995-02-02','60575564L','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lila@gmail.com','profesora','Bailar,leer y escribir','C/Lilales 27',50020,'M',40,40);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lula','Lulas Lulas','976237021','976446903','976733868','2022-02-05',NULL,'1995-02-03','60575564M','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lula@gmail.com','asistenta','Bailar,leer y escribir','C/Lulales 28',50021,'M',40,39);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lulu','Lulus Lulus','976237022','976446904','976733869','2022-02-06',NULL,'1995-02-04','60575564N','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lulu@gmail.com','enfermera','Bailar,leer y escribir','C/Lulules 29',50022,'M',42,40);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lalo','Lalos Lalos','976237023','976446905','976733870','2022-02-07',NULL,'1995-02-05','60575564P','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lalo@gmail.com','medico','Bailar,leer y escribir','C/Laloles 30',50001,'L',40,42);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lale','Lales Lales','976237024','976446906','976733871','2022-02-08',NULL,'1995-02-06','60575564Q','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lale@gmail.com','bombero','Bailar,leer y escribir','C/Laleles 31',50002,'L',40,42);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lele','Leles Leles','976237025','976446907','976733872','2022-02-09',NULL,'1995-02-07','60575564R','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lele@gmail.com','torero','Bailar,leer y escribir','C/Leleles 32',50003,'L',42,44);
INSERT INTO `voluntario`(`voluntario_nombre`, `voluntario_apellidos`, `voluntario_tel1`, `voluntario_tel2`, `voluntario_tel_emerg`, `voluntario_f_alta`, `voluntario_f_baja`, `voluntario_f_nac`, `voluntario_dni`, `voluntario_foto`, `voluntario_mail`, `voluntario_ocupacion`, `voluntario_hobbies`, `voluntario_direccion`, `voluntario_cpostal`, `voluntario_tall_camiseta`, `voluntario_tall_pantalon`, `voluntario_tall_pie`)
VALUES ('Lelu','Lelus Lelus','976237026','976446908','976733873','2022-02-10',NULL,'1995-02-08','60575564S','https://cdn.pixabay.com/photo/2018/05/01/16/19/young-man-3366016_960_720.jpg','lelu@gmail.com','conductor','Bailar,leer y escribir','C/Lelules 33',50004,'XL',42,44);



-- Inserts tabla FORMACION
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Charla basica SOA','Charla primeros auxilios',3,'SOA');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Charla basica SOE','Monitor tiempo libre',2,'SOE');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Monitor de tiempo libre','Cursillo para ser moniotr',5,'SOE');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Director de tiempo libre','Cursillo para ser director',7,'SOA');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Trabajo con disminuidos fisicos','Curso para trabajar con disminuidos fisicos',20,'SOA');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Trabajo con disminuidos psiquicos','Curso para trabajar con disminuidos psiquicos',30,'SOE');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Gestión de Oficinas','Curso para gestionar y administrar oficinas',30,'ASPANOA');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Trabajo con disminuidos fisicos','Curso para trabajar con disminuidos fisicos',20,'SOA');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Gestion Interna SOA','Curso para gestionar la oficina de SOA',10,'SOA');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Gestion de Actividades SOA','Curso para gestionar las Actividades deSOA',10,'SOA');
INSERT INTO `formacion`(`formacion_nombre`, `formacion_descripcion`, `formacion_horas`, `formacion_entidad`) VALUES ('Trabajo con personas con movildad reducida','Curso para trabajar con personas con movilidad reducida',15,'DFA');

-- Inserts tabla Estudiar (no hay)


-- Inserts tabla RSS
INSERT INTO `rrss`(`rrss_nombre`) VALUES ('Instagram');
INSERT INTO `rrss`(`rrss_nombre`) VALUES ('Facebook');
INSERT INTO `rrss`(`rrss_nombre`) VALUES ('Twitter');
INSERT INTO `rrss`(`rrss_nombre`) VALUES ('Snapchat');



-- Inserts tabla manejar
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('LolitoXd',1,1);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserX123',2,2);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserY456',3,3);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserZ789',4,4);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserA234',1,5);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserB456',2,6);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserD678',3,7);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserE789',4,8);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserF123',1,9);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserG456',2,10);
INSERT INTO `manejar`(`manejar_username`, `manejar_rrss`, `manejar_voluntario`) VALUES ('UserH567',3,11);



-- Inserts tabla DOCUMENTO_TIPO
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Certificado delitos sexuales');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Compromiso');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Certificado vacunación');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('DNI');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Autorización imágen y protección de datos');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Autorización menor de edad');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Otros documentos');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Autorización certificado delitos sexuales mayor de edad');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Autorización certificado delitos sexuales menor de edad');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('Fotocopia libro de familia');
INSERT INTO `documento_tipo`(`documento_tipo_nombre`) VALUES ('DNI padre');



-- Inserts tabla DOCUMENTO
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',1,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',1,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',1,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',1,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',1,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',1,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',1,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',1,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',1,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',1,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',1,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',1,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',2,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',2,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',2,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',2,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',2,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',2,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',2,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',2,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',2,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',2,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',2,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',2,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',3,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',3,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',3,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',3,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',3,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',3,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',3,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',3,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',3,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',3,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',3,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',3,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',4,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',4,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',4,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',4,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',4,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',4,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',4,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',4,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',4,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',4,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',4,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',4,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',5,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',5,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',5,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',5,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',5,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',5,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',5,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',5,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',5,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',5,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',5,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',5,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',6,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',6,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',6,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',6,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',6,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',6,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',6,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',6,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',6,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',6,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',6,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',6,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',7,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',7,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',7,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',7,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',7,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',7,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',7,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',7,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',7,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',7,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',7,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',7,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',8,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',8,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',8,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',8,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',8,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',8,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',8,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',8,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',8,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',8,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',8,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',8,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',9,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',9,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',9,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',9,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',9,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',9,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',9,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',9,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',9,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',9,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',9,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',9,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',10,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',10,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',10,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',10,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',10,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',10,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',10,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',10,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',10,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',10,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',10,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',10,12);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento1_url',11,1);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento2_url',11,2);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento3_url',11,3);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento4_url',11,4);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento5_url',11,5);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento6_url',11,6);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento7_url',11,7);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento8_url',11,8);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento9_url',11,9);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento10_url',11,10);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento11_url',11,11);
INSERT INTO `documento`(`documento_url`, `documento_voluntario`, `documento_tipo`) VALUES ('documento12_url',11,12);




-- Inserts tabla MATERIAL
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Balón','Balón de fútbol','Jornada de futbol',10);
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Raqueta tenis','Raqueta para jugar al tenis','Jornada de tenis',15);
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Raqueta de padel','Raqueta para jugar a padel','Jornada de padel',20);
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Balón de baloncesto','Balón para jugar a baloncesto','Jornada de baloncesto',30);
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Raqueta de Bádminton','Raqueta para jugar a Bádminton','Jornada de bádminton',40); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Camiseta manga corta','Camiseta SOA','Charla',30); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Pantalon corto','Pantalón SOA','Charla SOA',30); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Zapatillas deportivas','Zapatillas deportivas SOA','Charla SOA',30); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Gorras','Gorras SOA','Charla SOA',30); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Petos','Petos SOA','Jornada de futbol SOA',20); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Chandal largo completo','Chandal largo completo','Charla SOA',60); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Volantes de bádminton','Volante de bádminton','Jornada bádminton',20); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Raquetas de ping pong','Raquetas de ping pong','Jornada de ping pong',20); 
INSERT INTO `material`(`material_nombre`, `material_descripcion`, `material_motivo`, `material_cantidad`) VALUES ('Pelotas de ping pong','Pelotas de ping pong','Jornada de ping pong',40);


-- Inserts Tabla Prenda
INSERT INTO `prenda`(`prenda_id`, `prenda_observacion`) VALUES (6,'Camisetas de manga corta de SpecialOlympics Aragón , de color blanco con el logo de la asociación en color rojo en el medio');
INSERT INTO `prenda`(`prenda_id`, `prenda_observacion`) VALUES (7,'Pantalón corto SpecialOlympics Aragón , de color blanco con el logo de la asociación en color rojo en el lateral');
INSERT INTO `prenda`(`prenda_id`, `prenda_observacion`) VALUES (8,'Zaptillas de deporte , de color blanco con la suela de color rojo');
INSERT INTO `prenda`(`prenda_id`, `prenda_observacion`) VALUES (9,'Gorras de color blanco');
INSERT INTO `prenda`(`prenda_id`, `prenda_observacion`) VALUES (10,'Petos fosforitos para mantener un control visual sobre las personas de la asociación en jornadas multitudinarias');
INSERT INTO `prenda`(`prenda_id`, `prenda_observacion`) VALUES (11,'Conjunto de chandal largo completo , de color blanco con trazados rojos');


-- Inserts Tabla MATERIAL_ACT
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (1,'Balones de futbol de cuero poliuretano');
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (2,'Raquetas de tenis ligeras');
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (3,'Raquetas de padel en formato redondo');
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (4,'Balónes de balonesto Spalding');
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (5,'Raquetas de bádminton');
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (12,'Voltantes de bádminton sintéticos de naylon');
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (13,'Palas de ping pong lisas');
INSERT INTO `material_act`(`material_act_id`, `mat_act_observacion`) VALUES (14,'Pelotas de ping pong blancas');





-- Inserts tabla Prestar
-- Ideas: Caso de INSERT de error , en el formato fecha poner en el segundo campo el día es decir año-día-mes
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (1,1,2,'2022-03-14','2022-03-16');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (2,1,4,'2022-03-14','2022-03-16');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (3,1,10,'2022-04-14','2022-04-16');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (1,2,10,'2022-04-15','2022-04-16');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (2,2,9,'2022-04-16','2022-04-17');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (3,2,8,'2022-04-10','2022-04-18');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (4,2,2,'2022-04-11','2022-04-12');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (5,3,9,'2022-03-14','2022-03-16');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (6,3,7,'2022-03-10','2022-03-12');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (4,4,6,'2022-03-10','2022-03-12');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (5,4,5,'2022-03-10','2022-03-12');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (10,4,5,'2022-03-10','2022-03-12');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (10,5,5,'2022-02-10','2022-02-11');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (9,5,7,'2022-02-11','2022-02-12');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (8,5,10,'2022-02-08','2022-02-09');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (5,5,8,'2022-02-04','2022-02-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (5,6,20,'2022-01-04','2022-01-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (4,6,20,'2022-01-04','2022-01-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (7,7,10,'2022-01-04','2022-01-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (7,8,20,'2022-01-02','2022-01-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (6,8,15,'2022-02-04','2022-02-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (5,8,12,'2022-03-05','2022-03-07');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (4,8,11,'2022-01-04','2022-01-08');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (3,8,1,'2022-01-02','2022-01-07');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (3,9,10,'2022-10-03','2022-10-04');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (4,9,4,'2022-10-02','2022-10-07');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (2,10,10,'2022-11-03','2022-11-04');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (2,11,7,'2022-11-03','2022-11-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (3,11,5,'2022-08-03','2022-08-05');
INSERT INTO `prestar`(`prestar_material`, `prestar_voluntario`, `prestar_cantidad`, `prestar_fecha_entrega`, `prestar_fecha_devolucion`) VALUES (6,11,11,'2022-09-03','2022-09-06');








-- Inserts tabla DEPORTE
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Futbol 7');
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Acondicionamiento físico general');
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Running');
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Padel');
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Tenis');
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Petanca');
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Gimnasia Rítmica');
INSERT INTO `deporte`(`deporte_nombre`) VALUES ('Natación');



-- Inserts tabla TEMPORADA
INSERT INTO `temporada`(`temporada_nombre`) VALUES ('2019-2020');
INSERT INTO `temporada`(`temporada_nombre`) VALUES ('2020-2021');
INSERT INTO `temporada`(`temporada_nombre`) VALUES ('2021-2022');




-- Inserts tabla Disponer
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,1);
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,2);
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,3);
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,4);
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,5);
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,6);
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,7);
INSERT INTO `disponer`(`disponer_temporada`, `disponer_deporte`) VALUES (3,8);




-- Inserts tabla ACTIVIDAD
-- 1
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (20,'Pabellon Almozara Entrenamiento','2022-02-07', 3);
-- 2
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (10,'Sede SOA','2022-03-06', 3);
-- 3
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (30,'Pabellon La Granja Entrenamiento','2021-12-13', 3);
-- 4
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (15,'CaixaForum Evento','2022-01-20', 3);
-- 5
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (5,'Sede SOA','2022-01-08', 3);
-- 6
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Pabellon Monsalud Entrenamiento','2022-02-21', 3);
-- 7
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Centro San Valero Charla','2022-01-25', 3);
-- 8
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Colegio Marianistas Charla','2021-11-09', 3);
-- 9
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (20,'Pabellon Almozara Campus','2022-02-08', 3);
-- 10
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (30,'Pabellon La Granja Campus','2022-01-07', 3);
-- 11
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Colegio La Salle Entrenamiento','2021-12-13', 3);
-- 12
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (4,'Plaza San Francisco Evento','2022-02-09', 3);
-- 13
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (4,'Plaza Aragón Evento','2022-02-10', 3);
-- 14
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (4,'Plaza España Evento','2022-02-11', 3);
-- 15
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (60,'El Olivar Campus','2022-09-15', 3);
-- 16
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (45,'Stadium Casablanca Campus','2021-12-21', 3);
-- 17
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (15,'Stadium Casablanca Campus','2022-01-02', 3);
-- 18
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Colegio Romareda Charla','2022-01-10', 3);
-- 19
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (15,'Stadium Casablanca Campus','2022-01-02', 3);
-- 20
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (45,'USJ Entrenamiento','2022-02-01', 3);
-- 21
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (5,'Trabajo Sede SOA','2022-02-05', 3);
-- 22
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (3,'Trabajo Sede SOA','2022-03-10', 3);
-- 23
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Colegio Agustinos Charla','2022-01-17', 3);
-- 24
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Colegio Salesianos Charla','2022-01-19', 3);
-- 25
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Colegio Franciscanas Charla','2022-01-21', 3);
-- 26
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Colegio Mercedarias Charla','2022-01-23', 3);
-- 27
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (1,'Sede SOA APS','2022-02-03', 3);
-- 28
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Sede SOA APS','2022-02-05', 3);
-- 29
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (3,'Sede SOA APS','2022-02-07', 3);
-- 30
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (1,'Sede SOA APS','2022-02-09', 3);
-- 31
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Sede SOA APS','2022-02-11', 3);
-- 32
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (3,'Sede SOA APS','2022-02-13', 3);
-- 33
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (1,'Sede SOA APS','2022-02-15', 3);
-- 34
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (1,'CC Augusta Evento','2022-02-17', 3);
-- 35
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'CC GranCasa Evento','2022-02-19', 3);
-- 36
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (3,'CC PuertoVenecia Evento','2022-02-17', 3);
-- 37
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (1,'CC El Caracol Evento','2022-02-21', 3);
-- 38
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'CC Aragonia Evento','2022-02-23', 3);
-- 39
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (5,'Club deportivo Helios Entrenamiento','2021-02-12', 3);
-- 40
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (7,'Club deportivo Helios Entrenamiento','2021-04-21', 3);
-- 41
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (8,'Stadium Casablanca Campus Campus','2021-12-01', 3);
-- 42
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (3,'Pabellón Príncipe Felipe Campus','2021-12-23', 3);
-- 43
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (2,'Pabellón Príncipe Felipe Campus','2021-11-13', 3);
-- 44
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (1,'El Olivar Evento','2021-01-26', 3);
-- 45
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (9,'El Olivar Evento','2021-02-17', 3);
-- 46
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (3,'La Granja APS','2021-01-17', 3);
-- 47
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (4,'S.D.Tiro de Pichón APS','2021-05-23', 3);
-- 48
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (5,'S.D.Tiro de Pichón Charla','2021-01-21', 3);
-- 49
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (6,'Stadium Venecia Charla','2021-04-08', 3);
-- 50
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (16,'Club Deportivo Santiago Entrenamiento','2021-05-16', 3);
-- 51
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (10,'Montecanal Centro Deportivo Campus','2021-07-07', 3);
-- 52
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (9,'Polideportivo San Agustín Evento','2021-08-20', 3);
-- 53
INSERT INTO `actividad`(`actividad_duracion`, `actividad_lugar`, `actividad_fecha`, `actividad_temporada`)
    VALUES (17,'Parque deportivo Ebro Evento','2021-08-11', 3);



-- Tablas Especificas de ACTIVIDADES

-- Inserts Específico ENTRENAMIENTO
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (1);
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (3);
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (6);
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (11);
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (20);
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (39);
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (40);
INSERT INTO `entrenamiento` (`entrenamiento_actividad`) VALUES (50);



-- Inserts Específico SEDE SOA
INSERT INTO `sede` (`sede_actividad`) VALUES (2);
INSERT INTO `sede` (`sede_actividad`) VALUES (5);
INSERT INTO `sede` (`sede_actividad`) VALUES (21);
INSERT INTO `sede` (`sede_actividad`) VALUES (22);



-- Inserts Específico CAMPUS
INSERT INTO `campus` (`campus_actividad`) VALUES (9);
INSERT INTO `campus` (`campus_actividad`) VALUES (10);
INSERT INTO `campus` (`campus_actividad`) VALUES (15);
INSERT INTO `campus` (`campus_actividad`) VALUES (16);
INSERT INTO `campus` (`campus_actividad`) VALUES (17);
INSERT INTO `campus` (`campus_actividad`) VALUES (19);
INSERT INTO `campus` (`campus_actividad`) VALUES (41);
INSERT INTO `campus` (`campus_actividad`) VALUES (42);
INSERT INTO `campus` (`campus_actividad`) VALUES (43);
INSERT INTO `campus` (`campus_actividad`) VALUES (51);



-- Inserts Específico EVENTO
INSERT INTO `evento` (`evento_actividad`) VALUES (4);
INSERT INTO `evento` (`evento_actividad`) VALUES (12);
INSERT INTO `evento` (`evento_actividad`) VALUES (13);
INSERT INTO `evento` (`evento_actividad`) VALUES (14);
INSERT INTO `evento` (`evento_actividad`) VALUES (34);
INSERT INTO `evento` (`evento_actividad`) VALUES (35);
INSERT INTO `evento` (`evento_actividad`) VALUES (36);
INSERT INTO `evento` (`evento_actividad`) VALUES (37);
INSERT INTO `evento` (`evento_actividad`) VALUES (38);
INSERT INTO `evento` (`evento_actividad`) VALUES (44);
INSERT INTO `evento` (`evento_actividad`) VALUES (45);
INSERT INTO `evento` (`evento_actividad`) VALUES (52);
INSERT INTO `evento` (`evento_actividad`) VALUES (53);



-- Inserts Específico APS

INSERT INTO `aps` (`aps_actividad`) VALUES (27);
INSERT INTO `aps` (`aps_actividad`) VALUES (28);
INSERT INTO `aps` (`aps_actividad`) VALUES (29);
INSERT INTO `aps` (`aps_actividad`) VALUES (30);
INSERT INTO `aps` (`aps_actividad`) VALUES (31);
INSERT INTO `aps` (`aps_actividad`) VALUES (32);
INSERT INTO `aps` (`aps_actividad`) VALUES (33);
INSERT INTO `aps` (`aps_actividad`) VALUES (46);
INSERT INTO `aps` (`aps_actividad`) VALUES (47);



-- Inserts Específico CHARLA
INSERT INTO `charla` (`charla_actividad`) VALUES (7);
INSERT INTO `charla` (`charla_actividad`) VALUES (8);
INSERT INTO `charla` (`charla_actividad`) VALUES (18);
INSERT INTO `charla` (`charla_actividad`) VALUES (23);
INSERT INTO `charla` (`charla_actividad`) VALUES (24);
INSERT INTO `charla` (`charla_actividad`) VALUES (25);
INSERT INTO `charla` (`charla_actividad`) VALUES (26);
INSERT INTO `charla` (`charla_actividad`) VALUES (48);
INSERT INTO `charla` (`charla_actividad`) VALUES (49);
