# Document It

A blogging platform for developers with a terminal-inspired design, AI-powered content tools, and real-time notifications.

## Features

### Writing & Content
- Markdown editor with live preview
- AI writes content from your title when you click "write with AI"
- Auto-generates SEO, excerpts, and cover images with AI when left empty
- Categories and tags to organize posts
- Draft, publish, or schedule posts

### Social
- Follow/unfollow users
- Clap posts to show appreciation
- Bookmark posts to save for later
- User profiles with followers and following counts
- Real-time notifications via Pusher

### Smart Search
- Normal search across titles, content, and author names
- Type `smart/football` and AI expands it to related terms like soccer, sports, match
- Results are cached for fast repeat searches

### Feed
- Sort by recent, popular, or trending
- Filter by category and read time (short or long)
- NEW badge on posts from the last 24 hours
- Trending widget showing most liked and viewed posts

### Admin
- Role-based access control
- Super-admin manages users and categories
- Users manage their own posts

### UI
- Terminal-inspired dark theme with monospace fonts
- Responsive on desktop and mobile
- Sidebar navigation with context-aware highlights
- Terminal path display like `~/dashboard/posts`
- Green pulsing dot for unread notifications

## Tech Stack

- Laravel 13, PHP 8.3
- Blade + Tailwind CSS 4 + Vite
- MySQL
- Google Gemini AI
- Pusher + Laravel Echo
- Laravel Fortify + Socialite

## Setup

```bash
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate && php artisan db:seed
npm run build && php artisan serve
```

For real-time and AI features you will need Pusher, Google Cloud, and Google OAuth credentials.

## License

MIT
