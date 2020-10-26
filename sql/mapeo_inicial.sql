

CREATE TABLE IF NOT EXISTS unicom (
    unicom_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , nomenclatura INT(4)
) ENGINE=InnoDb;

INSERT INTO unicom (unicom_id, denominacion, nomenclatura) VALUES
(1, 'LA RIOJA', 6110),
(2, 'CHILECITO', 6120),
(3, 'CHEPES', 6130),
(4, 'AIMOGASTA', 6150),
(5, 'CHAMICAL', 6160),
(6, 'VILLA UNIÓN', 6170);

CREATE TABLE IF NOT EXISTS gerencia (
    gerencia_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

INSERT INTO gerencia (gerencia_id, denominacion) VALUES
(1, 'Recursos Humanos'),
(2, 'Comercial'),
(3, 'CAR Comercial'),
(4, 'Administración'),
(5, 'Distribución'),
(6, 'Relaciones Institucionales'),
(7, 'Servicios Generales'),
(8, 'Gerencia Directorio'),
(9, 'DIRECCIÓN');


CREATE TABLE IF NOT EXISTS centrocosto (
    centrocosto_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , codigo INT(4)
    , denominacion VARCHAR(250)
    , gerencia INT(11)
    , INDEX(gerencia)
    , FOREIGN KEY (gerencia)
        REFERENCES gerencia (gerencia_id)
        ON DELETE SET NULL
) ENGINE=InnoDb;

INSERT INTO centrocosto (centrocosto_id, codigo, denominacion, gerencia) VALUES
(1, 6500, 'ALMACÉN', 4),
(2, 6200, 'CONTADURÍA', 4),
(3, 6360, 'COMPRAS', 4),
(4, 6000, 'EDELAR', 4),
(5, 6350, 'IMPUESTOS EDELAR', 4),
(6, 6300, 'TESORERÍA', 4),
(7, 7520, 'CALL CENTER', 2),
(8, 7047, 'CAR - LA RIOJA', 2),
(9, 7040, 'GESTIÓN DE LA ENERGÍA', 2),
(10, 7100, 'GRANDES DEMANDAS', 2),
(11, 7410, 'AIMOGASTA', 2),
(12, 7440, 'CHAMICAL', 2),
(13, 7420, 'CHEPES', 2),
(14, 7300, 'CHILECITO', 2),
(15, 7443, 'SANAGASTA', 2),
(16, 7430, 'VILLA UNIÓN', 2),
(17, 7045, 'LA RIOJA', 2),
(18, 7115, 'LA RIOJA P.DEMANDAS', 2),
(19, 7510, 'CAR - LABORATORIO', 2),
(20, 7704, 'CAR - LECTURA CHAMICAL', 2),
(21, 7703, 'CAR - LECTURA CHEPES', 2),
(22, 7705, 'CAR - LECTURA CHILECITO', 2),
(23, 7702, 'CAR - LECTURA LA RIOJA', 2),
(24, 7707, 'CAR - LECTURA VILLA UNIÓN', 2),
(25, 7506, 'CAR - SERVICIO TÉCNICO CHILECITO', 2),
(26, 7505, 'CAR - SERVICIO TÉCNICO', 2),
(27, 8095, 'CALIDAD, SIPRE Y ESTADÍSTICAS', 5),
(30, 8086, 'CAR CHILECITO', 5),
(31, 8083, 'CAR LA RIOJA', 5),
(32, 8087, 'CAR VILLA UNIÓN', 5),
(33, 8081, 'CAR CHAMICAL', 5),
(34, 8005, 'COMUNICACIONES', 5),
(35, 8084, 'CAR/CUADRILLA  AIMOGASTA', 5),
(36, 8604, 'CUADRILLA CHAMICAL', 5),
(37, 8602, 'CUADRILLA CHEPES', 5),
(38, 8605, 'CUADRILLA CHILECITO', 5),
(39, 8603, 'CUADRILLA LA RIOJA', 5),
(40, 8601, 'CUADRILLA VILLA UNIÓN', 5),
(41, 8320, 'EDELAR', 5),
(42, 8410, 'AIMOGASTA', 5),
(43, 8440, 'CHAMICAL', 5),
(44, 8420, 'CHEPES', 5),
(45, 8340, 'CHILECITO', 5),
(46, 8200, 'MANTENIMIENTO DEL SISTEMA', 5),
(47, 8300, 'OPERACIONES CMD', 5),
(48, 8020, 'PLANEAMIENTO DE RED BT y MT', 5),
(49, 8310, 'PROY. OBRAS Y NNSS', 5),
(50, 8014, 'TELECONT. Y PROTECCIONES', 5),
(51, 6400, 'SERV.GRALES', 7),
(52, 5020, 'ADMIN. CONTRATO', 8),
(53, 5000, 'ADMIN. CONCESIÓN', 8),
(54, 6605, 'TECNOL. INFOR. DBA', 8),
(55, 6620, 'TECNOL. INFOR. OPERADOR', 8),
(56, 5031, 'RRII', 6),
(57, 9100, 'ADMINIS. PER.', 1),
(58, 6455, 'RELACIONES LABORALES', 1),
(59, 9200, 'SEG. SALUD OCUPACIONAL Y M AMBIENTE', 1),
(60, 7046, 'ORGANISMOS OFICIALES', 2),
(61, 7048, 'GESTIÓN COMERCIAL', 2),
(62, 7441, 'COORDINACIÓN DE DISTRITOS', 2),
(63, 1, 'Dirección', 9);

CREATE TABLE IF NOT EXISTS menu (
    menu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , icon VARCHAR(50)
    , url VARCHAR(50)
) ENGINE=InnoDb;

INSERT INTO menu (menu_id, denominacion, icon, url) VALUES
(1, 'CONFIGURACIÓN', 'fa-cogs', '#');

CREATE TABLE IF NOT EXISTS submenu (
    submenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , icon VARCHAR(50)
    , url VARCHAR(50)
    , detalle VARCHAR(50)
    , menu INT(11)
    , INDEX(menu)
    , FOREIGN KEY (menu)
        REFERENCES menu (menu_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

INSERT INTO submenu (submenu_id, denominacion, icon, url, detalle, menu) VALUES
(1, 'Menú', 'fa-cogs', '#', '', 1),
(2, 'Usuarios', 'fa-users', '/usuario/agregar', '', 1);

CREATE TABLE IF NOT EXISTS item (
    item_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , detalle VARCHAR(100)
    , url VARCHAR(50)
    , submenu INT(11)
    , INDEX(submenu)
    , FOREIGN KEY (submenu)
        REFERENCES submenu (submenu_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

INSERT INTO item (item_id, denominacion,  detalle, url, submenu) VALUES
(1, 'Agregar Ítems', 'Agregar Ítems', '/menu/agregar', 1),
(2, 'Panel', 'Menú', '/menu/panel', 1);

CREATE TABLE IF NOT EXISTS configuracionmenu (
    configuracionmenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , nivel INT(11)
    , gerencia INT(11)
    , INDEX (gerencia)
    , FOREIGN KEY (gerencia)
        REFERENCES gerencia (gerencia_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;


INSERT INTO configuracionmenu (configuracionmenu_id, denominacion, nivel, gerencia) VALUES
(1, 'TI DESARROLLADOR', 9, 9),
(2, 'AUTORIZADOR', 1, 6),
(3, 'ADMINISTRADOR', 3, 9),
(4, 'DISTRIBUIDOR', 3, 9),
(5, 'REVISOR', 3, 9),
(6, 'CONTROLADOR', 3, 9),
(7, 'APROBADOR', 3, 9),
(8, 'CONSULTA', 1, 4),
(9, 'AUTORIZADOR_ADMIN', 1, 4),
(10, 'AUTORIZADOR-CONTROLADOR', 1, 4);

CREATE TABLE IF NOT EXISTS submenuconfiguracionmenu (
    submenuconfiguracionmenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES configuracionmenu (configuracionmenu_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES submenu (submenu_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

INSERT INTO submenuconfiguracionmenu (submenuconfiguracionmenu_id, compuesto, compositor) VALUES
(1, 3, 1),
(2, 3, 2);

CREATE TABLE IF NOT EXISTS itemconfiguracionmenu (
    itemconfiguracionmenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES configuracionmenu (configuracionmenu_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES item (item_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

INSERT INTO itemconfiguracionmenu (itemconfiguracionmenu_id, compuesto, compositor) VALUES
(1, 3, 1),
(2, 3, 2);

CREATE TABLE IF NOT EXISTS log (
    log_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , fecha DATE
    , hora TIME
    , ipv4 VARCHAR(16)
    , usuario VARCHAR(100)
    , accion VARCHAR(200)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS usuariodetalle (
    usuariodetalle_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , apellido VARCHAR(50)
    , nombre VARCHAR(50)
    , correoelectronico VARCHAR(250)
    , token TEXT
    , centrocosto INT(11)
    , INDEX (centrocosto)
    , FOREIGN KEY (centrocosto)
        REFERENCES centrocosto (centrocosto_id)
        ON DELETE CASCADE
    , unicom INT(11)
    , INDEX (unicom)
    , FOREIGN KEY (unicom)
        REFERENCES unicom (unicom_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

INSERT INTO usuariodetalle (usuariodetalle_id, apellido, nombre, correoelectronico, token, centrocosto, unicom) VALUES 
(1, 'Admin', 'admin', 'admin@admin.com', 'ff050c2a6dd7bc3e4602e9702de81d21', 1, 1);

CREATE TABLE IF NOT EXISTS nivel (
    nivel_id INT(2) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , nivel INT(2)
    , detalle TEXT
) ENGINE=InnoDb;

INSERT INTO nivel (nivel_id, denominacion, nivel, detalle) VALUES 
(1, 'DESARROLLADOR', 9, ''),
(2, 'ADMINISTRADOR', 3, ''),
(3, 'OPERADOR', 1, '');

CREATE TABLE IF NOT EXISTS nivelpropiedad (
    nivelpropiedad_id INT(2) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , valor VARCHAR(50)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS nivelpropiedadnivel (
    nivelpropiedadnivel_id INT(2) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX (compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES nivel (nivel_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , INDEX (compositor)
    , FOREIGN KEY (compositor)
        REFERENCES nivelpropiedad (nivelpropiedad_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , nivel INT(2)
    , INDEX (nivel)
    , FOREIGN KEY (nivel)
        REFERENCES nivel (nivel_id)
        ON DELETE CASCADE
    , usuariodetalle INT(11)
    , INDEX (usuariodetalle)
    , FOREIGN KEY (usuariodetalle)
        REFERENCES usuariodetalle (usuariodetalle_id)
        ON DELETE CASCADE
    , configuracionmenu INT(11)
    , FOREIGN KEY (configuracionmenu)
        REFERENCES configuracionmenu (configuracionmenu_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

INSERT INTO usuario (usuario_id, denominacion, nivel, usuariodetalle, configuracionmenu) VALUES 
(1, 'admin', 3, 1, 3);

