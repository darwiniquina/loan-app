# Dashboard Widgets Documentation

## Overview
Two dashboard widgets have been created to provide quick insights into the loan management system.

## Widgets

### 1. Loan Stats Widget (Stats Overview)
**File:** `app/Filament/Widgets/LoanStatsWidget.php`

**Purpose:** Displays key metrics at a glance

**Metrics Shown:**
1. **Total Clients**
   - Count of all registered clients
   - Icon: User Group
   - Color: Success (Green)

2. **Active Loans**
   - Count of loans with "Active" status
   - Icon: Banknotes
   - Color: Primary (Blue)

3. **Total Loan Amount**
   - Sum of principal amounts for active loans
   - Formatted in PHP currency (₱)
   - Icon: Currency Dollar
   - Color: Warning (Yellow)

4. **Pending Payments**
   - Sum of all unpaid amortization amounts
   - Formatted in PHP currency (₱)
   - Icon: Clock
   - Color: Danger (Red)

**Features:**
- Real-time data from database
- Color-coded for quick visual reference
- Icons for better UX
- Currency formatting for monetary values

---

### 2. Recent Loans Widget (Table)
**File:** `app/Filament/Widgets/RecentLoansWidget.php`

**Purpose:** Shows the 5 most recently created loans

**Columns Displayed:**
1. **Loan Code** - Unique identifier
2. **Client** - Client's full name (with relationship)
3. **Principal** - Loan amount in PHP currency
4. **Status** - Badge with color coding:
   - Draft: Gray
   - Active: Green
   - Paid: Blue
   - Cancelled: Red
5. **Start Date** - When the loan started
6. **Created** - Relative time (e.g., "2 days ago")

**Features:**
- Shows latest 5 loans (no pagination)
- Clickable rows - links to loan detail page
- Searchable and sortable columns
- Status badges with color coding
- Full-width display
- Sorted by creation date (newest first)

---

## Widget Configuration

### Display Order
- **LoanStatsWidget:** Sort order 1 (default)
- **RecentLoansWidget:** Sort order 2

### Column Span
- **LoanStatsWidget:** Default (auto)
- **RecentLoansWidget:** Full width

### Auto-Discovery
Both widgets are automatically discovered by Filament and displayed on the admin dashboard.

---

## Usage

### Viewing the Dashboard
1. Login to the admin panel
2. Navigate to the Dashboard (default landing page)
3. View stats at the top
4. Scroll down to see recent loans table

### Interacting with Widgets
- **Stats Widget:** Read-only, updates automatically
- **Recent Loans Widget:** 
  - Click any row to view loan details
  - Use column headers to sort
  - Search within the table

---

## Technical Details

### Database Queries
**LoanStatsWidget:**
```php
Client::count()
Loan::where('status', 'Active')->count()
Loan::where('status', 'Active')->sum('principal_amount')
LoanAmortization::where('status', 'Unpaid')->sum('amount_due')
```

**RecentLoansWidget:**
```php
Loan::query()->latest()->limit(5)
```

### Performance
- Queries are optimized with proper indexing
- Limited to 5 records for recent loans
- Efficient aggregation for stats

---

## Customization

### To modify stats:
Edit `app/Filament/Widgets/LoanStatsWidget.php` and update the `getStats()` method.

### To change recent loans limit:
Edit `app/Filament/Widgets/RecentLoansWidget.php` and change the `limit(5)` value.

### To add more widgets:
```bash
php artisan make:filament-widget WidgetName
```

---

## Future Enhancements

Potential additions:
- Chart widget showing loan trends over time
- Payment collection widget
- Overdue loans alert widget
- Client growth chart
- Monthly revenue widget
- Loan status distribution pie chart
