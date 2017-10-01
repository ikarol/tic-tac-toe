<!DOCTYPE html>
<html>
<head>
    <title>Tic tac toe</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="col-md-4 col-md-offset-4">
            <table id="board" class="table table-bordered text-center">
                <tr>
                    <td id="0, 0" class="col-md-1">&nbsp;</td>
                    <td id="0, 1" class="col-md-1">&nbsp;</td>
                    <td id="0, 2" class="col-md-1">&nbsp;</td>
                </tr>
                <tr>
                    <td id="1, 0" class="col-md-1">&nbsp;</td>
                    <td id="1, 1" class="col-md-1">&nbsp;</td>
                    <td id="1, 2" class="col-md-1">&nbsp;</td>
                </tr>
                <tr>
                    <td id="2, 0" class="col-md-1">&nbsp;</td>
                    <td id="2, 1" class="col-md-1">&nbsp;</td>
                    <td id="2, 2" class="col-md-1">&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#board").on("click", "td", function() {
                var self = this;
                $.ajax({
                    url: '/p1_turn/',
                    type: 'POST',
                    dataType: 'json',
                    data: {cell: $( self ).attr('id')},
                    beforeSend: function(xhr){
                        xhr.withCredentials = true;
                    }
                })
                .done(function(response) {
                    if (response.status === 205) {
                        $.get('/gameover', function(data) {
                            alert('Draw');
                        });
                    } else {
                        console.log("success");
                        $(self).text('X');
                    }
                })
                .fail(function(response) {
                    if (response.status === 403) {
                        alert('Cell is not empty');
                    }
                    console.log(response);
                });
            });
        });
    </script>
</body>
</html>
