# Loan Management System - V1

A Laravel Filament-based loan management system for managing clients, loans, and amortization schedules.

## Features Implemented (V1)

### ✅ Core Modules

1. **Authentication**
   - Login system (Laravel Fortify)
   - User: `test@example.com` / Password: `password`

2. **Clients Module**
   - Full CRUD operations
   - Fields: Full Name, Contact Number, Email, Address, ID Upload
   - File upload support for client IDs (JPG, PNG, PDF)
   - Soft deletes enabled
   - View client's loans via relation manager

3. **Loans Module**
   - Wizard-based loan creation (3 steps)
     - Step 1: Basic Information (Client, Code, Type, Issuer, etc.)
     - Step 2: Amounts & Terms (Principal, Interest Rate, Terms, Dates, Fees)
     - Step 3: Review & Status
   - Loan statuses: Draft, Active, Paid, Cancelled
   - Automatic due date calculation
   - Currency formatting (PHP ₱)
   - Soft deletes enabled
   - Comprehensive validation rules

4. **Amortization Schedule**
   - Automatic schedule generation
   - Per-installment tracking
   - Fields: Installment #, Due Date, Amount Due, Principal/Interest Components
   - Status tracking: Unpaid, Paid
   - Displayed as relation manager under Loan view

5. **Dashboard Widgets**
   - **Loan Stats Widget**: Displays 4 key metrics
     - Total Clients
     - Active Loans
     - Total Loan Amount (₱)
     - Pending Payments (₱)
   - **Recent Loans Widget**: Shows 5 most recent loans
     - Clickable rows to view loan details
     - Status badges with color coding
     - Real-time data updates

## Database Schema

### Tables

**clients**
- id, full_name, contact_no, email, address, id_upload_path
- timestamps, soft_deletes

**loans**
- id, code (unique), name, client_id (FK)
- status, is_complete, start_date, due_date
- issuer, loan_type, guarantor_name, source
- principal_amount, interest_rate_monthly, disbursement_amount
- terms_months, additional_fees, advance_payment
- description, feature_applied, notes
- timestamps, soft_deletes

**loan_amortizations**
- id, loan_id (FK), installment_no
- due_date, amount_due
- principal_component, interest_component
- status, notes
- timestamps

## Installation & Setup

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   # Configure your database in .env
   php artisan migrate
   php artisan db:seed
   ```

4. **Run Development Server**
   ```bash
   npm run dev
   # In another terminal:
   php artisan serve
   ```

5. **Access the Application**
   - URL: http://localhost:8000/admin
   - Email: test@example.com
   - Password: password

## Sample Data

The seeders create:
- 5 sample clients
- 3 sample loans with different statuses
- Automatic amortization schedules

## User Flow

1. **Login** → Dashboard
2. **Clients** → Create/View/Edit clients
3. **Loans** → Create loan using wizard
   - Select client
   - Enter loan details
   - Set amounts and terms
   - Review and save
4. **View Loan** → See amortization schedule
5. **Manage Amortizations** → Track payments

## Key Features

### Client Management
- Search by name, contact, email
- Upload ID documents
- View all loans per client
- Track loan count

### Loan Management
- Unique loan codes
- Multiple loan types (DBL, Regular, Special)
- Flexible issuers (Personal, Business, Emergency)
- Automatic calculations
- Status badges with colors
- Currency formatting

### Amortization
- Auto-generate schedules
- Manual editing capability
- Payment status tracking
- Principal/Interest breakdown
- Export-ready format

## Validation Rules

- Principal amount > 0
- Terms months >= 1
- Interest rate >= 0
- Unique loan codes
- Valid email formats
- Required client selection

## Future Enhancements (V2+)

- Payment posting
- Penalties calculation
- Collections management
- Accounting entries
- Email notifications
- Reports dashboard
- Multi-branch support
- Advanced exports (PDF, Excel)
- Payment history
- Automated reminders

## Tech Stack

- **Backend**: Laravel 12
- **Admin Panel**: Filament 4
- **Database**: MySQL/SQLite
- **Frontend**: Livewire, Alpine.js
- **Styling**: Tailwind CSS

## File Structure

```
app/
├── Filament/
│   ├── Widgets/
│   │   ├── LoanStatsWidget.php
│   │   └── RecentLoansWidget.php
│   └── Resources/
│       ├── Clients/
│       │   ├── ClientResource.php
│       │   ├── Schemas/ClientForm.php
│       │   ├── Tables/ClientsTable.php
│       │   └── RelationManagers/LoansRelationManager.php
│       └── Loans/
│           ├── LoanResource.php
│           ├── Schemas/LoanForm.php (Wizard)
│           ├── Tables/LoansTable.php
│           └── RelationManagers/LoanAmortizationsRelationManager.php
├── Models/
│   ├── Client.php
│   ├── Loan.php
│   └── LoanAmortization.php
database/
├── migrations/
│   ├── create_clients_table.php
│   ├── create_loans_table.php
│   └── create_loan_amortizations_table.php
└── seeders/
    ├── ClientSeeder.php
    └── LoanSeeder.php
```

## Notes

- All monetary values use decimal(15,2) for precision
- Interest rate stored as decimal(8,4) for accuracy
- Soft deletes enabled for data recovery
- Filament Shield can be added later for role-based permissions
- Amortization uses simple flat interest calculation (can be enhanced)

## Support

For issues or questions, refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
