CREATE TABLE HTX_GIRO
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_GIRO
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_GIRO
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   --

   CREATE TABLE HTX_SAVE
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_SAVE
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_SAVE
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   --

   CREATE TABLE HTX_DEPO
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_DEPO
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_DEPO
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   --

   CREATE TABLE HTX_K_PRK_RESTRUK
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_K_PRK_RESTRUK
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_K_PRK_RESTRUK
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   --

   CREATE TABLE HTX_K_PRK
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_K_PRK
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_K_PRK
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   --

   CREATE TABLE HTX_K_UMUM
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_K_UMUM
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_K_UMUM
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   --

   CREATE TABLE HTX_K_KONSUMSI
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_K_KONSUMSI
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_K_KONSUMSI
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   --

   CREATE TABLE HTX_NOMI
 (NO_REK        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL,
  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_NOMI
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_NOMI
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_REK,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );

   -- LEDGER

CREATE TABLE HTX_LEDGER
 (NO_GSSL        VARCHAR(12)     NOT NULL,
  KD_CAB        CHARACTER(3)    NOT NULL,
  TGL_TX        DATE            NOT NULL,
  TIME_STAMP    TIMESTAMP       NOT NULL,
  KD_USER       CHARACTER(5)    NOT NULL,
  KD_TX         CHARACTER(3)    NOT NULL,
  KET_TX        VARCHAR(30)     NOT NULL,
  NO_ARSIP      VARCHAR(10)     NOT NULL,
  SALDO_AKHIR   DECIMAL(15, 2)  NOT NULL,
  DB_KR         CHARACTER(1)    NOT NULL,
  JUMLAH_TX     DECIMAL(15, 2)  NOT NULL,
  KD_SPV        CHARACTER(5)    NOT NULL
--  KD_CAB_LOKTX  CHARACTER(3)    NOT NULL
 -- POKOK DECIMAL(15, 2)  ,
 -- BUNGA DECIMAL(15, 2)  ,
 -- DENDA DECIMAL(15, 2)
 )
  DATA CAPTURE NONE
  IN USERSPACE2;

ALTER TABLE HTX_LEDGER
  LOCKSIZE ROW
  APPEND OFF
  NOT VOLATILE;

ALTER TABLE HTX_LEDGER
  ADD CONSTRAINT SQL141231032120540 PRIMARY KEY
   (NO_GSSL,
    KD_CAB,
    TGL_TX,
    TIME_STAMP
   );
