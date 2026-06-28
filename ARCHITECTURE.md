# MyJobs — Architecture Documentation

---

## System Overview

MyJobs is an async job aggregation backend. It fetches remote job listings from external APIs, normalizes the data, stores it in a database, matches jobs against user preferences, and delivers notifications via Email and Telegram.

---

## Pipeline Diagram

```
┌─────────────────────────────────────────────────────────┐
│                  Laravel Scheduler                       │
│              (every 30 minutes via cron)                 │
└─────────────────────┬───────────────────────────────────┘
                      │ dispatch()
                      ▼
┌─────────────────────────────────────────────────────────┐
│                  FetchJobsJob                            │
│  - calls RemotiveClient::fetchJobs()                     │
│  - logs to job_fetch_logs (status, response_time_ms)     │
│  - dispatches NormalizeJobsJob                           │
└─────────────────────┬───────────────────────────────────┘
                      │ dispatch($rawJobs)
                      ▼
┌─────────────────────────────────────────────────────────┐
│                NormalizeJobsJob                          │
│  - calls RemotiveNormalizer::normalizeAll()              │
│  - maps API fields → DB fields                           │
│  - parses salary strings → salary_min / salary_max       │
│  - dispatches StoreJobsJob                               │
└─────────────────────┬───────────────────────────────────┘
                      │ dispatch($normalizedJobs)
                      ▼
┌─────────────────────────────────────────────────────────┐
│                  StoreJobsJob                            │
│  - calls JobSaveService::saveMany()                      │
│  - deduplicates by hash (md5(external_id + source))      │
│  - saves only new jobs to job_listings                   │
│  - dispatches MatchJobsToUsersJob                        │
└─────────────────────┬───────────────────────────────────┘
                      │ dispatch()
                      ▼
┌─────────────────────────────────────────────────────────┐
│              MatchJobsToUsersJob                         │
│  - loads active UserPreferences (with eager loading)     │
│  - chunks job_listings by 100                            │
│  - calls JobMatchingService::matches() for each pair     │
│  - creates JobMatch record if match found                │
│  - dispatches notifications only for new matches         │
└──────────────┬──────────────────────┬───────────────────┘
               │                      │
               ▼                      ▼
┌──────────────────────┐  ┌──────────────────────────────┐
│ SendEmailNotification│  │ SendTelegramNotificationJob   │
│        Job           │  │                              │
│ - sends JobMatchedMail│  │ - calls TelegramService      │
│   via SMTP           │  │ - sends HTML message to      │
│                      │  │   user's chat_id             │
└──────────────────────┘  └──────────────────────────────┘
```

---

## Services Layer

### Integrations
| Class | Responsibility |
|---|---|
| `RemotiveClient` | HTTP client for Remotive API. Returns raw jobs array. |

### Normalizers
| Class | Responsibility |
|---|---|
| `RemotiveNormalizer` | Maps Remotive API fields to DB schema. One normalizer per source. |
| `SalaryParserService` | Parses salary strings like `"$60k-$130k"` into `salary_min` / `salary_max` integers. Converts hourly rates to annual (×2080). |

### Core Services
| Class | Responsibility |
|---|---|
| `JobSaveService` | Deduplication + insert logic. Uses `JobRepository`. |
| `JobMatchingService` | Compares a `JobListing` against a `UserPreference`. Returns bool. |
| `NotificationDispatcherService` | Routes notifications. Sends email if user has email, Telegram if user has `telegram_chat_id`. |
| `UserPreferenceService` | CRUD for user preferences. Uses `Auth::id()` for scoping. |
| `JobService` | Paginated job listing queries. |
| `NotificationService` | Paginated match history queries. |

### Repositories
| Class | Responsibility |
|---|---|
| `JobRepository` | DB operations for `job_listings`. `existsByHash()`, `create()`. |

---

## Matching Logic

`JobMatchingService::matches(JobListing $job, UserPreference $pref): bool`

Checks in order:
1. If `remote_only = true` and job is not remote → **no match**
2. If keywords set → job title OR tags must contain at least one keyword (case-insensitive) → **no match** if none found
3. If categories set → job category must be in list → **no match** if not found
4. If locations set → job location must contain at least one location string → **no match** if none found
5. All checks passed → **match**

---

## Database Schema

```
users
├── id
├── name
├── email
├── telegram_chat_id (nullable)
└── timestamps

job_sources
├── id
├── name
├── slug (unique)
├── base_url
├── is_active
├── config (json, nullable)
└── timestamps

job_listings
├── id
├── job_source_id (FK)
├── title, company, description
├── url, external_url, external_id
├── location, is_remote
├── salary_min, salary_max, salary_currency
├── employment_type, category
├── tags (json)
├── hash (unique index)
├── published_at, fetched_at
└── timestamps

user_preferences
├── id
├── user_id (FK)
├── keywords (json)
├── locations (json)
├── categories (json)
├── salary_min, salary_max
├── remote_only
├── frequency (daily/weekly)
├── is_active (index)
└── timestamps

job_matches
├── id
├── user_id (FK)
├── job_listing_id (FK)
├── score (nullable)
├── unique(user_id, job_listing_id)
└── timestamps

job_fetch_logs
├── id
├── job_source_id (FK)
├── status (success/error)
├── items_fetched
├── response_time_ms
├── error_message
├── started_at, finished_at
└── timestamps
```

---

## Queue System

All heavy work runs asynchronously via Redis queues monitored by Laravel Horizon.

**Job retry strategy:**
- `$tries = 3` — retries up to 3 times on failure
- `$backoff = 60` — waits 60 seconds between retries
- Failed jobs are stored in `failed_jobs` table and visible in Horizon dashboard

**Horizon config:**
- `local` — max 3 worker processes
- `production` — max 10 worker processes with auto-scaling

---

## API

All endpoints rate-limited to 60 requests/minute per user.

```
GET  /api/jobs              — paginated job listings (public)
GET  /api/preferences       — get user preferences (auth)
POST /api/preferences       — create or update preferences (auth)
DELETE /api/preferences     — delete preferences (auth)
GET  /api/notifications     — matched jobs history (auth)
```

---

## Infrastructure

```
Docker Compose services:
├── app        — PHP-FPM (Laravel)
├── nginx      — web server, port 8000
├── mysql      — MySQL 8, persistent volume
├── redis      — Redis 7, persistent volume
├── horizon    — queue worker + dashboard
└── scheduler  — runs schedule:run every 60s
```
