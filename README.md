# Document It

A modern blogging platform built with Laravel, designed for developers who love writing in Markdown. Terminal-inspired UI, AI-powered features, and real-time notifications.

## Features

### Writing & Content
- **Markdown editor** with live preview — write in Markdown, see rendered HTML instantly
- **AI-powered writing** — click "write with AI" and it generates content from your title
- **Auto-generated SEO** — title, description, keywords, and excerpt created by AI when left empty
- **Auto-generated cover images** — AI creates cover images if you don't upload one
- **Categories & tags** — organize posts with categories and tags
- **Draft & publish** — save as draft or publish immediately, schedule for later

### Social Features
- **Follow/unfollow users** — follow authors you like
- **Like (clap) posts** — show appreciation for good content
- **Bookmark posts** — save posts to read later
- **User profiles** — view posts, followers, and following count
- **Real-time notifications** — get notified instantly when someone follows you (via Pusher)

### Smart Search
- **Normal search** — searches titles, content, excerpts, and author names
- **AI smart search** — type `smart/your query` and AI expands it with related keywords
- **Cached results** — search expansions are cached for fast repeated searches

### Feed & Discovery
- **Sort by** — recent, popular (views), trending (likes)
- **Filter by category** — browse posts by category
- **Filter by read time** — short reads (< 5min) or long reads (> 10min)
- **NEW badge** — posts from the last 24 hours show a green "NEW" badge
- **Trending widget** — shows most liked/viewed posts

### Authentication
- **Google OAuth** — sign in with your Google account
- **Email/password** — traditional registration and login
- **Passkeys** — passwordless authentication support
- **Two-factor auth** — optional 2FA for extra security

### Admin Panel
- **User management** — create, edit, delete users (super-admin only)
- **Role-based access** — assign roles with specific abilities
- **Category management** — admin-only category CRUD
- **Post management** — owners can manage their own posts, admins can manage all

### UI/UX
- **Terminal-inspired design** — dark theme with monospace fonts and terminal-style elements
- **Responsive layout** — works on desktop and mobile
- **Sidebar navigation** — clean sidebar with context-aware highlights
- **Terminal path display** — see your current location like `~/dashboard/posts`
- **Animated notifications** — green pulsing dot for unread notifications
- **Post card redesign** — clean cards with metadata, excerpt, and engagement icons

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3
- **Frontend:** Blade templates, Tailwind CSS 4, Vite
- **Database:** MySQL
- **Queue:** Database driver (for background jobs)
- **AI:** Google Gemini via Laravel AI
- **Real-time:** Pusher + Laravel Echo
- **Auth:** Laravel Fortify + Socialite (Google OAuth)

## Setup

```bash
# Clone the repo
git clone <repo-url>
cd document-it

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Build frontend
npm run build

# Start the server
php artisan serve
```

For real-time notifications and AI features, you'll need:
- Pusher account (for broadcasting)
- Google Cloud project (for Gemini API)
- Google OAuth credentials (for social login)

## How Smart Search Works

```
~/football              → normal search (titles, content, authors)
~/smart/football        → AI expands to related terms, searches titles only
```

The AI expansion is cached for 1 hour, so the same search is instant on repeat.

## License

MIT
