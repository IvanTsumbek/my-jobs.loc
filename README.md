# MyJobs 🚀

A mini SaaS backend system for aggregating remote job listings, matching them to user preferences, and delivering notifications via Email and Telegram.

---

## Features

- **Job Aggregation** — fetches remote jobs from external APIs (Remotive)
- **Data Normalization** — unified format regardless of source
- **Deduplication** — hash-based, no duplicate jobs in DB
- **User Preferences** — skills, location, categories, salary range
- **Matching Engine** — compares jobs against user preferences
- **Notifications** — Email (Mailtrap/SMTP) and Telegram Bot
- **Async Pipeline** — fully queue-based processing via Laravel Horizon
- **Scheduler** — automated fetching every 30 minutes
- **Logging** — structured logs for every pipeline stage
- **API** — RESTful JSON API with pagination and auth

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 |
| Queue | Redis + Laravel Horizon |
| Database | MySQL 8 |
| Cache | Redis |
| Auth | Laravel Sanctum + Breeze |
| Notifications | Mailtrap (dev), Telegram Bot API |
| Infrastructure | Docker, Nginx, PHP-FPM |

---

## Architecture

### Pipeline Flow

```
Scheduler (every 30 min)
        ↓
FetchJobsJob       — fetch raw data from Remotive API
        ↓
NormalizeJobsJob   — normalize to unified format + parse salary
        ↓
StoreJobsJob       — deduplicate by hash, save to DB
        ↓
MatchJobsToUsersJob — match jobs against user preferences
        ↓
NotificationDispatcherService
    ├── SendEmailNotificationJob
    └── SendTelegramNotificationJob
```

### Services Layer

```
app/
├── Integrations/
│   └── RemotiveClient.php         — HTTP client for Remotive API
├── Services/
│   ├── Normalizers/
│   │   └── RemotiveNormalizer.php — maps API response to DB format
│   ├── SalaryParserService.php    — parses salary strings to min/max integers
│   ├── JobSaveService.php         — deduplication + save logic
│   ├── JobMatchingService.php     — matches job vs user preferences
│   ├── NotificationDispatcherService.php — routes notifications to channels
│   ├── JobService.php             — job listing queries
│   ├── NotificationService.php    — notification history queries
│   └── UserPreferenceService.php  — user preferences CRUD
├── Repositories/
│   └── JobRepository.php          — DB operations for job listings
└── Jobs/
    ├── FetchJobsJob.php
    ├── NormalizeJobsJob.php
    ├── StoreJobsJob.php
    ├── MatchJobsToUsersJob.php
    ├── SendEmailNotificationJob.php
    └── SendTelegramNotificationJob.php
```

---

## Installation

### Requirements

- Docker
- Docker Compose

### Steps

```bash
# 1. Clone the repository
git clone <repo-url>
cd myjobs

# 2. Copy environment file
cp .env.example .env

# 3. Start containers
docker compose up -d

# 4. Install dependencies
docker exec -it laravel_app composer install

# 5. Generate app key
docker exec -it laravel_app php artisan key:generate

# 6. Run migrations and seeders
docker exec -it laravel_app php artisan migrate --seed

# 7. Open in browser
http://localhost:8000
```

### Environment Variables

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=my_jobs.loc
DB_USERNAME=root
DB_PASSWORD=root

REDIS_HOST=redis
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525

TELEGRAM_BOT_TOKEN=your_bot_token
```

---

## API Endpoints

### Public

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/jobs` | List all jobs (paginated) |

### Authenticated (Bearer Token)

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/preferences` | Get user preferences |
| POST | `/api/preferences` | Create or update preferences |
| DELETE | `/api/preferences` | Delete preferences |
| GET | `/api/notifications` | Get matched jobs history |

### Preferences Payload

```json
{
    "keywords": ["PHP", "Laravel"],
    "locations": ["remote", "EU"],
    "categories": ["Software Development"],
    "salary_min": 50000,
    "salary_max": 150000,
    "remote_only": true,
    "frequency": "daily"
}
```

---

## Queue & Scheduler

### Run manually

```bash
# Fetch and process jobs
docker exec -it laravel_app php artisan jobs:fetch

# Test matching for a user
docker exec -it laravel_app php artisan jobs:match-test 1
```

### Horizon Dashboard

```
http://localhost:8000/horizon
```

### Scheduler

Runs automatically every 30 minutes via the `scheduler` Docker container.
To check scheduled tasks:

```bash
docker exec -it laravel_app php artisan schedule:list
```

---

## Database Schema

| Table | Description |
|---|---|
| `users` | Auth users with optional telegram_chat_id |
| `job_listings` | Normalized job data from all sources |
| `job_sources` | External API sources (Remotive, etc.) |
| `job_matches` | Matched jobs per user |
| `user_preferences` | User filter preferences |
| `job_fetch_logs` | Pipeline execution logs |

---

## License

MIT
