-- MySQL Script generated by MySQL Workbench
-- Thu Jun  9 11:33:00 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema WebDiP2021x114
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema WebDiP2021x114
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `WebDiP2021x114` DEFAULT CHARACTER SET utf8 ;
USE `WebDiP2021x114` ;

-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`tip_korisnika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`tip_korisnika` (
  `id_tip_korisnika` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_tip_korisnika`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`korisnik` (
  `id_korisnik` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NOT NULL,
  `prezime` VARCHAR(45) NOT NULL,
  `korisnicko_ime` VARCHAR(45) NOT NULL,
  `lozinka` VARCHAR(45) NOT NULL,
  `lozinka_sha256` VARCHAR(45) NOT NULL,
  `aktivacijski_kod` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  `broj_neuspjesnih_prijava` INT NOT NULL,
  `uvjeti_koristenja` DATETIME NULL,
  `status` TINYINT NOT NULL,
  `bodovi` INT NULL,
  `tip_korisnika` INT NOT NULL,
  PRIMARY KEY (`id_korisnik`),
  INDEX `fk1_idx` (`tip_korisnika` ASC) ,
  CONSTRAINT `fk1_korisnik_tip_korisnika`
    FOREIGN KEY (`tip_korisnika`)
    REFERENCES `WebDiP2021x114`.`tip_korisnika` (`id_tip_korisnika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`dnevnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`dnevnik` (
  `id_dnevnik` INT NOT NULL AUTO_INCREMENT,
  `korisnik` INT NULL,
  `vrijeme` DATETIME NOT NULL,
  `opis` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_dnevnik`),
  INDEX `fk1_dnevnik_korisnik_idx` (`korisnik` ASC) ,
  CONSTRAINT `fk1_dnevnik_korisnik`
    FOREIGN KEY (`korisnik`)
    REFERENCES `WebDiP2021x114`.`korisnik` (`id_korisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`drzava`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`drzava` (
  `id_drzava` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_drzava`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`moderatori`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`moderatori` (
  `id_korisnik` INT NOT NULL,
  `id_drzava` INT NOT NULL,
  PRIMARY KEY (`id_korisnik`, `id_drzava`),
  INDEX `fk1_moderatori_drzava_idx` (`id_drzava` ASC) ,
  CONSTRAINT `fk1_moderatori_drzava`
    FOREIGN KEY (`id_drzava`)
    REFERENCES `WebDiP2021x114`.`drzava` (`id_drzava`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk2_moderatori_korisnik`
    FOREIGN KEY (`id_korisnik`)
    REFERENCES `WebDiP2021x114`.`korisnik` (`id_korisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`tip_utrke`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`tip_utrke` (
  `id_tip_utrke` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_tip_utrke`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`utrka`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`utrka` (
  `id_utrka` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  `zakljucana` TINYINT NOT NULL DEFAULT 0,
  `zavrsetak_prijava` DATETIME NOT NULL,
  `lokacija` VARCHAR(45) NOT NULL,
  `tip_utrke` INT NULL,
  `drzava` INT NULL,
  PRIMARY KEY (`id_utrka`),
  INDEX `fk1_utrka_tip_utrke_idx` (`tip_utrke` ASC) ,
  INDEX `fk2_utrka_drzava_idx` (`drzava` ASC) ,
  CONSTRAINT `fk1_utrka_tip_utrke`
    FOREIGN KEY (`tip_utrke`)
    REFERENCES `WebDiP2021x114`.`tip_utrke` (`id_tip_utrke`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk2_utrka_drzava`
    FOREIGN KEY (`drzava`)
    REFERENCES `WebDiP2021x114`.`drzava` (`id_drzava`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`etapa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`etapa` (
  `id_etapa` INT NOT NULL AUTO_INCREMENT,
  `datum` DATE NOT NULL,
  `vrijeme` TIME NOT NULL,
  `zakljucana` TINYINT NOT NULL DEFAULT 0,
  `naziv` VARCHAR(45) NOT NULL,
  `duzina` VARCHAR(45) NOT NULL,
  `utrka` INT NULL,
  PRIMARY KEY (`id_etapa`),
  INDEX `fk1_etapa_utrka_idx` (`utrka` ASC) ,
  CONSTRAINT `fk1_etapa_utrka`
    FOREIGN KEY (`utrka`)
    REFERENCES `WebDiP2021x114`.`utrka` (`id_utrka`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x114`.`prijava_etape`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x114`.`prijava_etape` (
  `id_prijava_etape` INT NOT NULL AUTO_INCREMENT,
  `datum_rodenja` DATE NOT NULL,
  `slika` BLOB NULL,
  `odustao` TINYINT NULL,
  `bodovi` INT NULL,
  `korisnik` INT NULL,
  `etapa` INT NULL,
  PRIMARY KEY (`id_prijava_etape`),
  INDEX `fk1_prijava_etape_etapa_idx` (`etapa` ASC) ,
  INDEX `fk2_prijava_etape_korisnik_idx` (`korisnik` ASC) ,
  CONSTRAINT `fk1_prijava_etape_etapa`
    FOREIGN KEY (`etapa`)
    REFERENCES `WebDiP2021x114`.`etapa` (`id_etapa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk2_prijava_etape_korisnik`
    FOREIGN KEY (`korisnik`)
    REFERENCES `WebDiP2021x114`.`korisnik` (`id_korisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;