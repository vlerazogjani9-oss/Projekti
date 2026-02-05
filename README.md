# PUNA IME – Projekti

Aplikacion web në PHP për platformën e punës “Puna Ime”: kryefaqe, lajme, produkte, oferta punësh, kontakt dhe panel administrimi.

---

## Struktura e projektit

Projekti/
├── admin/ # Panel administrimi (kërkon hyrje si admin)
│ ├── dashboard.php # Paneli kryesor – mesazhe, lajme, produkte, punë
│ ├── add_news.php # Shtim lajm (imazh + PDF)
│ ├── edit_news.php # Ndryshim lajm
│ ├── delete_news.php # Fshirje lajm
│ ├── add_product.php # Shtim produkt (imazh + PDF)
│ ├── edit_product.php # Ndryshim produkt
│ ├── delete_product.php # Fshirje produkt
│ ├── add_job.php # Shtim ofertë pune
│ ├── edit_job.php # Ndryshim ofertë
│ └── delete_job.php # Fshirje ofertë
├── assets/
│ ├── css/ # Stile (faqja1.css, about.css, contact.css, admin.css, loginform.css)
│ ├── images/ # Imazhe statike (logo, foto ekipi, etj.)
│ └── js/ # JavaScript (p.sh. slider, forma)
├── auth/
│ ├── loginform.php # Faqja e hyrjes
│ ├── registerform.php # Faqja e regjistrimit
│ └── logout.php # Dalje nga llogaria
├── classes/ # Modele dhe logjikë
│ ├── Database.php # Lidhja me MySQL
│ ├── User.php # Përdoruesit
│ ├── Contact.php # Mesazhet e kontaktit
│ ├── News.php # Lajmet
│ ├── Product.php # Produktet
│ ├── Job.php # Ofertat e punës
│ ├── Slider.php # Slider-i në kryefaqe
│ ├── SiteContent.php # Përmbajtje teksti (slogan, about, etj.)
│ ├── TeamMember.php # Anëtarët e ekipit (About)
│ └── Validator.php # Validimi i të dhënave
├── config/
│ └── database.php # Konfigurimi i bazës së të dhënave (host, db, user, fjalëkalim)
├── includes/
│ └── auth_check.php # Kontrollon nëse përdoruesi është i futur (për admin)
├── uploads/ # Skedarët e ngarkuar nga përdoruesi/admin
│ ├── news/ # Imazhet dhe PDF për lajmet
│ ├── products/ # Imazhet dhe PDF për produktet
│ └── slider/ # Imazhet e slider-it në kryefaqe
├── index.php # Kryefaqja (sllajde, oferta punësh, kërkim)
├── about.php # Rreth nesh
├── contact.php # Forma e kontaktit
├── news.php # Lista e lajmeve
├── products.php # Lista e produkteve
├── jobs.php # Faqja e punëve
├── schema.sql # Skema e bazës së të dhënave (tabela + seed)
└── hash.php # Skript ndihmës për hash të fjalëkalimeve (nëse ekziston)




---

## Dokumentacion

### Kërkesat
- PHP 7.4+ (me shtesë: PDO MySQL, `finfo` për MIME)
- MySQL/MariaDB (p.sh. XAMPP)
- Server web (Apache me mod_rewrite nëse përdoret, ose PHP built-in)

### Instalimi
1. Vendos projektin në `htdocs` (XAMPP) ose në dokument root të serverit.
2. Krijo bazën e të dhënave (p.sh. `projekti`) dhe ekzekuto `schema.sql` për të krijuar tabelat dhe të dhënat fillestare.
3. Në `config/database.php` përshtat: `$host`, `$db_name`, `$username`, `$password`.
4. Sigurohu që dosja `uploads/` dhe nëndosjet `uploads/news/`, `uploads/products/`, `uploads/slider/` ekzistojnë dhe janë të shkrueshme (p.sh. `chmod 755` ose 775).

### Faqet (pamjet) e aplikacionit
| Faqja        | Skedari       | Përshkrimi i shkurtër                    |
|-------------|----------------|------------------------------------------|
| Kryefaqja   | `index.php`    | Slider, slogan, kërkim punësh, listë ofertash |
| Rreth nesh  | `about.php`    | Tekst + anëtarët e ekipit                |
| Kontakt     | `contact.php`  | Forma e dërgesës së mesazheve            |
| Lajme       | `news.php`     | Lista e lajmeve me imazh/PDF              |
| Produkte    | `products.php` | Lista e produkteve me imazh/PDF          |
| Punët       | `jobs.php`     | Lista e ofertave të punës                 |
| Hyrje       | `auth/loginform.php`   | Login                                  |
| Regjistrim  | `auth/registerform.php`| Regjistrim i përdoruesve          |
| Admin       | `admin/dashboard.php`  | Paneli (pas login si admin)      |

### Bazë e të dhënave
- **Tabela:** `users`, `contact_messages`, `products`, `news`, `slider`, `site_content`, `team_members`, `jobs`.
- Përshkrimi i plotë i tabelave dhe lidhjeve gjendet në `schema.sql`.

---

## Si të ngarkosh pamje (screenshot) për çdo view

Në këtë projekt, “pamjet” janë faqet e aplikacionit (kryefaqja, lajme, produkte, kontakt, etj.). Mund të përdorësh dy qasje:

### 1. Ngarkimi përmes panelit të adminit (imazhe që shfaqen në faqe)

- **Lajme**  
  - Hyr si admin → Dashboard → “Shto lajm”.  
  - Fus titull dhe tekst, pastaj në formë zgjidh **Imazh**: JPG/PNG/GIF, max 5MB.  
  - Imazhet ruhen në `uploads/news/` dhe shfaqen në faqen e lajmeve.

- **Produkte**  
  - Dashboard → “Shto produkt”.  
  - Titull, përshkrim dhe **Imazh**: JPG/PNG/GIF, max 5MB.  
  - Ruhen në `uploads/products/` dhe shfaqen në faqen e produkteve.

- **Slider (kryefaqja)**  
  - Imazhet e slider-it lexohen nga tabela `slider` dhe nga dosja `uploads/slider/`.  
  - Nëse në projekt nuk ka formë “Shto slider” në admin, duhet të shtosh rreshta në tabelën `slider` (titull, subtitle, emri i skedarit të imazhit, `sort_order`, `active`) dhe të vendosësh vetë skedarët e imazheve në `uploads/slider/` (emri i skedarit në DB duhet të përputhet me emrin në server).

Kufizime të përbashkëta: vetëm JPG/PNG/GIF; madhësia maksimale 5MB; emri i skedarit pastrohet dhe shtohet timestamp për të shmangur mbishkrimet.

### 2. Screenshot-e për dokumentacion (README / raporte)

`![Kryefaqja](docs/screenshots/01-kryefaqja.png)`

