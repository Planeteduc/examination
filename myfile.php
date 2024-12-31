<?php
session_start();

$correct_password = "securepassword123";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $password = $_POST['password'] ?? '';
    
    if ($password == $correct_password) {
        $score = $_SESSION['quizScore'] ?? 'N/A';
        $total = $_SESSION['quizTotal'] ?? 'N/A';
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
        exit();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quiz_submit'])) {
    $questions = [
        [
            "question" => "What does RAM stand for?",
            "options" => ["Random Access Memory", "Read Access Memory", "Run Access Memory", "Real Access Memory"],
            "correctAnswer" => "Random Access Memory"
        ],
        [
            "question" => "Which of the following is a storage device?",
            "options" => ["Monitor", "Printer", "Hard Disk", "Keyboard"],
            "correctAnswer" => "Hard Disk"
        ],
        // Add more questions as needed
    ];

    $score = 0;
    foreach ($questions as $index => $question) {
        $selectedAnswer = $_POST['answer' . $index] ?? '';
        if ($selectedAnswer == $question['correctAnswer']) {
            $score++;
        }
    }

    $_SESSION['quizScore'] = $score;
    $_SESSION['quizTotal'] = count($questions);

    header("Location: " . $_SERVER['PHP_SELF'] . "?action=password");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        .container form input[type="text"], .container form input[type="password"], .container form input[type="radio"] {
            margin-bottom: 10px;
        }
        .container form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['action']) && $_GET['action'] == 'password'): ?>
            <h1>Enter Password</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Submit">
            </form>
            <?php if (isset($_GET['error'])): ?>
                <p class="error">Incorrect password. Please try again.</p>
            <?php endif; ?>
        <?php elseif (isset($score) && isset($total)): ?>
            <h1>Quiz Results</h1>
            <p>Your Score: <?php echo htmlspecialchars($score); ?> / <?php echo htmlspecialchars($total); ?></p>
        <?php else: ?>
            <h1>Quiz</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php
                $questions = [
                    [
                        "question" => "What does RAM stand for?",
                        "options" => ["Random Access Memory", "Read Access Memory", "Run Access Memory", "Real Access Memory"],
                        "correctAnswer" => "Random Access Memory"
                    ],
                    [
                        "question" => "Which of the following is a storage device?",
                        "options" => ["Monitor", "Printer", "Hard Disk", "Keyboard"],
                        "correctAnswer" => "Hard Disk"
                    ],
                    [
                        "question" => "Which of the following is a storage device?",
                        "options" => ["Monitor", "Printer", "Hard Disk", "Keyboard"],
                        "correctAnswer" => "Hard Disk"
                    ],
                    [
                        "question" => "Which of the following is a storage device?",
                        "options" => ["Monitor", "Printer", "Hard Disk", "Keyboard"],
                        "correctAnswer" => "Hard Disk"
                    ],

                    
                    // Add more questions as needed
                ];

                foreach ($questions as $index => $question): ?>
                    <p class="font-semibold"><?php echo ($index + 1) . '. ' . htmlspecialchars($question['question']); ?></p>
                    <?php foreach ($question['options'] as $option): ?>
                        <label>
                            <input type="radio" name="answer<?php echo $index; ?>" value="<?php echo htmlspecialchars($option); ?>" required> 
                            <?php echo htmlspecialchars($option); ?>
                        </label>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <input type="submit" name="quiz_submit" value="Submit">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
