<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Information</title>
    <link rel="stylesheet" href="Library Information.css"> <!-- Optional external CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
   
</head>
<body>
    
<header>
        <a href="" class="brand" >Book Hive</a>
        <div class="menu-btn"></div>
        <div class="navigation">
            <a href="#main" >Home</a>
            <a href="Bookavail.php">Pre-booking</a>
            <a href="Categories.php" >Book Categories</a>
            <a href="#services" >Library Information</a>
            <a href="Feed.php">Feedback</a>
            
            
            
        </div>
    </header>
    <style>
        
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

*{
    padding: 0;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}

body{
    width: 100%;
    height: auto;
    overflow-x: hidden;
}
body {
    background-image: url('Lib (2).jpg');
    background-size: cover;
    background-position: center;
}



.title{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.section-title{
    position: relative;
    color: #ffca4e;
    font-size: 2.2em;
    font-weight: 800;
    margin-bottom: 60px;
}

.section-title::before{
    content: "";
    position: absolute;
    top: 56px;
    left: 50%;
    width: 140px;
    height: 4px;
    background-color: #040a1c;
    transform: translateX(-50%);
}

.section-title::after{
    content: "";
    position: absolute;
    top: 50px;
    left: 50%;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: #3a6cf4;
    transform: translateX(-50%);
}
/* Contact */

.contact .content{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    flex-direction: column;
    margin-top: 20px;
  }
  
  .contact .content .row{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    flex-direction: row;
  }
  
  .contact .content .row .card{
    background: transparent;
    backdrop-filter: blur(9px);
    width: 240px;
    margin: 20px;
    padding: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    box-shadow: 0 5px 25px rgba(1 1 1 / 15%);
    border-radius: 10px;
  }
  
  .contact .content .row .card .contact-icon{
    color: #3a6cf4;
    font-size: 4em;
    text-align: center;
    transition: transform 0.5s ease;
  }
  
  .contact .content .row .card:hover .contact-icon{
    transform: translateY(-10px);
  }
  
  .contact .content .row .card .info{
    text-align: center;
  }
  
  .contact .content .row .card .info h3{
    color: #111;
    font-size: 1.2em;
    font-weight: 700;
    margin: 10px;
  }
  
  .contact .content .row .card .info span{
    color: white;
    font-weight: 500;
  }
  
  .contact-form{
    background: lavender;
    max-width: 600px;
    margin-top: 50px;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 5px 25px rgba(1 1 1 / 15%);
  }
  
  .contact-form h3{
    color: #111;
    font-size: 1.6em;
    font-weight: 600;
    text-align: center;
    margin-bottom: 40px;
  }
  
  .contact-form .input-box{
    position: relative;
    width: 100%;
    margin-bottom: 20px;
  }
  
  .contact-form .input-box input,
  .contact-form .input-box textarea{
    color: #111;
    width: 100%;
    padding: 10px;
    font-size: 1em;
    font-weight: 400;
    outline: none;
    border: 1px solid #111;
    border-radius: 5px;
    resize: none;
  }
  
  .contact-form .input-box .send-btn{
    color: #fff;
    background: #3a6cf4;
    display: inline-block;
    font-size: 1.1em;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 2px;
    width: 100%;
    border: none;
    cursor: pointer;
    transition: 0.5s ease;
  }
  
  .contact-form .input-box .send-btn:hover{
    background: #235bf6;
  }

  /* Added CSS for Opening Hours similar to Contact section */
  .opening-hours .content {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    flex-direction: column;
    margin-top: 20px;
  }
  .opening-hours .content p {
      color: white;
      font-size: 1.1em;
      margin: 10px 0;
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

</header>
<!-- Added Opening Hours section -->

<section class="contact" id="contact">
        <div class="title reveal">
          <h2 class="section-title">Contact Me</h2>
        </div>
        <div class="content">
          <div class="row">
            <div class="card reveal">
              <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="info">
                <h3>Address</h3>
                <span>Rajeswari Vedachalam Government Arts College,</span><br>
                <span>Department of Computer Science</span>
              </div>
            </div>
            <div class="card reveal">
              <div class="contact-icon">
                <i class="fas fa-phone"></i>
              </div>
              <div class="info">
                <h3>Phone</h3>
                <span>1234567890</span>
              </div>
            </div>
            <div class="card reveal">
              <div class="contact-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div class="info">
                <h3>Email Address</h3>
                <span>contact@email.com</span>
              </div>
            </div>
            <div class="card reveal">
              <div class="contact-icon">
                <i class="fas fa-globe"></i>
              </div>
              <div class="info">
                <h3>Website</h3>
                <span>Book Hive.com</span>
              </div>
            </div>
            <div class="card reveal">
              <div class="contact-icon">
                <i class="fas fa-clock"></i>
              </div>
              <div class="info">
                <h3>Opening Time</h3>
                <span>
                  Monday - Friday: 9:00 AM - 8:00 PM
                  Saturday: 10:00 AM - 6:00 PM
                  Sunday: Closed
                </span>
              </div>
            </div>
          </div>
      
            </div>
          </div>
        </div>
      </section>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
