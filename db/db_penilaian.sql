CREATE DATABASE IF NOT EXISTS db_penilaian;
USE db_penilaian;

CREATE TABLE dosen_pa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nidn INT NOT NULL,
    nama VARCHAR(200) NOT NULL
);

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim INT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    no_wa VARCHAR(20) NOT NULL,
    jk VARCHAR(15) NOT NULL,
    dosen_pa_id int NOT NULL, 
    FOREIGN KEY (dosen_pa_id) REFERENCES dosen_pa(id)
);

CREATE TABLE nilai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id INT NOT NULL,
    dosen_pa_id INT,
    absen INT NOT NULL,
    tugas INT NOT NULL,
    uts INT NOT NULL,
    uas INT NOT NULL,
    nilai_akhir INT NOT NULL,
    nilai_huruf CHAR NOT NULL,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa (id),
    FOREIGN KEY (dosen_pa_id) REFERENCES dosen_pa (id)
);