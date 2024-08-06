<?php
include 'auth.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Employee Learning Portal</title>
    
</head>


<body>
<div class="navbar">
        <div class="logo">
            <a href="index.php">Supermart Admin</a>
        </div>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="inventoryManagement.php">Inventory</a>
            <a href="promotions.php">Promotions</a>
            <a href="employees.php">Employees</a>
        </div>
        <button class="logout-btn" onclick=Logout()>Logout</button>
    </div>

    <main class="container">
        <section class="video-section">
            <video controls>
                <source src="Untitled design.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>

        <section class="quiz-section">
            <div class="quiz-container" id="quiz">
                <div class="question" id="question">Question text goes here...</div>
                <ul class="options" id="options"></ul>
                <input type="text" id="fill-in-the-blank" class="fill-in-the-blank" placeholder="Type your answer here">
                <div class="matching-container" id="matching-container"></div>
                <button id="submit">Submit Answer</button>
            </div>
            <div class="progress-container">
                <div id="progress-bar" class="progress-bar"></div>
            </div>
        </section>

        <section class="video-section">
            <video controls>
                <source src="Untitled design.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>
        <H1>ALL DONE</H1>
        <h4>Please exit the page....</h4>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ALLIN1 Australia. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: auto;
        overflow: hidden;
    }

    .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #ffffff;
            color: #000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
        }

        .navbar .logo a {
            color: #D52B1E;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            color: #000;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #D52B1E;
        }

        .navbar .logout-btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #D52B1E;
            color: #fff;
            transition: background-color 0.3s ease;

        }

        .navbar .logout-btn:hover {
            background-color: #b2241b;
        }

    /* Main Styles */
    main {
        margin-top: 20px;
    }

    .video-section,
    .quiz-section {
        margin-bottom: 40px;
    }

    video {
        display: block;
        max-width: 100%;
        margin: 20px auto;
    }

    /* Quiz Styles */
    .quiz-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }

    .question {
        font-size: 20px;
        margin-bottom: 20px;
    }

    .options {
        list-style-type: none;
        padding: 0;
        margin-bottom: 20px;
    }

    .options li {
        margin-bottom: 10px;
        cursor: pointer;
        padding: 10px;
        background-color: #e4e4e4;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .options li:hover {
        background-color: #d4d4d4;
    }

    .fill-in-the-blank {
        display: none;
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .matching-container {
        display: none;
        margin-bottom: 20px;
    }

    .matching-item {
        padding: 10px;
        margin: 5px;
        background-color: #e4e4e4;
        border-radius: 5px;
        display: inline-block;
        cursor: pointer;
    }

    .submit {
        background-color: #ec1018;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        display: block;
        width: 100%;
    }

    button:hover {
        opacity: 0.8;
    }

    /* Progress Bar Styles */
    .progress-container {
        width: 100%;
        background-color: #ddd;
        border-radius: 15px;
        margin: 20px 0;
    }

    .progress-bar {
        width: 0;
        height: 30px;
        background-color: #4CAF50;
        text-align: center;
        line-height: 30px;
        color: white;
        border-radius: 15px;
        transition: width 0.4s ease-in-out;
    }

    /* Footer Styles */
    footer {
        background: #333;
        color: white;
        text-align: center;
        padding: 10px 0;
    }
</style>

<script>
    const quizQuestions = [
        {
            type: "multiple-choice",
            question: "What's the most popular fruit sold in our supermarket?",
            options: ["Apples", "Bananas", "Oranges", "Grapes"],
            answer: "Bananas"
        },
        {
            type: "multiple-choice",
            question: "Which aisle has the cleaning supplies?",
            options: ["Aisle 1", "Aisle 3", "Aisle 5", "Aisle 7"],
            answer: "Aisle 5"
        },
        {
            type: "fill-in-the-blank",
            question: "What color are the store uniforms?",
            answer: "Red"
        },
        {
            type: "matching",
            question: "Match the departments with their respective managers.",
            pairs: [
                { item1: "Produce", item2: "John Doe" },
                { item1: "Bakery", item2: "Jane Smith" }
            ]
        },
        // Add more questions as needed
    ];

    let currentQuestionIndex = 0;
    let correctAnswers = 0;
    let selectedPair = [];

    const questionElement = document.getElementById('question');
    const optionsElement = document.getElementById('options');
    const fillInTheBlankElement = document.getElementById('fill-in-the-blank');
    const matchingContainer = document.getElementById('matching-container');
    const submitButton = document.getElementById('submit');
    const progressBar = document.getElementById('progress-bar');

    function showQuestion(questionIndex) {
        const questionData = quizQuestions[questionIndex];
        questionElement.textContent = questionData.question;

        // Hide all inputs initially
        optionsElement.style.display = 'none';
        fillInTheBlankElement.style.display = 'none';
        matchingContainer.style.display = 'none';

        if (questionData.type === "multiple-choice") {
            optionsElement.style.display = 'block';
            optionsElement.innerHTML = '';
            questionData.options.forEach(option => {
                const li = document.createElement('li');
                li.textContent = option;
                li.onclick = selectOption;
                optionsElement.appendChild(li);
            });
        } else if (questionData.type === "fill-in-the-blank") {
            fillInTheBlankElement.style.display = 'block';
            fillInTheBlankElement.value = '';
        } else if (questionData.type === "matching") {
            matchingContainer.style.display = 'block';
            matchingContainer.innerHTML = '';
            const items = [...questionData.pairs.map(pair => pair.item1), ...questionData.pairs.map(pair => pair.item2)];
            items.sort(() => Math.random() - 0.5); // Shuffle items

            items.forEach(item => {
                const div = document.createElement('div');
                div.className = 'matching-item';
                div.textContent = item;
                div.onclick = selectMatchingItem;
                matchingContainer.appendChild(div);
            });
        }
    }

    function selectOption(event) {
        const selectedOption = event.target.textContent;
        const correctAnswer = quizQuestions[currentQuestionIndex].answer;
        if (selectedOption === correctAnswer) {
            alert('Correct!');
            correctAnswers++;
            updateProgressBar();
        } else {
            alert('Wrong answer');
        }
        nextQuestion();
    }

    function submitFillInTheBlank() {
        const answer = fillInTheBlankElement.value.trim();
        const correctAnswer = quizQuestions[currentQuestionIndex].answer;
        if (answer.toLowerCase() === correctAnswer.toLowerCase()) {
            alert('Correct!');
            correctAnswers++;
            updateProgressBar();
        } else {
            alert('Wrong answer');
        }
        nextQuestion();
    }

    function selectMatchingItem(event) {
        const selectedItem = event.target.textContent;
        selectedPair.push(selectedItem);
        if (selectedPair.length === 2) {
            const pairs = quizQuestions[currentQuestionIndex].pairs;
            const isCorrectPair = pairs.some(pair =>
                (pair.item1 === selectedPair[0] && pair.item2 === selectedPair[1]) ||
                (pair.item1 === selectedPair[1] && pair.item2 === selectedPair[0])
            );
            if (isCorrectPair) {
                alert('Correct pair!');
                correctAnswers++;
                updateProgressBar();
            } else {
                alert('Wrong pair');
            }
            selectedPair = [];
            nextQuestion();
        }
    }

    function updateProgressBar() {
        const progress = ((currentQuestionIndex + 1) / quizQuestions.length) * 100;
        progressBar.style.width = progress + '%';
        progressBar.textContent = Math.round(progress) + '%';
    }

    function nextQuestion() {
        currentQuestionIndex++;
        if (currentQuestionIndex < quizQuestions.length) {
            showQuestion(currentQuestionIndex);
        } else {
            alert('Quiz completed! You got ' + correctAnswers + ' correct answers out of ' + quizQuestions.length);
        }
    }

    submitButton.addEventListener('click', () => {
        const questionData = quizQuestions[currentQuestionIndex];
        if (questionData.type === "fill-in-the-blank") {
            submitFillInTheBlank();
        } else if (questionData.type === "matching" && selectedPair.length !== 2) {
            alert('Please select two items to match');
        }
    });

    showQuestion(currentQuestionIndex);

</script>