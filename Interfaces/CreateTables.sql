/*************************************************************/
/* ARCHIVO DE CREACION DE LAS TABLAS CORRESPONDIENTES AL     */
/* PROYECTO DE BBDD E INTERFAZ PARA LA GESTION INTERNA DE LA */
/* ASOCIACION SPECIAL OLYMPICS ARAGON.                       */
/*************************************************************/


-- SQLINES DEMO ***  DE TABLAS (revisar orden inverso)
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



/* Cuando se inserta o se actualiza un registro por fecha de alta, actualizar la tabla de históricos
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



/* OJO, a partir de aquí revisar nuevamente campos, Fkeys... */


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




/*
    VAMOS A TENER QUE REALIZAR UN TRIGGER POR CADA TABLA PARA COMPROBAR QUE LA ID DE ACTIVIDAD
NO ESTÁ YA EN UNA DE LAS ESPECIALIZACIONES

CREAR UNA VISTA CON TODOS LOS IDs de Actividad especializados. SELECT COUNT(*) INTO USOS WHERE ID = :New.ID<Tabla>
SI USOS NO ES 0, El id ya está especializado.

SELECT ACTIVIDAD_ID FROM ACTIVIDAD WHERE ACTIVIDAD_ID IN () OR () OR ()


HACER UNA TABLA DESNORMALIZADA EN LA QUE IR AÑADIENDO ESOS IDs USADOS
*/
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

DELIMITER ;