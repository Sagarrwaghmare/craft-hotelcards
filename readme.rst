###################################################################
HotelCards — Hotel Membership, Events & Visitor Management System
###################################################################

HotelCards is a membership, outreach, and visitor tracking portal built on **CodeIgniter 3 (PHP 8+ compatible)** with **Tailwind CSS**, **Flatpickr**, and **FontAwesome 6**. The system features role-based access control (RBAC), WhatsApp automated greetings, dual Dark/Light mode, and comprehensive family (co-member) management.

*******************
System Architecture
*******************

* **Framework:** CodeIgniter 3 (PHP 8.1+ compatible with ``#[AllowDynamicProperties]``)
* **Frontend:** Tailwind CSS (via CDN), FontAwesome 6, Flatpickr
* **Theming:** Native Dark Mode by default with zero-refactor Light Mode overrides persisted in ``localStorage``
* **Typography:** Root scaled via ``html { font-size: 17.5px; }`` with modern sans-serif fonts

******************************
Database Schema & Core Modules
******************************

1. Users (``users``)
====================
Manages portal staff and administrative access.

* ``id``: INT(11) Primary Key, Auto Increment
* ``name``: VARCHAR(100)
* ``email``: VARCHAR(150) UNIQUE
* ``contact_no``: VARCHAR(20) NULL
* ``username``: VARCHAR(50) UNIQUE
* ``password_hash``: VARCHAR(255) (Bcrypt)
* ``access``: ENUM('Admin', 'Editor', 'Viewer') DEFAULT 'Viewer'
* ``created_at``, ``updated_at``: TIMESTAMP

2. Members (``members``)
========================
Primary registered hotel club members.

* ``id``: INT(11) Primary Key, Auto Increment
* ``card_number``: VARCHAR(50) UNIQUE (Format: ``666-YYYY-XXXX`` for Gold, ``999-YYYY-XXXX`` for Platinum)
* ``card_type``: ENUM('Gold', 'Platinum')
* ``first_name``, ``last_name``: VARCHAR(100)
* ``company_name``: VARCHAR(150) NULL, ``designation``: VARCHAR(100) NULL
* ``contact_no``: VARCHAR(20) NULL, ``email``: VARCHAR(150) NULL
* ``address``: TEXT NULL
* ``dob``: DATE NULL, ``anniversary``: DATE NULL
* ``marital_status``: ENUM('Single', 'Married', 'Divorced', 'Widowed', 'Other') DEFAULT 'Single'
* ``notes``: TEXT NULL
* ``created_at``, ``updated_at``: TIMESTAMP

3. Co-Members / Family (``comembers``)
======================================
Family members linked directly to a primary cardholder (Many-to-One).

* ``id``: INT(11) Primary Key, Auto Increment
* ``member_id``: INT(11) Foreign Key referencing ``members(id)`` (ON DELETE CASCADE)
* ``name``: VARCHAR(150)
* ``relationship``: ENUM('Wife', 'Husband', 'Son', 'Daughter', 'Father', 'Mother', 'Others')
* ``contact_no``: VARCHAR(20) NULL
* ``dob``: DATE NULL
* ``created_at``, ``updated_at``: TIMESTAMP

4. Visits (``visits``)
======================
Dine-in and club visitor logs for cardholders.

* ``id``: INT(11) Primary Key, Auto Increment
* ``member_id``: INT(11) Foreign Key referencing ``members(id)`` (ON DELETE CASCADE)
* ``visit_date``: DATE
* ``no_of_pax``: INT(11) (Enforced between 1 and 25)
* ``apc``: DECIMAL(10,2) (Stores Total Billing amount; APC is dynamically calculated as Billing / PAX)
* ``created_by``: INT(11) Foreign Key referencing ``users(id)`` NULL
* ``created_at``, ``updated_at``: TIMESTAMP

****************
Key Features
****************

* **Dashboard (Overview & Events Schedule):**
  * Interactive Gold/Platinum metric cards filter upcoming events.
  * Chronological event scheduler calculating the next upcoming birthday or anniversary relative to today.
  * **Co-Member Integration:** Displays family birthdays directly in the scheduler formatted as ``Co-Member (Relation of Primary Member)``.
  * Direct WhatsApp connect with pre-filled greeting links and 20% dine-in promotion.

* **Members Directory:**
  * Year-independent Flatpickr range filters for Birthday and Anniversary (``DD-MM-YYYY`` display).
  * Direct co-member count indicator badge per member.
  * Single Edit vs Bulk Edit (selecting 1 member opens full edit; selecting 2+ opens Bulk Edit Modal).
  * Batch deletion for Administrators.

* **Export CSV System:**
  * Modal prompt offering **Standard Member Export** or **Export with Co-Members**.
  * Multi-row outline structure: outputs co-members on dedicated sub-rows directly below their parent member without repeating the serial number.
  * Phone and Card Numbers escaped as ``="<number>"`` to prevent Excel mathematical formula evaluation errors.

* **Member Details & Visitor Logs:**
  * Inline Co-Member management: Add, edit, single delete, and bulk delete with multi-select checkboxes.
  * Visitor log table with total spend summary and dynamic APC calculation (with zero-division protection).
  * Add Visit modal with automated validation.

* **Role-Based Access Control (RBAC):**
  * **Admin:** Full read/write/delete permissions across members, co-members, visits, and user administration.
  * **Editor:** Add/edit members, co-members, and visits. Cannot delete records or access User Management.
  * **Viewer:** Read-only access across all directories; edit forms are disabled and action buttons hidden.

**********************************
Installation & Server Setup Guide
**********************************

1. Database Setup
=================
Create a MySQL database named ``hotelcards`` (or your server DB name) and import your SQL schema including the ``users``, ``members``, ``comembers``, and ``visits`` tables.

2. Environment Configuration (``.env``)
=======================================
Create a file named ``.env`` in the **root directory** (same folder as ``index.php``):

.. code-block:: env

    # Environment (development, testing, production)
    CI_ENV=development

    # Application Base URL (Include trailing slash)
    # Localhost example: http://localhost/craft/hotelcards/
    # Live domain example: https://yourdomain.com/
    BASE_URL=http://localhost/craft/hotelcards/

    # URI Routing Protocol (REQUEST_URI or PATH_INFO)
    URI_PROTOCOL=REQUEST_URI

    # Database Credentials
    DB_HOSTNAME=localhost
    DB_USERNAME=root
    DB_PASSWORD=
    DB_DATABASE=hotelcards
    DB_DRIVER=mysqli

3. Apache Server Rewrite (``.htaccess``)
========================================
Create or update your root ``.htaccess`` file with this configuration (handles Cloudways, cPanel, Apache, and PHP-FPM):

.. code-block:: apache

    <IfModule mod_rewrite.c>
        RewriteEngine On

        # 1. CRITICAL: Block public access to .env, git, and composer files
        <FilesMatch "^\.env|\.git|composer\.(json|lock)">
            Require all denied
        </FilesMatch>

        # 2. Exclude real files and directories (CSS, JS, images in /assets)
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d

        # 3. Universal CI3 rewrite (The ?/ works on both XAMPP and Cloudways/PHP-FPM)
        RewriteRule ^(.*)$ index.php?/$1 [L,QSA]
    </IfModule>

**************************************************
Crucial Troubleshooting & Server Warnings
**************************************************

WARNING: ``URI_PROTOCOL`` Settings
==================================
* **On Live Servers (Cloudways, cPanel, Ubuntu, Nginx Reverse Proxy, FastCGI/PHP-FPM):**
  Always use:
  ``URI_PROTOCOL=REQUEST_URI``
* **On Local Windows / XAMPP / Apache mod_php:**
  If clicking menu links gives you a 404 or routes to the homepage, switch your ``.env`` to:
  ``URI_PROTOCOL=PATH_INFO``

WARNING: When Hosting Blocks ``.env``
====================================
Some shared hosting providers restrict file reads or environment variables. If you ever experience issues where your ``.env`` values are not loading:
1. Open ``application/config/config.php`` and hardcode your base URL:
   ``$config['base_url'] = 'https://yourdomain.com/';``
   ``$config['uri_protocol'] = 'REQUEST_URI';``
2. Open ``application/config/database.php`` and enter your database credentials directly in the ``$db['default']`` array.

WARNING: Never Remove the ``.env`` Apache Block
===============================================
Because the ``.env`` file is located in the web root, your ``.htaccess`` **must** contain:

.. code-block:: apache

    <FilesMatch "^\.env">
        Require all denied
    </FilesMatch>

If this rule is removed, anyone on the internet can navigate to ``https://yourdomain.com/.env`` and view your raw database credentials.

***************************
Default Seed Credentials
***************************

* **Password for all seed users:** 
* **Administrator:** ``admin`` / ``admin2``