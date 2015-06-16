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
    </head>
    <body>

        <div class="container text-center">
            <h1>Twitter User Activity On Hours</h1>
            <br />
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="username">Username:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" placeholder="Enter username">
                    </div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
           <img id="histogram" />
        </div>
       

    </body>
</html>