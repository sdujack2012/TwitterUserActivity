<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Twitter User Activity On Hours</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="./js/functions.js"></script>
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>

        <div class="container text-center">
            <h1>Twitter User Activity On Hours</h1>
            <br />
            <form class="form-horizontal form-inline" role="form">
                <div class="form-group">
                    <label for="text">Screen Name:</label>
                    <input type="text" class="form-control" id="username" placeholder="Please enter screen name">
                </div>
                <button type="button" id="submit" class="btn btn-default">Submit</button>

            </form>
            <br />
            <img id="histogram" />
        </div>


    </body>
</html>