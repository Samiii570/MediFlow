# MediFlow - Smart Hospital Operations Platform

## Complete System Documentation

---

## Table of Contents

1. [System Overview](#system-overview)
2. [Technology Stack](#technology-stack)
3. [Database Architecture](#database-architecture)
4. [User Roles & Access Control](#user-roles--access-control)
5. [Workflow Diagrams](#workflow-diagrams)
6. [Module-by-Module Breakdown](#module-by-module-breakdown)
7. [Route Map](#route-map)
8. [Demo Data](#demo-data)
9. [Setup & Installation](#setup--installation)

---

## 1. System Overview

MediFlow is a role-based hospital management system built with Laravel 12. It covers the full patient lifecycle — from registration and appointment booking, through clinical consultations and prescriptions, to pharmacy sales and lab testing — all within a single unified platform.

### Core Capabilities

| Capability | Description |
|---|---|
| Patient Management | Register patients, track demographics, view complete history |
| Appointment Scheduling | Book by department/doctor, automatic token generation, status tracking |
| Prescription Management | Doctors create multi-medicine prescriptions, downloadable as PDF |
| Lab Test Workflow | Order tests, track status, upload reports with remarks |
| Pharmacy Operations | Process multi-item sales, auto-deduct stock, generate invoice PDFs |
| Queue Management | Real-time queue display with AJAX polling every 5 seconds |
| Analytics Dashboard | Chart.js-powered admin analytics (appointments, revenue, stock, departments) |
| Role-Based Access | 5 roles with strict middleware enforcement |

---

## 2. Technology Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Database | SQLite (configurable to MySQL/PostgreSQL) |
| Frontend | Blade Templates + Tailwind CSS + Alpine.js |
| Charts | Chart.js 4.4.7 |
| PDF Generation | barryvdh/laravel-dompdf |
| Authentication | Laravel Breeze (Blade) |
| Build Tool | Vite 7.3 |
| Animations | CSS Keyframes + Alpine.js transitions |

---

## 3. Database Architecture

### Entity Relationship Diagram (Text)

```
┌──────────┐    ┌──────────────┐    ┌──────────┐
│  users   │───▶│   patients   │◀───│  users   │
│          │    │              │    │ (doctors) │
└──────────┘    └──────┬───────┘    └────┬─────┘
                       │                 │
                       │  ┌──────────────┘
                       │  │
                ┌──────▼──▼───────┐
                │   appointments  │
                │                 │
                └───┬────────┬────┘
                    │        │
         ┌──────────▼──┐  ┌──▼──────────────┐
         │prescriptions│  │   lab_tests      │
         └──────┬──────┘  └─────────────────┘
                │
    ┌───────────▼────────────┐
    │  prescription_medicines │
    │  (pivot: dosage,        │
    │   duration, frequency)  │
    └───────────┬─────────────┘
                │
         ┌──────▼──────┐
         │  medicines   │◀──────┐
         └──────┬──────┘       │
                │              │
    ┌───────────▼────────────┐ │
    │     sale_items          │─┘
    └───────────┬─────────────┘
                │
         ┌──────▼──────┐
         │pharmacy_sales│
         └─────────────┘

┌──────────────┐    ┌──────────────┐
│ departments  │───▶│   doctors    │
└──────────────┘    └──────────────┘
```

### Table Summary (14 tables)

| Table | Purpose | Key Columns |
|---|---|---|
| `users` | All user accounts | id, name, email, phone, role, password |
| `patients` | Patient demographics | id, user_id, blood_group, gender, dob, address |
| `departments` | Hospital departments | id, name, description |
| `doctors` | Doctor profiles | id, user_id, department_id, specialization, qualification, consultation_fee |
| `appointments` | Patient-doctor visits | id, patient_id, doctor_id, appointment_date, token_no, status, follow_up_date |
| `prescriptions` | Consultation records | id, appointment_id, diagnosis, notes |
| `medicines` | Pharmacy inventory | id, medicine_name, stock, price, expiry_date |
| `prescription_medicines` | Prescription line items | id, prescription_id, medicine_id, dosage, duration, frequency |
| `lab_tests` | Ordered lab tests | id, patient_id, doctor_id, test_name, status, result, remarks |
| `lab_reports` | Uploaded lab reports | id, lab_test_id, file_path, uploaded_by |
| `pharmacy_sales` | Sale transactions | id, patient_id, pharmacist_id, sale_date, total_amount |
| `sale_items` | Sale line items | id, sale_id, medicine_id, quantity, unit_price |
| `cache` | Laravel cache | key, value |
| `jobs` | Laravel job queue | queue, payload |

---

## 4. User Roles & Access Control

### Role Hierarchy

```
┌─────────────────────────────────────────────┐
│                   ADMIN                     │
│  Full system access + analytics             │
├─────────────────────────────────────────────┤
│  ┌─────────┐  ┌──────────┐  ┌───────────┐  │
│  │ DOCTOR  │  │PHARMACIST│  │RECEPTIONIST│ │
│  │Clinical │  │ Inventory│  │  Queue     │  │
│  │workflow │  │  & Sales │  │ Management │  │
│  └─────────┘  └──────────┘  └───────────┘  │
├─────────────────────────────────────────────┤
│                 PATIENT                     │
│  Self-service: book, view, download         │
└─────────────────────────────────────────────┘
```

### Access Matrix

| Feature | Admin | Doctor | Patient | Pharmacist | Receptionist |
|---|---|---|---|---|---|
| Dashboard | Admin analytics | Doctor queue | Personal overview | Sales overview | Today's stats |
| Departments | Full CRUD | View only | - | - | - |
| Doctors | Full CRUD | - | - | - | - |
| Medicines | Full CRUD | View only | - | Manage stock | - |
| Appointments | View all | View/Update status | Book/Cancel/View | - | Check-in |
| Prescriptions | View all | Create/View/PDF | View/PDF | - | - |
| Lab Tests | View all | Order/Upload report | View reports | - | - |
| Pharmacy Sales | View all | - | - | Full CRUD + Invoice PDF | - |
| Queue Display | Yes | Yes | Yes | Yes | Yes |

### Middleware Chain

```
Request → Auth Middleware → Role Middleware → Controller → View
                         │
                         ├── role:admin    → Admin/* controllers
                         ├── role:doctor   → Doctor/* controllers
                         ├── role:patient  → Patient/* controllers
                         ├── role:pharmacist → Pharmacist/* controllers
                         └── role:receptionist → Receptionist/* controllers
```

---

## 5. Workflow Diagrams

### 5.1 Patient Registration & Appointment Booking

```
Patient                  System                   Doctor
  │                        │                        │
  ├─ Register account ────▶│                        │
  │  (name, email, phone)  │                        │
  │                        ├─ Create user + patient │
  │                        │   record               │
  │                        │                        │
  ├─ Select Department ───▶│                        │
  ├─ AJAX: GET /doctors/{dept}                      │
  │◀─── JSON: doctor list ─┤                        │
  │                        │                        │
  ├─ Select Doctor ───────▶│                        │
  ├─ Pick Date ───────────▶│                        │
  ├─ Submit booking ──────▶│                        │
  │                        ├─ Create appointment    │
  │                        ├─ Generate token_no     │
  │                        ├─ Status = "pending"    │
  │                        │                        │
  ├─ View appointment ────▶│                        │
  │   (token, doctor, date)│                        │
  │                        │                        │
  │                        ├─ Doctor sees new ─────▶│
  │                        │   appointment in queue │
```

### 5.2 Doctor Consultation & Prescription Flow

```
Doctor                    System                  Patient
  │                        │                        │
  ├─ View today's ────────▶│                        │
  │  appointments          │                        │
  │                        │                        │
  ├─ Click "Start" ───────▶│                        │
  │  (status: in_progress) │                        │
  │                        │                        │
  ├─ Click "Prescribe" ───▶│                        │
  │  Select medicines      │                        │
  │  Set dosage/duration   │                        │
  ├─ Submit prescription ─▶│                        │
  │                        ├─ Create prescription   │
  │                        ├─ Attach medicines      │
  │                        │   (pivot table)        │
  │                        │                        │
  ├─ Click "Complete" ────▶│                        │
  │  (status: completed)   │                        │
  │                        │                        │
  ├─ Download PDF ────────▶│                        │
  │  (prescription PDF)    │                        │
  │                        │                        │
  │                        ├─ Prescription visible ─▶│
  │                        │   in patient portal    │
  │                        │                        │
  │                        │   Patient can download │
  │                        │   prescription PDF     │
```

### 5.3 Lab Test Workflow

```
Doctor                    System                  Lab/Patient
  │                        │                        │
  ├─ Order lab test ──────▶│                        │
  │  (test name, patient)  │                        │
  │                        ├─ Create lab test       │
  │                        ├─ Status = "pending"    │
  │                        │                        │
  │                        ├─ Admin sees pending ──▶│
  │                        │   lab tests            │
  │                        │                        │
  │  Admin/Doctor updates  │                        │
  ├─ Status: in_progress ─▶│                        │
  ├─ Upload report file ──▶│                        │
  ├─ Add remarks ─────────▶│                        │
  ├─ Status: completed ───▶│                        │
  │                        │                        │
  │                        ├─ Report visible to ───▶│
  │                        │   patient              │
```

### 5.4 Pharmacy Sales Flow

```
Pharmacist                System                 Patient
  │                        │                       │
  ├─ New Sale ────────────▶│                       │
  ├─ Select Patient ──────▶│                       │
  │                        │                       │
  ├─ Add medicines ───────▶│                       │
  │  (qty, price)          │                       │
  │  [Dynamic JS rows]     │                       │
  │                        │                       │
  ├─ Complete Sale ───────▶│                       │
  │                        ├─ Create sale record   │
  │                        ├─ Create sale items    │
  │                        ├─ Calculate total      │
  │                        ├─ Deduct stock ────────┼──▶ Stock
  │                        │                       │    updated
  ├─ Download Invoice PDF ▶│                       │
  │  (invoice PDF)         │                       │
  │                        │                       │
```

### 5.5 Queue Management Flow

```
Receptionist              System                Display Screen
  │                        │                        │
  ├─ View queue ──────────▶│                        │
  │                        ├─ Return JSON queue     │
  │                        │                        │
  ├─ Check-in patient ────▶│                        │
  │  PATCH /checkin/{id}   │                        │
  │                        ├─ Status: pending → ───▶│
  │                        │   in_progress          │
  │                        │                        │
  │                        │   AJAX /queue/data     │
  │                        │   (every 5 seconds) ──▶│
  │                        │                        │
  │                        │   ┌─────────────────┐  │
  │                        │   │ NOW SERVING: #5  │  │
  │                        │   │ WAITING: #6, #7  │  │
  │                        │   │ NEXT: #8          │  │
  │                        │   └─────────────────┘  │
```

### 5.6 Admin Analytics Flow

```
Admin Dashboard
    │
    ├── KPI Cards (animated count-up)
    │   ├── Total Patients
    │   ├── Today's Appointments
    │   ├── Total Doctors
    │   ├── Today's Revenue
    │   └── Low Stock Items
    │
    ├── Charts (Chart.js)
    │   ├── Line Chart: Appointments (7 days)
    │   ├── Bar Chart: Revenue (7 days)
    │   ├── Horizontal Bar: Medicine Stock Levels
    │   └── Doughnut: Department Load
    │
    ├── Alerts
    │   └── Expiring Medicines (color-coded)
    │
    └── Table
        └── Recent Appointments (with status badges)
```

---

## 6. Module-by-Module Breakdown

### 6.1 Admin Module

| Route | Method | Action |
|---|---|---|
| `/admin/dashboard` | GET | Analytics dashboard with 4 charts |
| `/admin/departments` | CRUD | Manage hospital departments |
| `/admin/doctors` | CRUD | Manage doctor accounts and profiles |
| `/admin/medicines` | CRUD | Manage medicine inventory |
| `/admin/lab-tests` | GET | View all lab tests |
| `/admin/lab-tests/{id}/status` | PATCH | Update lab test status |
| `/admin/lab-tests/{id}/report` | POST | Upload lab report |

### 6.2 Doctor Module

| Route | Method | Action |
|---|---|---|
| `/doctor/dashboard` | GET | Today's appointments, pending tests |
| `/doctor/appointments` | GET | View all assigned appointments |
| `/doctor/appointments/{id}/status` | PATCH | Start or complete appointment |
| `/doctor/prescriptions` | GET | View all prescriptions |
| `/doctor/appointments/{id}/prescribe` | GET/POST | Create prescription with medicines |
| `/doctor/prescriptions/{id}` | GET | View prescription details |
| `/doctor/prescriptions/{id}/pdf` | GET | Download prescription PDF |
| `/doctor/lab-tests` | GET | View ordered lab tests |
| `/doctor/lab-tests/order` | POST | Order new lab test |

### 6.3 Patient Module

| Route | Method | Action |
|---|---|---|
| `/patient/dashboard` | GET | Appointments, prescriptions, lab tests |
| `/patient/appointments/book` | GET/POST | Book new appointment (AJAX doctor fetch) |
| `/patient/appointments` | GET | View all appointments |
| `/patient/appointments/{id}` | GET | Appointment details |
| `/patient/appointments/{id}/cancel` | PATCH | Cancel pending appointment |
| `/patient/prescriptions` | GET | View all prescriptions |
| `/patient/prescriptions/{id}` | GET | Prescription details |
| `/patient/prescriptions/{id}/pdf` | GET | Download prescription PDF |
| `/patient/lab-reports` | GET | View lab reports |
| `/patient/timeline` | GET | Chronological health timeline |
| `/patient/doctors/{deptId}` | GET | AJAX: get doctors by department |

### 6.4 Pharmacist Module

| Route | Method | Action |
|---|---|---|
| `/pharmacist/dashboard` | GET | Sales stats, expiring medicines |
| `/pharmacist/medicines` | GET | Inventory with search/filter |
| `/pharmacist/medicines/{id}/stock` | PATCH | Quick stock update |
| `/pharmacist/sales/create` | GET | Create new sale (multi-item form) |
| `/pharmacist/sales` | POST | Process sale + deduct stock |
| `/pharmacist/sales` | GET | Sales history |
| `/pharmacist/sales/{id}` | GET | Sale details |
| `/pharmacist/sales/{id}/invoice` | GET | Download invoice PDF |

### 6.5 Receptionist Module

| Route | Method | Action |
|---|---|---|
| `/receptionist/dashboard` | GET | Today's check-in stats |
| `/receptionist/appointments/{id}/checkin` | PATCH | Check in patient |

### 6.6 Queue System (Shared)

| Route | Method | Access | Action |
|---|---|---|---|
| `/queue` | GET | All authenticated | Queue display page |
| `/queue/data` | GET | All authenticated | JSON endpoint (AJAX polling) |

---

## 7. Route Map

### Total: 79 routes across 5 role prefixes

```
/                          → Welcome page (public)
/login                     → Login form
/register                  → Registration form
/dashboard                 → Role-based redirect

/admin/                    → 6 route groups (departments, doctors, medicines, lab-tests)
/doctor/                   → 5 route groups (appointments, prescriptions, lab-tests)
/patient/                  → 7 route groups (appointments, prescriptions, lab-reports, timeline)
/pharmacist/               → 4 route groups (medicines, sales)
/receptionist/             → 2 route groups (appointments/checkin)

/queue                     → Queue display
/queue/data                → Queue JSON API
/profile                   → User profile management
```

---

## 8. Demo Data

### Pre-seeded Accounts (password: `password`)

| Role | Email | Name |
|---|---|---|
| Admin | admin@mediflow.com | Admin User |
| Doctor | dr.jameswilson@mediflow.com | Dr. James Wilson |
| Doctor | dr.emilychen@mediflow.com | Dr. Emily Chen |
| Doctor | dr.robertkumar@mediflow.com | Dr. Robert Kumar |
| Patient | john.smith@email.com | John Smith |
| Patient | emma.johnson@email.com | Emma Johnson |
| Pharmacist | pharmacist@mediflow.com | Mike Pharmacist |
| Receptionist | receptionist@mediflow.com | Sarah Receptionist |

### Seeded Data

| Entity | Count |
|---|---|
| Departments | 10 (Cardiology, Neurology, Orthopedics, etc.) |
| Doctors | 10 (one per department) |
| Patients | 8 |
| Medicines | 15 (with realistic stock, prices, expiry dates) |
| Appointments | ~100+ (spanning last 30 days) |
| Prescriptions | ~50+ (with 1-4 medicines each) |
| Lab Tests | ~30+ |
| Pharmacy Sales | ~30+ |

---

## 9. Setup & Installation

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+

### Quick Start

```bash
# 1. Navigate to project
cd "C:\Users\HP\Desktop\Laravel MediFLOW\mediflow"

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# 5. Setup database (SQLite)
touch database/database.sqlite
php artisan migrate:fresh --seed

# 6. Build frontend assets
npm run build

# 7. Create storage symlink
php artisan storage:link

# 8. Start server
php artisan serve
```

### Access

Open **http://127.0.0.1:8000** in your browser.

---

## PDF Generation

### Prescription PDF
- Accessible by: Doctor, Patient
- Contains: Patient info, Doctor info, Diagnosis, Medicine list (name, dosage, duration, frequency), Notes, Signatures
- Route: `/doctor/prescriptions/{id}/pdf` or `/patient/prescriptions/{id}/pdf`

### Invoice PDF
- Accessible by: Pharmacist
- Contains: Patient info, Sale items, Quantities, Unit prices, Subtotals, Total amount, Pharmacist info
- Route: `/pharmacist/sales/{id}/invoice`

---

*Documentation generated for MediFlow v1.0 — Smart Hospital Operations Platform*
