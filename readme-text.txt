admin@admin.com
12345678

http://localhost/admin/login


✅ Dashboard

quick stats: total students, certificates issued, etc.

✅ Programs

add/manage degree programs

✅ Classes/Sections

group classes or sessions

✅ Students

import via CSV

manage details

✅ Certificates

list / generate / print

maybe later add bulk generation

re-issue if needed

✅ Settings

certificate templates

signatures, logos









initialize clean Laravel project (skip if already done)

push to Github repository for version control

install Filament Panel (if not done)

enable ->login() in Filament panel to get /admin/login

create settings table + Filament resource to store branding (name, logo, color, favicon)

link these settings to Filament’s brand name, color, favicon in AdminPanelProvider

build simple dashboard page in Filament with placeholder stats

create models/migrations/resources for:

Classes

Sections

Programs / Courses

Students

build relationships between students and class/section/program

add Filament resources for all above models

test manual student CRUD in panel

install maatwebsite/excel package

build CSV/Excel importers for students, classes, programs

create certificate_templates table with fields:

name

HTML content

style options

logo position

build Filament resource to manage certificate templates

add live preview of templates with sample data

create certificates table with:

certificate number

student id

template id

issued date

data fields (JSON)

file path

create Filament page to:

select student

select template

fill data

preview certificate

generate PDF of certificate and save to storage

add download button for certificate

add QR code in certificate with verify link

create a /verify/{certificate_number} public route for certificate lookup

show certificate verification details on this route

test end-to-end: create, issue, verify certificate

build multi-select / bulk generation page

add Laravel Job to generate multiple certificates PDFs in background

zip and store bulk PDFs

add sequence numbering rules in settings (prefix, start number, current number)

build admin edit page for sequence rules

adjust certificate number to auto-increment

add ability to customize template image/logo positions

test high quality export (PNG/JPEG) with browsershot if needed

plan for future APIs (using Laravel Sanctum)

plan for multi-organization (SaaS) if required later

final QA testing and polish

deploy to production

