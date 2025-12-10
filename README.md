Personal Finance Tracker — PHP & MySQL

A lightweight dashboard to track your incomes, expenses, and overall budget.

📌 About the Project

This project is a beginner-friendly introduction to PHP, MySQL, CRUD operations, and form handling through a practical real-world application:
a personal finance tracker.

A local startup needed a very first version of their budgeting tool, and this project represents that MVP (Minimum Viable Product).
The goal: build a simple, clean, and functional interface that lets users understand their finances at a glance.

🚀 Features
🔹 Incomes Management

View all incomes in a structured table

Add a new income

Edit existing entries

Delete an income

Server-side data validation

Automatic date handling

🔹 Expenses Management

View all expenses

Add a new expense

Edit and update entries

Delete an expense

Validation and error handling

Auto-fill date if not provided

🔹 Dashboard Overview

Total incomes

Total expenses

Current balance (Income − Expenses)

Incomes & expenses for the current month

(Optional) A simple visual chart

🗄️ Database Structure

All SQL queries are grouped inside database.sql.
The database contains:

✔️ incomes
✔️ expenses

Each table includes:

Primary key (id)

Amount (INT)

Description (TEXT or VARCHAR)

Date (DATE, with default CURRENT_DATE)

Optional:

A categories table to classify transactions

🧪 Core User Stories
📘 Database Design

Create the project database

Design the incomes table

Design the expenses table

Add primary keys and constraints

Use proper SQL types for money, text, and dates

📗 Backend Logic

Everything follows CRUD principles:

Feature	SQL Action
Add income/expense	INSERT
Edit entries	UPDATE
Remove entries	DELETE
Display data	SELECT

All interactions are done through PHP using prepared statements to ensure safe and clean queries.

✨ Bonus Enhancements (Optional)

If you want to push the project further:

Add categories for organizing transactions

Filter by category, month, or custom date range

Export transactions to PDF or CSV

Add beautiful visual charts using Chart.js or Google Charts

Implement a simple login & registration system

Add sorting (by date, amount…) to tables

Create monthly or yearly summaries

🛠️ Tech Stack

PHP 8+

MySQL / MariaDB

HTML/CSS (Light UI)

(Optional) JS charts

📦 Project Structure
/project-root
│── index.php
│── income.php
│── expenses.php
│── dashboard.php
│── db.php
│── database.sql
│── assets/
│     └── styles.css

▶️ How to Run

Import database.sql into your MySQL server

Configure your credentials in db.php

Start a local server (XAMPP / WAMP / MAMP)

Open the project in your browser

http://localhost/finance-tracker/

🎯 Purpose of the Project

This application is perfect for learning:

PHP backend development

SQL creation & CRUD

Clean form processing

Data validation

Dashboard logic

Basic financial summaries

It’s intentionally simple so students can understand every line of code and evolve it as their skills grow.
