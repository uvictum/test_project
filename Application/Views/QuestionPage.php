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
                Question <?php echo $questionNum ?>
            </h1>
            <p class="subtitle">
                <?php echo $this->Question->QuestionData['QuestionText']?>
            </p>
            <form class="column is-half is-offset-3" method="post" action="/">
                <div class="field is-grouped is-grouped-multiline">
                    <?php foreach ($this->Question->QuestionData['Answers'] as $item) {
                        echo "<p class=\"control has-text-centered\">";
                        echo '<button name="Answer" value="'. $item['ID'] .'" class="button is-link">'.$item['Answer'];
                        echo "</button></p>";
                    }?>
                </div>
                <br>
                <progress value="<?php echo $percent ?>" max="100" class="progress is-primary"></progress>
            </form>
        </div>
    </div>
</section>
</body>
</html>