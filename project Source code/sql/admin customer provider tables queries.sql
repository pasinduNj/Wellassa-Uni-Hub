CREATE DATABASE IF NOT EXISTS wellassaunihub;

USE wellassaunihub;

CREATE TABLE customers (
    cus_id VARCHAR(8) PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contact_number VARCHAR(15) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE service_providers (
    sp_id VARCHAR(6) PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contact_number VARCHAR(15) UNIQUE NOT NULL,
    business_name VARCHAR(100) NOT NULL,
    nic_number VARCHAR(20) UNIQUE NOT NULL,
    whatsapp_number VARCHAR(15) UNIQUE NOT NULL,
    service_address VARCHAR(255) NOT NULL,
    service_type VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE admins (
    admin_id VARCHAR(10) PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    contact_number VARCHAR(10) UNIQUE NOT NULL
);

