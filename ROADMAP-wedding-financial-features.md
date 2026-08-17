# Wedding Financial Planning Feature Roadmap
> Budget Management System & Joint Savings Tracker
> Project: `myweed` (Laravel 12, Blade + Bootstrap 5, AdminUIUX gold/navy theme)

---

## 1. Context & Architecture Alignment

The existing platform (`myweed` / RuangUndang) is a Laravel 12 wedding-invitation SaaS. Each couple is represented by an
`Invitation` owned by a `User`. Users subscribe to **Free / Basic / Pro** plans gated by `User::hasFeature()` — a JSON
feature matrix stored on `subscription_plans.features` (see `database/seeders/SubscriptionSeed.php`).

Two new financial modules will live under the authenticated dashboard namespace, mirroring the existing
`WeedingPlan` module in structure, naming, UI idiom, and language (Indonesian). They will reuse:
- `<x-app-layout>` wrapper + AdminUIUX gold/navy CSS variables
- `User` / `Invitation` ownership scoping (`where('user_id', auth()->id())`)
- `authorize*`-style private ownership checks in controllers
- SweetAlert2 confirmations + TomSelect selects in Blade
- The feature-flag pattern (`hasFeature`) for tiered gating

```
User (the planner / partner A)
   └─ Invitation (the wedding event)
         ├─ WeedingPlan  (existing task planner)
         ├─ Budget         (NEW – master budget + categories)
         ├─ BudgetExpense   (NEW – line-item spending)
         ├─ VendorPayment   (NEW – scheduled vendor payouts)
         ├─ SavingsGoal    (NEW – target-driven savings)
         └─ SavingsContribution (NEW – multi-user deposits)
```

> **Scope note:** `User` currently represents one account. The "couple" is modelled as one `User` owning the
> `Invitation`; the **Joint Savings Tracker** will support **multiple contributor accounts** by introducing a
> `partner_user_id` concept (partner B) attached to the invitation. See §4.2.

---

## 2. Module 1 — Budget Management System

A full lifecycle budget engine: plan allocations per category → log real expenses → schedule & track vendor payouts.

### 2.1 Feature Breakdown (MVP → Advanced)

| # | Feature | MVP | Stretch |
|---|---------|-----|---------|
| 1.1 | Master wedding budget (single total per invitation) | ✅ | per-phase budgets (akad / resepsi) |
| 1.2 | Budget categories with allocated limits + colour labels | ✅ | nested sub-categories |
| 1.3 | Expense entry with category assignment, date, amount, notes, receipt attachment | ✅ | recurring expenses |
| 1.4 | Real-time "spent vs. allocated vs. remaining" per category | ✅ | trend chart (monthly burn) |
| 1.5 | Vendor-payment scheduler: future-dated payouts, reminders, status (pending/paid/cancelled) | ✅ | payment gateway link |
| 1.6 | Budget vs. actual dashboard with variance % + over-budget alerts | ✅ | export CSV / PDF report |
| 1.7 | Template budgets (seeded presets e.g. "Simple", "Luxury") | ✅ | import from template |

### 2.2 Data Model — Essential Fields

#### `budgets` table
Master budget record per invitation.

| Field | Type | Constraints | Notes |
|-------|------|-------------|-------|
| `id` | bigint | PK | |
| `invitation_id` | bigint | FK → `invitations`, `cascadeOnDelete` | owner link |
| `user_id` | bigint | FK → `users` | planner |
| `title` | string(255) | required | "Anggaran pernikahan" |
| `total_amount` | decimal(15,2) | required, min 0 | master budget ceiling |
| `currency` | string(3) | default `IDR` | |
| `status` | string(20) | default `active` | `active`, `archived` |
| `created_at` / `updated_at` | timestamp | | |

#### `budget_categories` table
Allocations within a budget.

| Field | Type | Constraints | Notes |
|-------|------|-------------|-------|
| `id` | bigint | PK | |
| `budget_id` | bigint | FK → `budgets`, cascadeOnDelete | |
| `name` | string(100) | required | e.g. "Catering", "Venue" |
| `colour` | string(7) | default `#6c757d` | label badge |
| `allocated_amount` | decimal(15,2) | required, min 0 | planned spend for category |
| `note` | text | nullable | internal notes |
| `sort_order` | integer | default 0 | drag-sort display |

#### `budget_expenses` table
Line-item expenses.

| Field | Type | Constraints | Notes |
|-------|------|-------------|-------|
| `id` | bigint | PK | |
| `budget_category_id` | bigint | FK → `budget_categories`, cascadeOnDelete | |
| `invitation_id` | bigint | FK → `invitations` | denorm for scoping |
| `user_id` | bigint | FK → `users` | who logged it |
| `vendor_name` | string(255) | required | payee |
| `amount` | decimal(15,2) | required | |
| `expense_date` | date | required | when incurred |
| `payment_method` | enum | `cash`, `transfer`, `e-wallet`, `credit`, `card` | |
| `description` | text | nullable | |
| `receipt_path` | string | nullable | media / storage |
| `is_paid` | boolean | default true | distinguishes committed vs. estimate |

#### `vendor_payments` table
Scheduled / actualised payments to vendors (may or may not tie to an expense).

| Field | Type | Constraints | Notes |
|-------|------|-------------|-------|
| `id` | bigint | PK | |
| `invitation_id` | bigint | FK → `invitations` | |
| `budget_category_id` | bigint | nullable, FK | link budget category |
| `user_id` | bigint | FK → `users` | scheduler |
| `vendor_name` | string(255) | required | |
| `vendor_contact` | string | nullable | phone / email |
| `amount` | decimal(15,2) | required | |
| `currency` | string(3) | default `IDR` | |
| `scheduled_date` | date | required | planned payout |
| `due_date` | date | nullable | hard deadline |
| `paid_at` | datetime | nullable | actual payment timestamp |
| `status` | enum | default `scheduled` | `scheduled`, `paid`, `overdue`, `cancelled` |
| `notes` | text | nullable | |

### 2.3 UI Requirements — Budget Management

Screen stack follows the `weeding-plan` pattern: list → create/edit card → confirm modals.

| Screen | Route name | Key UI Elements |
|--------|-----------|-----------------|
| **Budget Dashboard** | `budget.dashboard` | Stat cards (total budget, total spent, total remaining, % used); category progress bars; over-budget alert pill; quick-add floating button |
| **Category List** | `budget.category.index` | Table with colour badge, allocated vs. spent (bar), remaining, action column; bulk edit allocation |
| **Add/Edit Category** | `budget.category.create` / `budget.category.edit` | Modal or card form: name, colour picker, allocated amount |
| **Expenses List** | `budget.expense.index` | Filterable table (category, date-range, payment-method); inline status toggle (`is_paid`); column shows variance vs. allocation |
| **Add/Edit Expense** | `budget.expense.create` / `.edit` | Form: vendor, amount, date, method, category select, description, receipt upload (drag-drop) |
| **Vendor Payments** | `budget.payment.index` | Calendar / list view of scheduled payments; colour-coded by status (green=paid, amber=scheduled, red=overdue); overdue highlight |
| **Schedule Payment** | `budget.payment.create` | Form pre-fill vendor from expense DB; date-pickers; reminder toggle |

**Shared UI conventions (from existing Blade views):**
- Page header: `h4` Plus Jakarta Sans; subtitle `text-muted`
- Stat cards: `stat-card-custom` with `stat-icon-box` + gold-navy badges
- Tables: `table table-custom table-hover` with `thead` dark labels
- Filters: `filter-pill` selects + `input-group-pill` search (debounced 500 ms, mirrors `weeding-plan/index`)
- Actions: circular `btn btn-sm btn-outline-*` icon buttons; mobile collapses to `bi bi-three-dots-vertical` dropdown
- Confirmations: `Swal.fire` with custom gold confirm button
- Empty state: `empty-icon` rounded circle

### 2.4 API / Controller Endpoints

Controllers (resource-style, all under `auth` + `subscription` middleware for Pro gating where relevant):

```
GET    /budget                           BudgetController@dashboard       → budget.dashboard
PUT    /budget/{budget}                  BudgetController@update         → budget.update
GET    /budget/categories                BudgetCategoryController@index  → budget.category.index
POST   /budget/categories                BudgetCategoryController@store  → budget.category.store
GET    /budget/categories/{cat}/edit     ...@edit   → budget.category.edit
PUT    /budget/categories/{cat}          ...@update → budget.category.update
DELETE /budget/categories/{cat}          ...@destroy
GET    /budget/expenses                  BudgetExpenseController@index   → budget.expense.index
POST   /budget/expenses                  ...@store
GET    /budget/expenses/{e}/edit         ...@edit
PUT    /budget/expenses/{e}              ...@update
DELETE /budget/expenses/{e}              ...@destroy
GET    /budget/payments                  VendorPaymentController@index   → budget.payment.index
POST   /budget/payments                  ...@store   → budget.payment.store
PUT    /budget/payments/{p}/pay          ...@markPaid  (status → paid, `paid_at` = now)
DELETE /budget/payments/{p}              ...@destroy
```

### 2.5 Validation Rules (mirrors `WeedingPlanController`)

```php
// BudgetController::update
'total_amount' => ['required', 'numeric', 'min:0'],
'currency'     => ['nullable', 'in:IDR,USD,MYR'],

// BudgetExpenseController store/update
'budget_category_id' => ['required', Rule::exists('budget_categories', 'id')
                          ->where('budget_id', ...)],
'vendor_name'        => ['required', 'string', 'max:255'],
'amount'             => ['required', 'numeric', 'min:0'],
'expense_date'       => ['required', 'date'],
'payment_method'     => ['in:cash,transfer,e-wallet,credit,card'],
'receipt'            => ['nullable', 'image', 'max:2048'],

// VendorPaymentController store/update
'vendor_name'    => ['required', 'string', 'max:255'],
'amount'         => ['required', 'numeric', 'min:0'],
'scheduled_date' => ['required', 'date'],
'status'         => ['in:scheduled,paid,overdue,cancelled'],
```

---

## 3. Module 2 — Joint Savings Tracker

Enables a couple (or the couple + contributing family) to pool money toward savings goals, with
per-contributor visibility, progress visualization, and automation rules.

### 3.1 Feature Breakdown

| # | Feature | MVP | Stretch |
|---|---------|-----|---------|
| 2.1 | Multiple savings goals per wedding (e.g. "Venue", "Honeymoon", "Attendants") | ✅ | goal dependencies |
| 2.2 | Each goal has a target amount, deadline, colour | ✅ | recurring target increase |
| 2.3 | Multi-user contributions (Partner A / Partner B / Family) | ✅ | external contribution links |
| 2.4 | Goal progress visualization: circular / linear bar + % | ✅ | milestone celebration banner |
| 2.5 | Automated savings targets (recurring transfer rules: daily/weekly/monthly) | ✅ | auto-pause when goal met |
| 2.6 | Contribution ledger (who paid what, when, via which method) | ✅ | filter by contributor |
| 2.7 | Savings projection ("X days left → save Rp Y/day") | ✅ | "what-if" simulator |
| 2.8 | Notification on milestone (75 % / 90 % / 100 %) | ✅ | email / in-app |

### 3.2 Data Model — Essential Fields

#### `savings_goals` table

| Field | Type | Constraints | Notes |
|-------|------|-------------|-------|
| `id` | bigint | PK | |
| `invitation_id` | bigint | FK → `invitations`, cascadeOnDelete | |
| `user_id` | bigint | FK → `users` | owner / creator |
| `name` | string(255) | required | e.g. "Caduntuk Resepsi" |
| `target_amount` | decimal(15,2) | required, min 0 | |
| `currency` | string(3) | default `IDR` | |
| `deadline` | date | required | target date |
| `colour` | string(7) | default `#C6A962` (gold) | |
| `description` | text | nullable | |
| `auto_savings_rule` | json | nullable | `{frequency, amount, day_of_week, day_of_month}` |
| `is_active` | boolean | default true | stop contributing once reached |
| `is_shared` | boolean | default true | couple-shared vs. personal goal |

#### `savings_contributions` table

| Field | Type | Constraints | Notes |
|-------|------|-------------|-------|
| `id` | bigint | PK | |
| `savings_goal_id` | bigint | FK → `savings_goals`, cascadeOnDelete | |
| `invitation_id` | bigint | FK → `invitations` | |
| `contributor_id` | bigint | FK → `users` | who added money |
| `amount` | decimal(15,2) | required, min 0.01 | |
| `currency` | string(3) | default `IDR` | |
| `method` | enum | `transfer`, `e-wallet`, `cash`, `card` | |
| `contributed_at` | datetime | required | timestamp of deposit |
| `note` | string(500) | nullable | "for honeymoon fund" |
| `is_automatic` | boolean | default false | flag for auto-rule-generated |

### 3.3 UI Requirements — Joint Savings Tracker

| Screen | Route name | Key UI Elements |
|--------|-----------|-----------------|
| **Savings Dashboard** | `savings.dashboard` | Goal cards with progress ring (Chart.js doughnut via CDN — not in composer, load from JSDELivr); stat card for total saved / total target; next auto-contribution date; "Add Contribution" FAB |
| **Goal List / Kanban** | `savings.goal.index` | Grid of goal cards: colour accent, ring progress, target date, amount saved; drag to reorder; quick-actions (contribute, edit, pause) |
| **Goal Create/Edit** | `savings.goal.create` / `.edit` | Form: name, target, deadline, colour picker, currency, auto-savings rule section (toggle → frequency/amount/day fields) |
| **Contribute Modal** | `savings.contribution.create` | Modal triggered from goal card or dashboard: amount, method, date (default today), contributor (default self), note |
| **Contribution Ledger** | `savings.contribution.index` | Table: date, contributor avatar/name, amount, method, goal, note; grouped filter by goal + contributor; pagination |
| **Automation Settings** | `savings.automation.index` | List of auto-savings rules per goal with next-run date, run history toggle |
| **Projection / Simulator** | `savings.projection` | "You need Rp X/day" calculator; adjusts when contribution is made |

**Reused UI assets from codebase:**
- Theme: gold (`#C6A962`) accent, `--adminuiux-theme-1` for active, `--bs-secondary` for muted
- Component idiom: `premium-card`, `stat-card-custom`, `form-card`, `empty-icon`
- Icons: `bi bi-pig-coin` (savings), `bi bi-graph-up-arrow` (progress), `bi bi-wallet2` (budget)

### 3.4 Controller / Route Endpoints

```
GET    /savings                          SavingsController@dashboard       → savings.dashboard
GET    /savings/goals                    SavingsGoalController@index       → savings.goal.index
POST   /savings/goals                    ...@store
GET    /savings/goals/{g}/edit           ...@edit   → savings.goal.edit
PUT    /savings/goals/{g}                ...@update → savings.goal.update
DELETE /savings/goals/{g}                ...@destroy
POST   /savings/goals/{g}/toggle         ...@toggleActive   (is_active flip)

GET    /savings/contributions            SavingsContributionController@index → savings.contribution.index
POST   /savings/contributions            ...@store
GET    /savings/contributions/{c}/edit   ...@edit   → savings.contribution.edit
PUT    /savings/contributions/{c}        ...@update → savings.contribution.update
DELETE /savings/contributions/{c}        ...@destroy

GET    /savings/automation               SavingsAutomationController@index → savings.automation.index
POST   /savings/automation               ...@updateRule (toggle / save auto-rule)
POST   /savings/automation/run           ...@runPending (CLI-invokable; scheduled daily)

GET    /savings/projection               SavingsController@projection      → savings.projection
```

All routes grouped under:
```php
Route::middleware(['auth', 'subscription'])->prefix('savings')->name('savings.')->group(...);
```

> Free-tier users see a **read-only dashboard** with upgrade nudge (same pattern as `gift` middleware gating in
> `web.php:123-125` and `tema/index` locks in `tema/index.blade.php:53`).

---

## 4. Integration — Unified Financial Overview

### 4.1 Shared Backbone: `invitation_id`

Both modules anchor on the **same `Invitation`** record, which already carries couple names, wedding date,
locations, and RSVP/gift data. This means:

- Budget allocations → expenses → vendor payments all key off `invitation_id`, exactly like `WeedingPlan`.
- Savings goals → contributions key off `invitation_id` too.
- A single `User` owns the invitation; a **new `partner_user_id`** column is added to `invitations`
  (nullable) to represent Partner B for joint features.

### 4.2 Couple / Multi-user Model

**Migration — `add_partner_to_invitations_table`:**
| Field | Type | Notes |
|-------|------|-------|
| `partner_user_id` | bigint | FK → `users`, nullable. Invites a second account to be the couple. |
| `partner_invite_token` | string(64) | unique token for partner to accept / link |
| `partner_accepted_at` | datetime | nullable |

**Access rule:**
- A user can view/edit financial data if `auth()->id() === invitation->user_id`
  **or** `auth()->id() === invitation->partner_user_id` (and `partner_accepted_at` is set).

This mirrors the existing `authorizePlan()` ownership pattern in `WeedingPlanController.php:151-156`.

### 4.3 Unified Financial Dashboard

New route: `GET /financial-overview` → `FinancialDashboardController@index()`

Combines both modules into one view with four quadrants:

```
┌─────────────────────┬──────────────────────┐
│  Budget Snapshot    │  Savings Snapshot    │
│  total: Rp 50 M     │  saved: Rp 12 M      │
│  spent:  Rp 32 M    │  goal:  Rp 25 M      │
│  remain: Rp 18 M    │  prog:  48%           │
│  [category bars]    │  [progress rings]    │
├─────────────────────┴──────────────────────┤
│  Upcoming Vendor Payments (next 30 days)   │
│  • Venue – Rp 8 M – due 20 Sep – [Pay now]  │
│  • Dress – Rp 12 M – due 5 Oct  – [Remind]  │
├─────────────────────┬──────────────────────┤
│  Recent Activity    │  Auto-Savings Next    │
│  - Partner A added  │  Goal: Venue           │
│    Rp 500k (today)  │  Next: 1 Oct (Rp 200k)│
│  - Expense logged   │  Goal: Honeymoon       │
│    Catering Rp 3M   │  Next: 15 Oct (Rp 300k)│
└─────────────────────┴──────────────────────┘
```

**Data fields fed to the view (`$financialData`):**
```jsonc
{
  "budget": {
    "total_amount": 50000000,
    "total_spent": 32000000,
    "total_remaining": 18000000,
    "usage_percent": 64,
    "is_over_budget": false,
    "categories": [
      { "name": "Venue", "allocated": 10000000, "spent": 8000000, "remaining": 2000000, "colour": "#C6A962" }
    ]
  },
  "savings": {
    "total_saved": 12000000,
    "total_target": 25000000,
    "progress_percent": 48,
    "goals": [
      { "name": "Venue", "target": 15000000, "saved": 8000000, "deadline": "2025-09-20", "colour": "#C6A962" }
    ],
    "next_auto_contribution": { "goal": "Venue", "date": "2025-10-01", "amount": 200000 }
  },
  "payments": {
    "upcoming": [ { "vendor": "Venue", "amount": 8000000, "scheduled_date": "2025-09-20", "status": "scheduled" } ]
  },
  "activity": [
    { "type": "contribution", "user": "Partner A", "amount": 500000, "ago": "2 hours ago" },
    { "type": "expense", "user": "Partner B", "amount": 3000000, "category": "Catering", "ago": "1 day ago" }
  ]
}
```

**Computed properties on models** (mirrors `WeedingPlan::isOverdue()`):

- `Budget::spentAmount()` → sum of `budget_category` expenses
- `Budget::remainingAmount()` → `total_amount - spent`
- `Budget::usagePercent()` → `round(spent / total * 100, 1)`
- `Budget::isOverBudget()` → `spent > total`
- `SavingsGoal::totalSaved()` → sum contributions
- `SavingsGoal::progressPercent()` → `round(saved / target * 100, 1)`
- `SavingsGoal::daysRemaining()` → `deadline->diffInDays(now())`
- `SavingsGoal::dailyRequired()` → `remaining / daysRemaining` (projection)

### 4.4 Real-time Spending vs. Savings Integration

The two modules feed each other:

1. **Expense → Budget** reduces a category allocation + the master budget `spent` figure.
2. **Payment scheduled** on a category can optionally auto-create a linked `budget_expense` row as an
   *estimate* (`is_paid=false`) that flips to a real expense when marked paid — ensuring spend tracking
   accounts for contracted-but-not-yet-paid liabilities.
3. **Savings contribution** increases `total_saved`; the dashboard net figure
   **"Money Available = total_saved + remaining_budget"** tells the couple how much cash buffer they hold
   against planned commitments.
4. **Budget over-budget** flags can trigger a savings goal warning: *"Venue is 20 % over budget —
   increase savings target or re-scope."*
5. **Auto-savings rules** can be tied to a budget category: when a vendor payment is due within N days
   and savings `projected_daily` shortfall exceeds a threshold, the rule bumps the recurring daily amount.

---

## 5. Subscription Gating Strategy

| Feature | Free tier | Basic tier | Pro tier |
|---------|-----------|------------|----------|
| Budget dashboard + basic categories | read-only / 3 categories | full | full |
| Expenses (manual logging + receipt) | disabled | ✅ | ✅ |
| Vendor payment scheduler | disabled | ✅ (3 scheduled) | unlimited |
| Savings goals (max #) | 1 | 5 | unlimited |
| Multi-contributor ledger | disabled | ✅ (2 users) | ✅ (unlimited) |
| Automated savings rules | disabled | ✅ | ✅ |
| Goal progress visualization | disabled | chart bars | interactive rings + projection |
| Export / report | disabled | CSV | CSV + PDF |
| Overdue / budget alerts | disabled | email | email + in-app push |

**Implementation** (consistent with existing pattern in `User::hasFeature()` + `role:admin` middleware):

```php
// In controller constructor or route middleware
if (! $user->hasFeature('budget_expenses')) {
    return back()->with('warning', 'Fitur ini membutuhkan langganan Premium.');
}
```

New feature keys seeded in `SubscriptionSeed.php`:
- `budget_management` (bool)
- `budget_expenses` (bool)
- `vendor_payments` (bool)
- `vendor_payment_limit` (int, e.g. 3 for Basic)
- `savings_goals` (int, e.g. 1 / 5 / null=unlimited)
- `savings_multi_user` (bool)
- `auto_savings_rules` (bool)
- `savings_projection` (bool)
- `financial_export` (bool)

These are added to each plan's `$features` array and the admin form
(`dashboard/subscription-plans/form.blade.php`) gets a new feature group `keuangan`.

---

## 6. Roadmap Timeline (Phased Delivery)

```
Phase 0  (Week 0)  ─ Foundation
  • Migrations: budgets, budget_categories, budget_expenses, vendor_payments,
    savings_goals, savings_contributions, + add_partner_to_invitations
  • Models: Budget, BudgetCategory, BudgetExpense, VendorPayment,
    SavingsGoal, SavingsContribution (relationships + computed props)
  • DB: add feature flags to SubscriptionSeed
  • Route entries in web.php under auth + subscription groups
  • Sidebar: add "Anggaran" & "Tabungan" nav items to user_sidebar.blade.php

Phase 1  (Week 1-2)  ─ Budget Management MVP
  • BudgetController (dashboard + update total)
  • BudgetCategoryController (CRUD)
  • BudgetExpenseController (CRUD + receipt upload)
  • Views: budget/dashboard, budget/category/*, budget/expense/*
  • Real-time aggregation: spent/remaining per category + master
  • Tests: BudgetTest, BudgetCategoryTest, BudgetExpenseTest (PHPUnit/Pest)

Phase 2  (Week 3-4)  ─ Budget Advanced + Vendor Payments
  • VendorPaymentController (scheduler + mark-paid)
  • Views: budget/payment/* (calendar/list + overdue highlight)
  • Notification job: email reminder 2 days before scheduled_date
  • Tests: VendorPaymentTest

Phase 3  (Week 5-6)  ─ Joint Savings Tracker MVP
  • SavingsGoalController, SavingsContributionController
  • Views: savings/dashboard (progress rings via Chart.js CDN), goal/*, contribution/*
  • Multi-user contributor dropdown (scope to invitation owner + partner)
  • Tests: SavingsGoalTest, SavingsContributionTest

Phase 4  (Week 7)  ─ Automation + Integration
  • SavingsAutomationController + daily command `php artisan savings:run-auto`
  • Migration: add `auto_savings_rule` json column (already in schema above)
  • FinancialDashboardController → unified financial-overview
  • Cross-module logic: expense ↔ budget, payment ↔ expense estimate, savings ↔ budget net
  • Tests: FinancialDashboardTest, AutomationCommandTest

Phase 5  (Week 8)  ─ Polish, Gating, Export
  • Free-tier locks: read-only budget, 1 savings goal, no auto-rules
  • CSV export for expenses & contributions (Pro)
  • Upgrade nudges on locked screens
  • Full regression test suite passes
  • Lint: ./vendor/bin/pint --test
```

---

## 7. File Inventory (what gets created/edited)

### New models
`app/Models/Budget.php`, `BudgetCategory.php`, `BudgetExpense.php`,
`VendorPayment.php`, `SavingsGoal.php`, `SavingsContribution.php`

### New controllers
`app/Http/Controllers/BudgetController.php`,
`app/Http/Controllers/BudgetCategoryController.php`,
`app/Http/Controllers/BudgetExpenseController.php`,
`app/Http/Controllers/VendorPaymentController.php`,
`app/Http/Controllers/SavingsController.php`,
`app/Http/Controllers/SavingsGoalController.php`,
`app/Http/Controllers/SavingsContributionController.php`,
`app/Http/Controllers/SavingsAutomationController.php`,
`app/Http/Controllers/FinancialDashboardController.php`

### New migrations
```
2026_08_12_000000_create_budgets_table.php
2026_08_12_000001_create_budget_categories_table.php
2026_08_12_000002_create_budget_expenses_table.php
2026_08_12_000003_create_vendor_payments_table.php
2026_08_12_000004_create_savings_goals_table.php
2026_08_12_000005_create_savings_contributions_table.php
2026_08_12_000006_add_partner_to_invitations_table.php
```

### New views (Blade, mirroring existing structure)
```
resources/views/budget/dashboard.blade.php
resources/views/budget/category/index.blade.php
resources/views/budget/category/create.blade.php
resources/views/budget/category/edit.blade.php
resources/views/budget/expense/index.blade.php
resources/views/budget/expense/create.blade.php
resources/views/budget/expense/edit.blade.php
resources/views/budget/payment/index.blade.php
resources/views/budget/payment/create.blade.php
resources/views/savings/dashboard.blade.php
resources/views/savings/goal/index.blade.php
resources/views/savings/goal/create.blade.php
resources/views/savings/goal/edit.blade.php
resources/views/savings/contribution/index.blade.php
resources/views/savings/contribution/create.blade.php
resources/views/savings/automation/index.blade.php
resources/views/savings/projection.blade.php
resources/views/financial-overview/index.blade.php
```

### Edited existing files
- `routes/web.php` — register new route groups
- `resources/views/layouts/partial/user_sidebar.blade.php` — add nav entries (Anggaran, Tabungan)
- `database/seeders/SubscriptionSeed.php` — add `keuangan` feature keys
- `resources/views/dashboard/subscription-plans/form.blade.php` — add feature group
- `app/Models/User.php` — `budgets()`, `savingsGoals()` relationship helpers

---

## 8. Validation & Testing Strategy

- **Lint**: `./vendor/bin/pint --test` (Laravel Pint — already in `require-dev`)
- **Typecheck**: PHPStan not currently installed; recommend adding `nunomaduro/phpstan` as dev-dep, or run
  `php artisan test` for behavioural coverage.
- **Tests** (PHPUnit/Pest, already configured — see `tests/`):
  - `BudgetTest` — create/update budget, over-budget detection
  - `BudgetExpenseTest` — expense CRUD, category scope, spent aggregation
  - `VendorPaymentTest` — scheduling, status lifecycle, overdue detection
  - `SavingsGoalTest` — target math, progress %, auto-savings rule storage
  - `SavingsContributionTest` — multi-user insert, projection
  - `FinancialDashboardTest` — combined aggregation correctness
  - `SubscriptionGateTest` — Free/Basic/Pro access matrix
- **Feature gates verified** with `User::hasFeature()` mocks per plan tier.

**Lint / test commands to run per change-set:**
```bash
composer dump-autoload
php artisan migrate:fresh --seed     # validate migrations + seeders
./vendor/bin/pint --test             # lint PHP
php artisan test                     # Pest suite
```
