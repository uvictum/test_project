<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="/styles/main.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
<section class="hero is-fullheight">
    <div class="hero-body">
        <div class="container  has-text-centered">
            <h1 class="title">
                Thank you, <?php echo $this->User->Username ?>
            </h1>
            <p class="subtitle">
                You answered correctly on <?php echo $this->User->Result ." from " .$this->Test->QuestionTotal ?>
                questions!
            </p>
        </div>
    </div>
</section>
</body>
</html>