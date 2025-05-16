<?php
session_name("user_session");
session_start();    
include 'connect.php';

// Ensure the database connection is established
$connection = mysqli_connect("localhost", "root", "", "login");

if (!$connection) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

$msg = '';
$msg_class = '';

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];

    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_name = mysqli_real_escape_string($connection, $name);
    $sanitized_msg = mysqli_real_escape_string($connection, $msg);

    $query = "INSERT INTO user_feedback(name, email, message) VALUES('$sanitized_name', '$sanitized_emailid', '$sanitized_msg')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $msg = 'Thank you for your feedback!';
        $msg_class = 'success';
    } else {
        $msg = 'Data not saved';
        $msg_class = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hive</title>
    <link rel="stylesheet" href="Feed.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.3.1"></script>
    <style>
        .msg-box {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none;
        }
        .msg-box.success {
            background-color: #4caf50;
            color: white;
        }
        .msg-box.error {
            background-color: #f44336;
            color: white;
        }
        .star-rating {
            text-align: center;
            margin-top: 20px;
        }

        .emojis {
            display: inline-block;
        }

        .emojis .emoji {
            font-size: 32px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .emojis .emoji:hover,
        .emojis .emoji.active {
            transform: scale(1.3);
        }
        header{
    z-index: 889;
    position: fixed;
    background-color: black;
    top: 0;
    left: 0;
    width: 100%;
    padding: 15px 200px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: 0.2s ease;
}

header.sticky{
    background-color: #0a0a0a;
    padding: 10px 200px;
}

header .brand{
    color: white;
    font-size: 1.8em;
    font-weight: 700;
    text-transform: uppercase;
    text-decoration: none;
}

header .navigation{
    position: relative;
}

header .navigation a{
    color: white;
    font-size: 1em;
    text-decoration: none;
    font-weight: 500;
    margin-left: 30px;
}

header .navigation a:hover{
    color: #3a6cf4;
}

header .sticky .navigation a:hover{
    color: black;
}

section{
    padding: 100px 200px;
}
    </style>
</head>
<body>
    <?php if ($msg != ''): ?>
        <div class="msg-box <?php echo $msg_class; ?>" id="msgBox"><?php echo $msg; ?></div>
    <?php endif; ?>

    <header>
        <a href="" class="brand" data-aos="zoom-in" data-aos-duration="1000">Book Hive</a>
        <div class="menu-btn"></div>
        <div class="navigation">
            <a href="MAIN.php" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">Home</a>
            <a href="Bookavail.php"data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">Pre-booking</a>
            <a href="Categories.php" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">Book Categories</a>
            <a href="Library Information.php" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">Library Information</a>
            <a href="Feed.php" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">Feedback</a>
        </div>
    </header>
    <section class="contact" id="contact">
          <div class="row">
            <div class="contact-form reveal">
              <h3>Feedback</h3>
              <form action="Feed.php" method="POST">
                <div class="input-box">
                  <input type="text" name="name" id="name" placeholder="Name">
                </div>
                <div class="input-box">
                  <input type="text" name="email" id="email" placeholder="Email">
                </div>
                <div class="input-box">
                  <textarea name="message" rows="8" cols="80" placeholder="Message"></textarea>
                </div>
                <div class="input-box">
                  <input type="submit" class="send-btn" name="send" value="Send">
                </div>
              </form>
              <div class="star-rating">
                <h4>Rate Us</h4>
                <div class="emojis">
                    <span class="emoji" data-rating="1">😡</span>
                    <span class="emoji" data-rating="2">😟</span>
                    <span class="emoji" data-rating="3">😐</span>
                    <span class="emoji" data-rating="4">😊</span>
                    <span class="emoji" data-rating="5">😍</span>
                </div>
            </div>
            </div>
          </div>
      </section>
      <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({offset:0});
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const msgBox = document.getElementById('msgBox');
            if (msgBox) {
                msgBox.style.display = 'block';
                setTimeout(() => {
                    msgBox.style.display = 'none';
                }, 3000);
                
                // Trigger confetti when message appears
                confetti({
                    particleCount: 200,
                    spread: 200,
                    origin: { y: 0.6 },
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emojis = document.querySelectorAll('.emojis .emoji');
            emojis.forEach(emoji => {
                emoji.addEventListener('click', function () {
                    emojis.forEach(e => e.classList.remove('active'));
                    this.classList.add('active');
                    const rating = this.getAttribute('data-rating');
                    console.log('Rating selected:', rating);
                    // You can send the rating to the server here if needed
                });
            });
        });
    </script>
</body>
</html>
