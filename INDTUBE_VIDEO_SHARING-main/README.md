# Admin Panel for Video Management

This admin panel provides functionality for managing videos. It includes features for login, registration, uploading videos, and resetting passwords.

## Technologies & Features Used

The Video Management System leverages various technologies and features:

### Frontend
- **HTML, CSS, JavaScript:** Front-end technologies for creating a responsive and visually appealing user interface.
- **Bootstrap:** Bootstrap is a front-end framework for building responsive and visually appealing websites and web applications using HTML, CSS, and JavaScript.

### Backend
- **PHP:** Server-side scripting language for dynamic content generation and database interaction.
- **MySQL:** Relational database management system for storing and querying student and attendance records.

### Libraries
- **XLSX:** XLSX is a library for processing Excel files
- **jQuery:**  jQuery is a JavaScript library for simplifying frontend interactions and manipulation of HTML documents.
- **AJAX:** Asynchronous requests to update attendance records without refreshing the entire page, enhancing user experience.
- **Sessions:** User authentication and session management to control access to dashboard features based on login status.
- **Password Hashing:** Secure storage and verification of user passwords using bcrypt hashing algorithm, ensuring data privacy and security.

The user interface of the Attendance System prioritizes simplicity, functionality, and responsiveness:

- **Responsive Layout:** Built with Bootstrap for seamless adaptation to different screen sizes and devices.
- **Clear Presentation:** Attendance details are presented clearly and organized, facilitating easy understanding and navigation.
- **Intuitive Controls:** Buttons allow users to toggle attendance and save changes with ease, streamlining the attendance management process.

## Installation

1. Clone the repository:

```
git clone https://github.com/createunique/INDTUBE_VIDEO_SHARING.git
```

2. Import the database schema from `database.sql` into your MySQL database.

3. Update `includes/database.php` with your MySQL database credentials.

4. **Update SMTP Details in `reset_password.php`:**

   If you are using SMTP for sending password reset emails, you need to update the SMTP details in `reset_password.php` file:

   ```php
   // Replace the following SMTP details with your own SMTP configuration
   $mail->Host       = 'smtp.gmail.com';                  // Set the SMTP server to send through
   $mail->SMTPAuth   = true;                              // Enable SMTP authentication
   $mail->Username   = 'YOUR_GMAIL';                       // SMTP username
   $mail->Password   = 'GMAIL_PASSWORD';                   // SMTP password
   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Enable implicit TLS encryption
   $mail->Port       = 465;                                // TCP port to connect to

   $mail->setFrom('YOUR_GMAIL', 'INDTUBE');
   ```
   Replace 'YOUR_GMAIL' with your Gmail address and 'GMAIL_PASSWORD' with your Gmail password. Update other SMTP details like Host, Port, and any other authentication settings according to your SMTP server configuration.

## Usage

### Using Composer (recommended)
1. Install PHP and Composer on your server.

2. Create a new project:

```
composer create-project username/repository_name
```

3. Set up your web server to point to the public directory.

4. Install PHPMailer using Composer:

```
composer require phpmailer/phpmailer
```

5. Access the admin panel in your web browser.

### Manual Download
1. Download the repository as a ZIP file and extract it.

2. Upload the extracted files to your web server.

3. Download PHPMailer from [GitHub](https://github.com/PHPMailer/PHPMailer) as a ZIP file.

4. Extract the contents of the PHPMailer ZIP file.

5. Copy the `PHPMailer` directory to your project directory.

6. Now you should have a directory structure like this in your project:

```
your-project-directory/
├── PHPMailer/
│ ├── src/
│ └── ...
├── includes/
│ ├── database.php
│ └── ...
└── ...
```

7. Access the admin panel in your web browser.

## Features

- **Login:** Users can log in using their email and password.
- **Registration:** New users can register for an account.
- **Video Upload:** Admins can upload videos using an Excel file.
- **Password Reset:** Users can reset their password using a link sent to their email.

## Files

- `index.php`: Main file for the admin panel.
- `login.php`: Login page for users.
- `registration.php`: Registration page for new users.
- `videos.php`: Page for managing and displaying videos.
- `reset_pass.php`: Page for initiating the password reset process.
- `reset_password.php`: File for handling the password reset process.
- `includes/`: Directory containing PHP files for database connection and other functions.

## Project Flow

### Admin User Registration:
Admin users need to register their accounts to access the system.

### Excel File Upload:
After registration, admins can upload Excel files containing video information. Each Excel file typically includes data like category, title, link, section, and subsection for each video.

### Data Processing:
Upon file upload, the server processes the Excel data, extracting relevant information using JavaScript (possibly with libraries like XLSX).
The data is then converted into JSON format for easier manipulation.

### Database Update:
The processed video information is then uploaded to the database, likely in a structured format suitable for querying and retrieval.

### Dashboard Display:
Once uploaded, the videos are displayed on a home or dashboard page.
Videos are organized by section and subsection, possibly sorted in a specific order.
Each video entry typically displays relevant information such as section, title, and a link to access the video.

### User Interaction:
Users, including admins and possibly other roles, can interact with the dashboard to view, search, or filter videos based on their preferences.

## Contributing

Feel free to contribute to this project by submitting pull requests or reporting issues. Your feedback is highly appreciated.

## License

This project is licensed under the MIT License - see the `LICENSE` file for details.

---

Please replace `your-username` and `your-repository` with your actual GitHub username and repository name respectively. Also, make sure to replace the MySQL database credentials with your actual credentials in `includes/database.php`.
