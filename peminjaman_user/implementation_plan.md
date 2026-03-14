# Implementation Plan: Flutter User App

## Goal Description
Build the user-facing side of the book borrowing application using Flutter, since the backend is already developed in Laravel. The application will allow users (siswa) to log in, view available books, and check their borrowing history.

## Proposed Changes

### 1. Flutter Folder Structure
Create the following directories and files inside `c:\laragon\www\peminjaman-buku\peminjaman_user\lib`:
- **[NEW]** `lib/core/api_client.dart` - Setup Dio or http for API calls with token interception.
- **[NEW]** `lib/core/constants.dart` - API URLs and constants.
- **[NEW]** `lib/models/user.dart` - User data model.
- **[NEW]** `lib/models/book.dart` - Book data model.
- **[NEW]** `lib/models/transaction.dart` - Borrowing transaction model.
- **[NEW]** `lib/screens/login_screen.dart` - Login UI.
- **[NEW]** `lib/screens/home_screen.dart` - Main dashboard for users.
- **[NEW]** `lib/screens/books_screen.dart` - List of all books.
- **[NEW]** `lib/screens/history_screen.dart` - Borrowing history.
- **[NEW]** `lib/main.dart` - App entry point with routes.

### 2. Laravel Backend API (If necessary)
- We will need to expose APIs in Laravel (`routes/api.php`) for the Flutter app to consume:
  - `POST /api/login` - Authenticate users with Sanctum token.
  - `GET /api/books` - List all books.
  - `GET /api/transactions` - List transactions for the logged-in user.

## Verification Plan
### Automated Tests
- Run `flutter analyze` inside the `peminjaman_user` folder to ensure code has no syntax errors.

### Manual Verification
- Compile and run the Flutter app locally using `flutter run` or deploy to an Android emulator.
- Try logging in with a test user credential.
- Check if the books list loads correctly.
