# Hospital Core RMS — Multi-Role Clinical & Inpatient Management System

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777bb4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

> [!IMPORTANT]
> **Commercial Intellectual Property Notice & Source Code Sale:**
> This repository contains a production-ready, proprietary software solution engineered by **Ronit Goswami (RG Creators)**. It is available for commercial acquisition, full IP buyout, or custom enterprise licensing.
> 
> - **Asset Classification:** Healthcare & Clinical ERP
> - **Commercial Valuation / Fair Market Estimate:** **₹75,000 – ₹1,20,000 INR** *(Full Source Code & Commercial Rights)*
> - **Full IP Buyout & Exclusive Ownership:** **₹1,60,000 INR**
> - **Target Industry:** Healthcare, Hospitals, Diagnostic Clinics & EMR/EHR Systems
> - **Handover Deliverables:**
>   - Complete PHP 8.2+ & MySQL Enterprise Hospital Management System source code
>   - Full database migrations, seeders, and normalized schema models
>   - Patient, Doctor, Nurse, Pharmacist, Lab Tech, and Super-Admin role-based dashboards
>   - Appointment booking engine, clinical prescription generator, and lab billing system
>   - Postman API Collection, architectural documentation, and production runbook
>   - 30 days of dedicated technical onboarding and system integration support
> - **Official Portfolio:** [https://rgcreators.netlify.app](https://rgcreators.netlify.app)
> - **Acquisition & Licensing Inquiries:** [rgcreatorsofficial@gmail.com](mailto:rgcreatorsofficial@gmail.com)

---

[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

An enterprise multi-role Hospital Information & Clinic Operations System (HMS/RMS). Engineered in PHP 8.2+ and MySQL with distinct, role-based workflows for **Patients**, **Doctors / Physicians**, and **Hospital Super Administrators**. Features appointment scheduling, outpatient/inpatient electronic medical records (EMR), doctor specialization matching, and medical audit logs.

---

## 🏗️ System Architecture & Multi-Portal Workflow

```
+--------------------------------------------------------------------------+
|                             HOSPITAL PORTALS                             |
|                                                                          |
|   +-------------------+  +-------------------+  +--------------------+   |
|   |  PATIENT PORTAL   |  |   DOCTOR PORTAL   |  |    ADMIN PORTAL    |   |
|   | - Appointment Book|  | - Manage History  |  | - Doctor Onboard   |   |
|   | - View History    |  | - Add Prescriptions| | - Patient Directory|   |
|   | - Doctor Directory|  | - Appointment Log |  | - System Audit Logs|   |
|   +-------------------+  +-------------------+  +--------------------+   |
+--------------------------------------------------------------------------+
                                     |
                                     v
+--------------------------------------------------------------------------+
|                         APPLICATION SECURITY LAYER                       |
|   - Parameterized SQL Prepared Statements (`mysqli_prepare`)             |
|   - Dual-Layer Bcrypt Password Hashing with Legacy Hash Migration        |
|   - Real-Time IP & Session Logging (`userlog`, `doctorslog`)             |
+--------------------------------------------------------------------------+
                                     |
                                     v
+--------------------------------------------------------------------------+
|                              DATABASE TIER                               |
|   - Relational MySQL Schema with High-Concurrency Indexes:               |
|     `appointment (userId, doctorId, status)`                             |
|     `tblpatient (Docid, PatientContno)`                                  |
|     `tblmedicalhistory (PatientID)`                                      |
+--------------------------------------------------------------------------+
```

---

## ⚡ Key Capabilities

- **Tri-Portal Architecture**:
  - **Patient Portal**: Self-registration, specialization doctor discovery, real-time slot booking, cancellation, and medical history access.
  - **Doctor Portal**: Daily appointment queue, patient diagnosis notes, vital signs entry, and longitudinal medical history records.
  - **Admin Control Center**: Doctor onboarding & specialization assignment, patient ledger, appointment auditing, and session security tracking.
- **SQL Injection Immune**: Hardened with parameterized statements across all authentication endpoints.
- **Dynamic Slot & Specialization Filtering**: Asynchronous doctor discovery by medical department.
- **Longitudinal EMR Tracking**: Patient prescription, blood pressure, blood sugar, weight, and clinical notes organized chronologically.

---

## 🛠️ Tech Stack

- **Backend**: Core PHP 8.2+ (Parameterized Prepared Statements, RBAC Middlewares)
- **Frontend**: Responsive Tailwind CSS, Bootstrap 3.3, Remix Icons, Poppins Typography
- **Database**: MySQL 8.0+ / MariaDB (Optimized B-Tree Composite Indexing)

---

## 🚀 Quick Setup & Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/RG-Creators/hospital-core-rms.git
   cd hospital-core-rms
   ```

2. **Database Import**:
   - Create database `hms`:
     ```sql
     CREATE DATABASE hms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
     ```
   - Import `SQL File/hms.sql`.

3. **Configure Database Connection**:
   - Edit `hospital/hms/include/config.php` (and `admin/include/config.php`, `doctor/include/config.php`) with your database host, user, and password.

4. **Launch Application**:
   ```bash
   php -S localhost:8000
   ```
   - Hospital Homepage: `http://localhost:8000/hospital/index.php`
   - Patient Login: `http://localhost:8000/hospital/hms/user-login.php`
   - Doctor Login: `http://localhost:8000/hospital/hms/doctor/`
   - Admin Login: `http://localhost:8000/hospital/hms/admin/` (Default: `admin` / `Test@12345`)

---

## 📄 License
This repository is open-sourced under the [MIT License](LICENSE).


---

## 🚀 Future Roadmap & Next-Gen Implementation Ideas (Ready for Expansion)

The following extensive architectural and feature expansions have been designed and architected for rapid implementation, transforming this solution into a high-capacity, enterprise-grade platform:

1. **ABDM (Ayushman Bharat Digital Mission) Compliance:** Integration of M1/M2/M3 standards, ABHA Health ID generation, and National Health Authority consent manager.
2. **AI Clinical Decision Support & Drug Contraindication Engine:** Automated warnings for adverse drug-drug interactions and dosage alerts based on patient history.
3. **Automated WhatsApp Lab Reports & Appointment Reminders:** Instant PDF test report delivery and automated appointment confirmation pings via WhatsApp Business API.
4. **In-Browser DICOM Medical Imaging Viewer:** WebGL-powered PACS DICOM viewer for X-Rays, CT Scans, and MRIs with zoom, pan, and window leveling controls.
5. **IoT Bedside Vitals Telemetry Bridge:** Live MQTT telemetry stream for real-time SpO2, heart rate, and BP streaming to the central nurses station.
6. **IPD Bed Allocation & OT (Operation Theatre) Optimizer:** Visual floor-map bed management, admission/discharge workflows, and surgical suite scheduling.
7. **Pharmacy Batch & Expiry Tracking with Barcode Dispensing:** Full inventory management with automated batch recall and low-stock alerts.
8. **Automated TPA Insurance Pre-Auth & Claims Workflow:** Document submission, cashless approval tracking, and claim settlement ledger.
9. **Multi-Branch Hospital Chain Cloud Hierarchy:** Centralized administrative control across multiple hospital branches and satellite outpatient clinics.
10. **Doctor Teleconsultation WebRTC Video Suite:** End-to-end encrypted video appointments with synchronized real-time digital prescriptions.

---

## 💼 Commercial Acquisition & Licensing Agreement

For source code inspection, live technical walkthrough, pricing negotiations, or exclusive enterprise buyout:
- **Lead Architect & Developer:** Ronit Goswami (RG Creators)
- **Primary Contact Email:** [rgcreatorsofficial@gmail.com](mailto:rgcreatorsofficial@gmail.com)
- **Official Portfolio:** [https://rgcreators.netlify.app](https://rgcreators.netlify.app)
- **Location:** Kolkata, West Bengal, India
