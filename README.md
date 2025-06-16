De test users zijn:
Voor een normale user email:test@example.com
pw:liedenleed
voor een admin user email:admin@example.com
pw:liedenleed
# Lief-en-Leed

**Automatiseringsproject voor de Lief & Leed Pot van Gemeente Almere**

## 1. Inleiding

Dit project is opgezet in samenwerking met de personeelsvereniging van Gemeente Almere om het proces rondom de Lief & Leed Pot te digitaliseren. Medewerkers kunnen maandelijks vrijwillig bijdragen aan deze pot, waarvan bij bijzondere gebeurtenissen een geldbedrag beschikbaar wordt gesteld.

## 2. Opdrachtgever

**Gemeente Almere – Personeelsvereniging**

## 3. Projectleider

**Hans Pieters**

## 4. Achtergrond en Aanleiding

De Lief & Leed Pot ondersteunt medewerkers bij bijzondere gelegenheden zoals jubilea, ziekte of pensionering. Momenteel verloopt het proces handmatig, wat inefficiënt is. Dit project beoogt het proces te automatiseren, inclusief:

- Digitale aanvraagverwerking
- Automatische controle op basis van leeftijd en dienstjaren
- Integratie met Mollie voor uitbetalingen

## 5. Doelstelling

Automatiseren van het aanvraagproces, automatische controles en betalingen om administratieve lasten te verlagen en de efficiëntie te verhogen.

## 6. Scope

**In scope:**

- Digitaal aanvraagportaal
- Automatische controles (leeftijd, dienstjaren)
- Handmatige beoordeling bij ziekte
- Mollie-integratie voor betalingen

**Buiten scope:**

- Wijzigingen in contributiestructuur
- Integratie met externe HR-systemen (m.u.v. geboortedata en dienstjaren)

## 7. Resultaten en Deliverables

- Digitaal aanvraagformulier
- Geautomatiseerd controlesysteem voor jubilea
- Dashboard voor handmatige beoordeling (ziektegevallen)
- Rapportagemodule (inzichten in aanvragen & betalingen)

## 8. Planning

| Fase                         | deadline     |
|-----------------------------|---------------|
| Initiatie & Analyse         | [6 mei 2025]  |
| Documentatie                | [14 mei 2025] |
| Ontwikkeling & Testen       | [2 juni 2025] |            |
| Evaluatie & Optimalisatie   | [7 juni 2025] |

## 9. Kosten en Budget

De exacte kosten worden bepaald op basis van een nadere analyse. Verwachte kostenposten zijn:

- Softwareontwikkeling
- Implementatie en koppelingen
- Onderhoud en ondersteuning

## 10. Risico’s en Beheersmaatregelen

| Risico                                 | Beheersmaatregel                                     |
|----------------------------------------|------------------------------------------------------|
| Onvoldoende acceptatie door medewerkers| Training & communicatiecampagne                      |
| Onjuiste automatische controles        | Testfase met steekproeven                            |

## 11. Stakeholders

- Medewerkers Gemeente Almere  
- HR-afdeling  
- IT-afdeling  
- Financiële administratie  
- Mollie (betalingsverwerker)

## 12. Succescriteria

- Minimaal 50% minder administratieve handelingen  
- Positieve gebruikerservaring bij medewerkers

## 13. Communicatie & Rapportage

- Regelmatige e-mailupdates en projectmeetings met stakeholders  
- Evaluatierapport na livegang

## 14. Afronding en Evaluatie

Feedback wordt verzameld en optimalisaties worden doorgevoerd. Het project wordt afgerond met een eindrapport en overdracht aan het beheerteam.

## 15. Bijlage: Gebeurtenissen in de Lief & Leed Pot

- Geboorte  
- Verhuizing naar Almere  
- Ziekte (algemeen, 3 weken, 3 maanden, ziekenhuisopname)  
- Huwelijk/geregistreerd partnerschap  
- Ontslag/FPU/pensionering  
- Verjaardagen: 30, 40, 50, 60, 65 jaar  
- Jubilea: 12,5 en 25 jaar huwelijk, 12,5, 25, 40 jaar overheidsdienst  
- Overlijden van ambtenaar of huisgenoot  

---
# Lief-en-Leed – Installatie & Uitvoeren

## Systeemvereisten
- PHP 8.1 of hoger
- Composer
- Node.js & NPM
- MySQL of SQLite database
## Installatie

1. **Clone de repository**
git clone https://github.com/Repsej07/Lief-en-leed.git
cd Lief-en-leed/LiefenLeed


2. **Installeer PHP dependencies**
composer install


3. **Installeer JavaScript dependencies**
npm install
npm run build


4. **Kopieer en configureer de environment file**
cp .env.example .env

1. **Genereer de applicatiesleutel**
php artisan key:generate


6. **Voer de database migraties en seeders uit**
php artisan migrate --seed


7. **Start de ontwikkelserver**
php artisan serve

De applicatie is nu bereikbaar op [http://localhost:8000].

---
## Testen

- **Alle tests draaien**
php artisan test


---

## Deployment (productie)

- Zet de code op een Linux-server
- Stel de `.env`-variabelen in voor productie
- Voer migraties uit:
php artisan migrate --force

- Cache configuratie en routes:
php artisan config:cache
php artisan route:cache
php artisan view:cache


