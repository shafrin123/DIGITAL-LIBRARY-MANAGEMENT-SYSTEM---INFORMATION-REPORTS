<?php
// db.php
$host = 'localhost';
$dbname = 'login';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="Categories.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .new-navigation ul {
            list-style: none;
            display: flex;
            gap: 15px;
            padding: 0;
            margin: 0;
            margin-left: 50%;
        }

        .new-navigation ul li {
            display: inline;
        }

        .new-navigation ul li a {
            color: white;
            font-size: 1em;
            text-decoration: none;
            font-weight: 500;
            margin-left: 30px;
        }

        .new-navigation ul li a:hover {
            color: #007bff;
        }

        .category {
            margin-bottom: 30px;
        }

        .category h2 {
            margin-top: 20px;
            color: #333;
        }

        .category ul {
            list-style: disc inside;
            margin-left: 15px;
        }

        /* Fixed style for the brand class */
        header .brand {
            font-family: Arial, sans-serif;
            font-size: 2em;
            margin-top: 10px;
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
<header>
        <a href="" class="brand" >Book Hive</a>
        <div class="menu-btn"></div>
        <div class="navigation">
            <a href="MAIN.php" >Home</a>
            <a href="Bookavail.php">Pre-booking</a>
            <a href="Categories.php" >Book Categories</a>
            <a href="Library Information.php" >Library Information</a>
            <a href="Feed.php">Feedback</a>
            
        </div>
    </header>
<div class="container">
    <h1>Computer Science Book Categories</h1>
    <div class="categories">
        <!-- Category A -->
        <div class="category">
            <h2>A</h2>
            <ul>
                <li>A first course in artificial intelligence</li>
                <li>Active server pages</li>
                <li>AD-HOC wireless network architecture and protocol</li>
                <li>An intro for formal lang and automata</li>
                <li>An Introduction of XML & web technologies</li>
                <li>An Introduction to Database system -8th edition</li>
                <li>Analysis in a big data world</li>
                <li>Applied statistics</li>
                <li>Artificial intelligence</li>
                <li>Artificial intelligence 3rd edition</li>
                <li>Artificial intelligence 3rd edition a modern approach</li>
                <li>Artificial neutral network</li>
            </ul>
        </div>
        <!-- Category B -->
        <div class="category">
            <h2>B</h2>
            <ul>
                <li>Big data</li>
                <li>Big data analytics</li>
            </ul>
        </div>
        <!-- Category C -->
        <div class="category">
            <h2>C</h2>
            <ul>
                <li>CC course on computer concept study guide</li>
                <li>client server computing</li>
                <li>client server computing 2 nd version</li>
                <li>cloud computing</li>
                <li>cloud computing A Hands-on-approach</li>
                <li>Cloud computing web based applications the change the world</li>
                <li>compiler design</li>
                <li>compiler desiner techniques and tools 2nd edition</li>
                <li>computer application in business</li>
                <li>computer graphic c version</li>
                <li>computer graphic with openGL  4edition</li>
                <li>computer graphics</li>
                <li>Computer network</li>
                <li>computer network 5 th edition</li>
                <li>computer network a system approach</li>
                <li>Computer network with Internet protocols</li>
                <li>computer organisation and architecture</li>
                <li>Computer science question banks</li>
                <li>computer system architecture revised 3rd edition</li>
                <li>conceptual programing tips for Interview</li>
                <li>Core Java</li>
                <li>Core java v/2 advance futures 8edition</li>
                <li>cracking IT campus interview</li>
                <li>cracking IT interviews</li>
                <li>cryptography and network security</li>
                <li>cryptography and network security</li>
            </ul>
        </div>
        <!-- Category D -->
        <div class="category">
            <h2>D</h2>
            <ul>
                <li>Data communication and any</li>
                <li>Data communication and networking</li>
                <li>Data communication and networking 2nd edition</li>
                <li>Data mining & Data warehouse</li>
                <li>Data mining concept and techniques 3 rd edition</li>
                <li>data network design</li>
                <li>Data science and machine learning interview questions</li>
                <li>Data structure and Analysis</li>
                <li>Data structure and Analysis of c++</li>
                <li>Data structure using C</li>
                <li>Database management system</li>
                <li>Database management system 3rd edition</li>
                <li>Database system concepts</li>
                <li>Database system using Oracle</li>
                <li>Deep learning with c#,.net and kelp.net</li>
                <li>Dictionary of computing.</li>
                <li>Digital electronic*Microprocessor</li>
                <li>digital fundamentals</li>
                <li>digital image processing</li>
                <li>Digital image processing 3 rd edition</li>
                <li>digital logic and computer design</li>
                <li>Discrete mathematical structure with application to computer science</li>
                <li>Discrete mathematics</li>
                <li>Distributed database principle system</li>
            </ul>
        </div>
        <!-- Category E -->
        <div class="category">
            <h2>E</h2>
            <ul>
                <li>Enterprise Javabeans</li>
            </ul>
        </div>
        <!-- Category F -->
        <div class="category">
            <h2>F</h2>
            <ul>
                <li>fundamentals of algorithms</li>
                <li>fundamentals of computer algorithm</li>
                <li>Fundamentals of data structure</li>
                <li>Fundamentals of data structure in c++</li>
                <li>Fundamentals of mathematical statistics</li>
                <li>fundamentals of software engineering</li>
            </ul>
        </div>
        <!-- Category G -->
        <div class="category">
            <h2>G</h2>
            <ul>
                <li>General knowledge 2018</li>
                <li>general knowledge of current affairs</li>
            </ul>
        </div>
        <!-- Category H -->
        <div class="category">
            <h2>H</h2>
            <ul>
                <li>HTML '5 Developer's work book</li>
                <li>HTML css and Javascript</li>
            </ul>
        </div>
        <!-- Category I -->
        <div class="category">
            <h2>I</h2>
            <ul>
                <li>information systems security</li>
                <li>insight in to data mining theory and practice</li>
                <li>Internet of things</li>
                <li>Internet of things A Hands-on-approach</li>
                <li>Introduction to algorithm</li>
                <li>Introduction to artificial intelligence & expert system</li>
                <li>Introduction to automata theory lang and concepts</li>
                <li>Introduction to Computer security</li>
                <li>Introduction to computing security</li>
                <li>Introduction to data mining</li>
                <li>Introduction to data mining with case studies</li>
                <li>introduction to java programming</li>
            </ul>
        </div>
        <!-- Category J -->
        <div class="category">
            <h2>J</h2>
            <ul>
                <li>Java-2 The complete Reference</li>
                <li>Java/J2EE interview questions</li>
            </ul>
        </div>
        <!-- Category L -->
        <div class="category">
            <h2>L</h2>
            <ul>
                <li>Let us c</li>
            </ul>
        </div>
        <!-- Category M -->
        <div class="category">
            <h2>M</h2>
            <ul>
                <li>Management information systems 10 edition</li>
                <li>Mastering Active server pages</li>
                <li>Mastering of jsp a server side technology</li>
                <li>mathematical statistics</li>
                <li>Microprocessor and microcontroller</li>
                <li>Microprocessor Architecture programming and application</li>
                <li>Microsoft visual basic 2010</li>
                <li>Mobile Communications</li>
            </ul>
        </div>
        <!-- Category O -->
        <div class="category">
            <h2>O</h2>
            <ul>
                <li>object oriented analysis and its application</li>
                <li>object oriented design and analysis</li>
                <li>object oriented programming in c++</li>
                <li>object oriented system development</li>
                <li>objective -Ugc NET/JRF/SET</li>
                <li>objective c Phrase book</li>
                <li>operating system concept</li>
                <li>operating system concept -sixth edition</li>
                <li>operating system concept -Third edition</li>
                <li>operating system principles</li>
            </ul>
        </div>
        <!-- Category P -->
        <div class="category">
            <h2>P</h2>
            <ul>
                <li>Php and MySQL web development a beginner's guide</li>
                <li>practical handbook for machine learning</li>
                <li>pricipel of computer design</li>
                <li>principle of compiler design</li>
                <li>principles of mobile computing</li>
                <li>problem solving and programming with python</li>
                <li>programming in Ansi C</li>
                <li>programming in C</li>
                <li>programming in java</li>
                <li>programming with java</li>
                <li>programming with java 4 th edition</li>
                <li>Programming with java a primer</li>
            </ul>
        </div>
        <!-- Category Q -->
        <div class="category">
            <h2>Q</h2>
            <ul>
                <li>quantitative aptitude</li>
            </ul>
        </div>
        <!-- Category S -->
        <div class="category">
            <h2>S</h2>
            <ul>
                <li>security in computing</li>
                <li>security in computing 4 th edition</li>
                <li>Software engineering 6th edition</li>
                <li>Software engineering concepts</li>
                <li>software Testing principles techniques and tools</li>
                <li>software Testing techniques</li>
                <li>software Testing tools</li>
                <li>Statistical methods</li>
                <li>systems programming</li>
            </ul>
        </div>
        <!-- Category T -->
        <div class="category">
            <h2>T</h2>
            <ul>
                <li>The complete Reference c++</li>
                <li>The complete Reference of HTML</li>
                <li>The complete Reference of JAVA</li>
                <li>The complete Reference visual basic -6</li>
                <li>The design and analysis of computer algorithm</li>
                <li>The UNIX programming environment</li>
                <li>Theory of computation</li>
                <li>Think python</li>
            </ul>
        </div>
        <!-- Category U -->
        <div class="category">
            <h2>U</h2>
            <ul>
                <li>ugc net/jrf/set computer science and apply paperll</li>
            </ul>
        </div>
        <!-- Category V -->
        <div class="category">
            <h2>V</h2>
            <ul>
                <li>value education</li>
                <li>visual basic 6 from the ground up</li>
                <li>visual basic 6 programming</li>
                <li>Visual basics 6.0</li>
            </ul>
        </div>
        <!-- Category W -->
        <div class="category">
            <h2>W</h2>
            <ul>
                <li>web embedded commercial applications Html, javascript,DHTML and php</li>
                <li>Web enabled commercial applications development Html</li>
                <li>Web technology</li>
            </ul>
        </div>
        <!-- Category . (Dot) -->
        <div class="category">
            <h2>. (Dot)</h2>
            <ul>
                <li>.Net Interview questions</li>
            </ul>
        </div>
        <!-- Category Numbers -->
        <div class="category">
            <h2>Numbers</h2>
            <ul>
                <li>8085 Microprocessor and its application</li>
            </ul>
        </div>
    </div>
</div>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>