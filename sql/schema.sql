CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('masyarakat','admin') DEFAULT 'masyarakat',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pengaduan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nomor_tiket VARCHAR(20) UNIQUE NOT NULL,
  nama_pelapor VARCHAR(100) NOT NULL,
  email_pelapor VARCHAR(100) NOT NULL,
  kategori ENUM('Infrastruktur','Kebersihan','Pelayanan Publik','Lainnya') NOT NULL,
  judul VARCHAR(255) NOT NULL,
  deskripsi TEXT NOT NULL,
  lokasi VARCHAR(255),
  status ENUM('Diterima','Diproses','Selesai') DEFAULT 'Diterima',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE lampiran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pengaduan_id INT NOT NULL,
  nama_file VARCHAR(255),
  s3_key VARCHAR(500),
  cloudfront_url VARCHAR(500),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pengaduan_id) REFERENCES pengaduan(id)
);

CREATE TABLE riwayat_status (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pengaduan_id INT NOT NULL,
  status_lama VARCHAR(50),
  status_baru VARCHAR(50),
  catatan TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pengaduan_id) REFERENCES pengaduan(id)
);

-- Seed admin default
INSERT INTO users (name, email, password, role)
VALUES ('Admin LaporKu', 'admin@lapor.id', '$2y$10$hashedpassword', 'admin');
