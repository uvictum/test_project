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
                Technical Test
            </h1>
            <p class="subtitle">
                Choose the test you want to complete!
            </p>
            <form class="column is-half is-offset-3" method="post" action="/">
                <div class="field has-addons has-addons-centered">
                    <p class="control">
                        <input class="input" type="text" name="Username" placeholder="Enter Your Name" required>
                    </p>
                    <p class="control">
                        <span class="select">
                            <select name="Testname" id="test" required>
                                <option value="">Choose Test</option>
                                <?php foreach ($tests as $test) {
                                    echo "<option value=\"$test\">$test</option>";
                                }?>
                            </select>
                        </span>
                    </p>
                    <p class="control">
                        <button id="start" class="button is-primary">Start</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
</body>
</html>