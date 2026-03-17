# Project Overview: Social Platform

This document summarizes the controllers, routes, pages, and overall flow for presentation.

## High-Level Flow
- Users authenticate (Laravel auth).
- `/home` shows the main feed with stories, posts, and sidebar suggestions.
- Posts can be created, edited, deleted, liked, commented, and saved.
- Profiles: My Profile (`/my-profile`) and Public Profile (`/user/{username}`).
- Messaging: `/messages` and `/messages/{id}` for chat threads.
- Settings: `/settings/profile` for account updates.

## Core Controllers
- `PostController`
  - Feed rendering, post creation, edit/update, delete, media updates, preview modal, load-more pagination.
- `ProfileController`
  - Settings update (profile + cover image), about info updates, account deletion.
- `MyAccountController`
  - My Profile sections, connections, public profile rendering.
- `CommentController` / `LikeController`
  - Comment CRUD and likes; post likes.
- `FollowController`
  - Follow/unfollow toggle and remove follower.
- `SavedPostController`
  - Save/unsave posts.
- `ChatController`
  - Messaging UI and send message endpoint.
- `SearchController`
  - Header user search dropdown results.
- `StoryController`
  - Story listing, upload, delete.
- `PlanController`
  - Subscription plans and subscription flow.

## Key Routes (Authenticated)
- Feed
  - `GET /home` -> `PostController@index`
  - `GET /posts/load-more` -> `PostController@loadMore`
- Posts
  - `POST /post` -> create
  - `GET /posts/{postId}/edit` -> fetch for edit modal
  - `POST /posts/{id}/update-modal` -> update post + media
  - `DELETE /posts/{id}` -> delete post
  - `GET /posts/{id}/preview` -> modal HTML
  - `POST /posts/{post}/save` -> save/unsave
- Profile & Settings
  - `GET /my-profile` -> `MyAccountController@index`
  - `GET /my-connections` -> `MyAccountController@connections`
  - `GET /user/{username}` -> public profile
  - `GET /settings/profile` -> profile settings
  - `PATCH /settings/profile` -> profile update
  - `POST /my-profile/about` -> inline about update
- Social
  - `POST /follow/{user}` -> follow/unfollow
  - `DELETE /followers/{user}` -> remove follower
  - `POST /like/{post}` -> toggle like
  - `POST /comments` -> add comment
  - `GET /comments/{postId}` -> fetch comments
  - `DELETE /comments/{id}` -> delete comment
- Messaging
  - `GET /messages` -> chat list
  - `GET /messages/{id}` -> open thread
  - `POST /send-message` -> send message
- Search
  - `GET /search/users?q=` -> header dropdown results

## Main Pages and Views
- Home: `resources/views/main/content/home/index.blade.php`
  - Feed, stories, create post modals, load-more.
- My Profile: `resources/views/main/content/myProfile/index.blade.php`
  - Tabs: About, Posts, Connections, Saved.
- Public Profile: `resources/views/main/content/userProfile/show.blade.php`
  - Posts grid, follow button, profile stats.
- Messages: `resources/views/main/content/messages/index.blade.php`
  - Chat list + thread.
- Settings: `resources/views/main/content/settings/index.blade.php`
  - Profile form, image/cover preview.

## Data Model Highlights
- Users
  - Profile image: `image`
  - Cover image: `cover_image`
- Posts
  - Media in `post_media`
  - Likes in `likes`
  - Comments in `comments`
  - Saved posts in `saved_posts` (pivot)
- Follows
  - Many-to-many via `followers` pivot.
- Messages
  - `messages` table with `sender_id`, `receiver_id`, `is_read`.

## UI Behaviors (Important)
- Modals load post preview HTML via `/posts/{id}/preview`.
- Follow/unfollow updates counts and UI via shared JS helpers.
- Saved posts are shown in My Profile under the “Saved” tab.
- Header search shows dropdown results (user profile links).

## Files You’ll Likely Mention in Presentation
- Controllers: `app/Http/Controllers/*`
- Routes: `routes/web.php`
- Layouts: `resources/views/main/body/master.blade.php`, `resources/views/main/body/header.blade.php`
- Feed: `resources/views/main/content/home/index.blade.php`
- Profile: `resources/views/main/content/myProfile/index.blade.php`
- Public Profile: `resources/views/main/content/userProfile/show.blade.php`
- Messages: `resources/views/main/content/messages/index.blade.php`

