# 💚 Mental Wellness Website

A full-stack **Mental Wellness web application** built with **HTML, CSS, JavaScript, and PHP (with PHPUnit and Composer)**.  
This platform helps users **track their daily mood**, **book wellness sessions**, **chat with a simple wellness chatbot**, and **access curated mental health resources**.  
It features a login & signup system, secure backend integration with PHP/MySQL, a responsive frontend, and containerized deployment using **Docker**.


---

## ✨ Features
- 🔐 **Authentication**
  - User sign-up & login with session management  
  - Basic form validation & secure handling in PHP  

- 📊 **Daily Mood Tracking**
  - Users can log their daily mood  
  - Simple dashboard for tracking emotional progress  

- 📅 **Book Wellness Sessions**
  - Session booking system to connect with professionals  
  - Saves bookings in the backend  

- 🤖 **Chatbot Support**
  - Interactive chatbot that provides helpful wellness responses  
  - Offers motivation, reminders, and quick resource links  

- 🌐 **External Resources**
  - Links to curated guides, tips, and articles for mental health  

- 🎨 **Frontend**
  - HTML5, CSS3, and JavaScript  
  - Responsive and mobile-friendly  

- ⚙️ **Backend**
  - PHP application logic  
  - PHPUnit tests for backend validation  
  - Composer for dependency management  
  - Docker + docker-compose for containerized deployment  

---

## 🛠️ Tech Stack
- **Frontend:** HTML5, CSS3, JavaScript  
- **Backend:** PHP 8+  
- **Database:** MySQL (via Docker Compose)  
- **Chatbot:** JavaScript/PHP chatbot interaction  
- **Testing:** PHPUnit  
- **Deployment:** Docker, Docker Compose, Composer  

---

## 📂 Project Structure
```bash
mental-wellness/
├── CSS/                     # Styles  
├── HTML/                    # Web pages & templates  
├── PHP/                     # Backend scripts (auth, mood, chatbot, booking)  
├── Tests/                   # PHPUnit tests  
│
├── Dockerfile               # Docker config  
├── docker-compose.yml       # Container setup  
├── composer.json            # PHP dependencies  
├── composer.lock  
├── phpunit.xml              # PHPUnit config  
└── README.md                # Documentation  
```

---

## 🚀 Getting Started  

### 1. Clone the Repository  
```bash
git clone https://github.com/<your-username>/mental-wellness.git
cd mental-wellness
```

### 2. Run with Docker  
```bash
docker-compose up --build
```
Visit 👉 `http://localhost:8080`

### 3. Run Locally (Without Docker)  
```bash
composer install
php -S localhost:8080 -t HTML/
```

---

## 🧪 Running Tests
```bash
vendor/bin/phpunit
```

---

## 🖥️ Demo  

🌐 Live Demo: [mentalwellness.thsite.top](https://mentalwellness.thsite.top/)


---

## 👨‍💻 Author

([@Beba03](https://github.com/Beba03)) 
