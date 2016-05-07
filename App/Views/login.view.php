<html>
{{HEAD}}
<body>
{{HEADER}}
<h2>login</h2>
<span>
    <form id="login_form">
        <input name="email" type="email" placeholder="email-address" required>
        <input name="pass" type="password" placeholder="password" required>
        <input type="submit" value="login">
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            var form = $('#login_form');
            form.on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url : '/user/login',
                    data : form.serialize(),
                    method: 'POST',
                    success: function(response){
                        if(response == 'ok'){
                            window.location.href = '/profile'
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