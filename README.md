# 🐾 Pabaro savu mājdzīvnieku

**Autori:** Matīss Petrausks, Viktorija Šabanova, Alise Kaļiņina
**Projekta veids:** Studiju darbs (PHP, MySQL, OpenAI)

---

## 📌 Projekta apraksts

“Pabaro savu mājdzīvnieku” ir tīmekļa spēle, kurā lietotājs var reģistrēties, izvēlēties savu mājdzīvnieku un saņemt personalizētu horoskopu. Spēles unikālā funkcionalitāte ir integrēta mākslīgā intelekta sistēma, kas izmanto zodiaka zīmi, planētu pozīcijas un noskaņas, lai ģenerētu emocionāli piesaistošu horoskopu.

---

## 🚀 Funkcionalitāte

- ✅ Reģistrācija un autentifikācija
- ✅ Mājaslapa ar mīluļa statusu
- ✅ Personalizēti horoskopi (ikdienas)
- ✅ Zodiaka zīmes aprēķins pēc dzimšanas datuma
- ✅ Horoskopa glabāšana datubāzē
- ✅ Noskaņas (pozitīva, neitrāla, negatīva) ietekme
- ✅ Datu validācija, sesijas kontrole
- ✅ Saglabāšana lokāli ar `localStorage` (taimeris, horoskops)

---

## ⚙️ Uzstādīšana

### Priekšnosacījumi

- PHP 8+
- MySQL
- XAMPP / Apache vai cits web serveris
- OpenAI API atslēga (https://platform.openai.com)
- InfinityFree vai cits hostings (ja nepieciešams)

### Instalācija

```bash
git clone https://github.com/vshabanova/tamagochi.git
cd tamagochi
```

Importē 2025_proj_dzivnieki datubāzi MySQL (izveido tabulas: lietotaji, dzivnieki, horoskopi, zvaigznaji), kas ir iekš datubāze mapes.

Aizpildi config.php ar saviem iestatījumiem:

```bash
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "2025_proj_dzivnieki");
define("OPENAI_KEY", "sk-..."); // Tava OpenAI API atslēga
```

Atver register.php, izveido lietotāju un sāc spēli ar home.php.

## 🧠 Mākslīgais intelekts

Horoskops tiek ģenerēts izmantojot OpenAI gpt-3.5-turbo modeli
Tiek ņemti vērā:
- Planētu pozīciju simulācija / reālie dati
- Zodiaka zīmes raksturs (zodiac_personalities.json)
- Astroloģiskās mājas (houses.json)
- Emocionālā noskaņa (tiek izvēlēta pēc nejaušības principa)

## 💻 Izmantotās tehnoloģijas

PHP – servera puse
MySQL – datu glabāšana
JavaScript – interaktivitāte (taimeris, horoskops)
HTML/CSS – lietotāja saskarne
OpenAI API – horoskopa ģenerēšana
InfinityFree – bezmaksas hostings

## 📸 Vizuāls izskats

### ✅ Kad tiek ģenerēts horoskops
![Horoskopa Ģenerēšana](https://i.imgur.com/szPqCsS.png)

### 💾 Kad vēsturē tas tiek saglabāts
![Vēsture](https://i.imgur.com/p1dRqyT.png)

### 😴 Dinamiska gulēšana
![gulet](https://i.imgur.com/xinnclm.png)

### 🍽️ Personalizēti ēdieni

**Kaķiem**  
![kakis](https://i.imgur.com/v1KQEXy.png)

**Suņiem**  
![sunis](https://i.imgur.com/gxoehKB.png)

**Zaķiem**  
![zakis](https://i.imgur.com/iMLoDhT.png)
