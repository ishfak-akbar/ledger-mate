# 📒 LedgerMate  
## Digital Ledger for Modern Businesses  

LedgerMate is a streamlined web application designed to help small business owners efficiently manage shop transactions, track customer payments, and monitor financial health. With multi-shop support, it replaces traditional paper ledgers by offering real-time insights into sales, dues, and daily summaries while generating professional receipts—all in one intuitive, secure platform.

---

## 🚀 **Features Overview**

### 👨‍💼 **Business Owner Features**
✅ Multi-shop management  
✅ Customer & supplier transaction tracking  
✅ Real-time sales & payment monitoring  
✅ Due amount tracking and clearance  
✅ Quick SMS messaging with pre-filled text for due payment reminders
✅ Financial summaries & daily insights  
✅ Professional receipt generation  
✅ Secure authentication with password recovery  
✅ Shop customization (name, category, address, notes)  

### 👥 **Customer & Supplier Management**
✅ Search customers by name or phone  
✅ Track payment history and dues  
✅ Supplier transaction support (purchase, payment, return)  
✅ Customer balance visibility  
✅ Quick due clearance process  

---

## 🧠 **Tech Stack**

| Layer          | Technology            |
|----------------|-----------------------|
| Backend        | Laravel 12            |
| Frontend       | Blade + CSS           |
| Database       | SQLite                |
| Authentication | Laravel Breeze        |
| UI/UX          | Custom responsive CSS |
| Icons          | Heroicons             |

---

## 💰 **Transaction Flow**

1. **Create Shop** → Add shop details (name, category, address)  
2. **Add Transaction** → Record customer sale with total, paid, and due amounts  
3. **Track Payments** → Monitor paid vs due amounts  
4. **Clear Dues** → Process pending payments  
5. **View Summary** → Check daily/weekly financial overview  
6. **Generate Receipt** → Print or save transaction record  

---

## 📊 **Supplier Management Flow**

1. **Add Supplier Transaction** → Record purchase, payment, or return  
2. **Track Supplier Balance** → Monitor owes/credit status  
3. **Search Suppliers** → Find by name or phone  
4. **View All Transactions** → Filter by date, type, or supplier  
5. **Clear Supplier Dues** → Record payments to suppliers  

---

## 🔍 **Search & Filter System**

### Customer Search
- Search by name or phone number  
- View transaction history and balance  
- Quick selection for new transactions  

### Supplier Search  
- Search existing suppliers  
- View transaction count and balance  
- Auto-fill supplier details  

### Transaction Filters  
- Filter by date range  
- Filter by customer/supplier name  
- Filter by transaction type  
- Reset filters functionality  

---

## 🎨 **UI/UX Highlights**

✅ **Consistent Red/Pink Theme** – Branded visual identity  
✅ **Toast Notifications** – Success/error feedback  
✅ **Interactive Tables** – Hover effects and clear data presentation  
✅ **Action Buttons** – Color-coded by purpose (red for delete, purple for suppliers)  
✅ **Financial Cards** – Visual summaries with color-coded borders  
✅ **Auto-Submit Filters** – Real-time filtering without submit buttons  

---

## 📦 **Installation Guide**

### 1️⃣ **Clone Repository**
```bash
git clone https://github.com/ishfak-akbar/ledger-mate.git
cd ledger-mate
```
### 2️⃣ **Install Dependencies**
```bash
composer install
npm install && npm run build
```
### 3️⃣ **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```
### **Update .env**
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
### 4️⃣ **Run Migrations**
```bash
php artisan migrate
```
### 5️⃣ **Start Development Server**
```bash
php artisan serve
```
**Visit 👉 http://127.0.0.1:8000**

---

## 🔮 Future Improvements

📈 **Advanced Analytics & Reporting** – Comprehensive financial insights, profit/loss statements, and custom reports  
📱 **Mobile App Version** – Native iOS and Android applications for on-the-go management  
🌐 **Multi-language Support** – Internationalization for global business users  
🔗 **API for Third-party Integrations** – RESTful API for accounting software and payment gateways  
📊 **Graphical Charts for Financial Trends** – Visual analytics with interactive charts and graphs

---

## 👩‍💻 Developer

**Ishfak Akbar Nahian**  
ID: 232-134-028  
Batch: 5th  
Project: LedgerMate  

---

**LedgerMate** – Simplifying business finances, one transaction at a time. 💼✨

