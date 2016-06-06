<html>
{{HEAD}}
<body>
{{HEADER}}
<span>
    <form id="login_form">
        <h2>login</h2>
        <input id="email" name="email" type="email" placeholder="email-address" required>
        <br>
        <input id="pass" name="pass" type="password" placeholder="password" required>
        <br>
        <input id="pass_rep" type="submit" value="login">
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            var form = $('#login_form');
            form.on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url : '/users/login',
                    data : form.serialize(),
                    method: 'POST',
                    success: function(response){
                        if(response == 'ok'){
                            window.location.href = '/users'
                        }else{
                            alert(response);
                        }
                    }
                });
            });
        });
    </script>
</span>
</body>
</html>
